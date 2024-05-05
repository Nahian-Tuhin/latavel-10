<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions=auth()->user()->transactions()->filter()->paginate(10);
        return view('transactions.index', [
            'transactions' => $transactions
        ]);
    }
    public function deposit()
    {
        return view('transactions.deposit');
    }
    public function addDeposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|min:0.001|numeric',
        ]);

        try {
            DB::beginTransaction();
            auth()->user()->increment('balance', $request->amount);
            $transactions = new Transaction();
            $transactions->user_id = auth()->user()->id;
            $transactions->transaction_type = 'Deposit';
            $transactions->amount = $request->amount;
            $transactions->date = now();
            $transactions->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            info($th);
            return back()->with([
                'status' => 'something went wrong'
            ]);
        }

        return back()->with([
            'status' => 'Deposit Added'
        ]);

    }

    public function withdraw(Request $request)
    {
        return view('transactions.withdraw');
    }
    public function makeWithdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|min:0.001|numeric',
        ]);

        $sum= auth()->user()->Withdraw()->sum('amount');
        $individualRate = 0.015;
        $businessRate = auth()->user()->account_type == 'Business'&&  $sum > 50000  ?  0.015 : 0.025   ;
        $freeFirst5KPerMonth=auth()->user()->Withdraw()->whereMonth('created_at',date('m'))->sum('amount');
        $freeFriday = (date('N') == 5);
        if($sum < 1000){
        $amount= $request->amount > 1000 ?  $request->amount - 1000 : 0  ;
        }

        if ($freeFriday|| $freeFirst5KPerMonth < 5000 || $amount == 0) {
            $fee= 0;
        }


        if(auth()->user()->account_type == 'Business'){
        $fee  = $amount * $businessRate;
        } else{
            $fee  =$amount * $individualRate;
        }
        $totallFee = $amount + $fee;


        if(auth()->user()->balance < $totallFee ){
            return back()->with([
                'status' => 'insufficient Balance'
            ]);
        }
        else{
            try {
                DB::beginTransaction();
                auth()->user()->decrement('balance', $request->amount);
                $transactions = new Transaction();
                $transactions->user_id = auth()->user()->id;
                $transactions->transaction_type = 'Withdraw';
                $transactions->amount = $request->amount;
                $transactions->date = now();
                $transactions->fee = $fee;
                $transactions->save();
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                info($th);
                return back()->with([
                    'status' => 'something went wrong'
                ]);
            }
            }

            return back()->with([
                'status' => 'Withdraw Successfull'
            ]);
        }





}

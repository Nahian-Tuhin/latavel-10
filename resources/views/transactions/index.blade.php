@extends('layouts.app')

@section('title', 'Transaction List')

@section('content')
    <section class="p-3" style="min-height:calc(100vh - 112px)">
        <div class="message"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title m-0 float-left">Transaction List</h3>

                            <div class="float-right">
                                <h3>
                                    Balance : {{ auth()->user()->balance }}

                                </h3>
                            </div>
                            <a href="{{ route('transactions.deposit') }}" class="btn btn-success ml-2 mr-2 float-right">Add Deposit</a>

                            <a href="{{ route('transactions.withdraw') }}" class="btn btn-info float-right">WithDraw</a>
                            <div class="float-right">
                                <form id="transactionForm" action="{{ route('transactions.index') }}" method="get" class="form-inline">
                                    <div class="input-group">

                                         <div class="float-right mr-2">
                                             <div class="input-group">
                                                 <select class="form-control" id="transaction_type" name="transaction_type">
                                                     <option value="all">All</option>
                                                     <option  {{ request()?->transaction_type == 'Deposit' ? 'selected' : '' }} value="Deposit">Deposit</option>
                                                     <option {{ request()?->transaction_type == 'Withdraw' ? 'selected' : '' }} value="Withdraw">Withdraw</option>
                                                 </select>
                                             </div>
                                         </div>


                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="card-body">
                            @if(Session::has('status'))
                                <p class="alert  mb-3 mt-3 {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('status') }}</p>
                            @endif
                            <table class="table table-bordered">
                                <thead>
                                <tr>

                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Fee</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $key => $row)
                                    <tr>



                                        <td>
                                            {{  $key + $transactions->keys()->first()  }}
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($row->date)->format("d-M-Y")}}
                                        </td>
                                        <td> {{$row->transaction_type}}
                                        </td>
                                        <td>{{ $row->amount }}</td>
                                        <td>
                                            {{ $row->fee }}
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $transactions->links('pagination::bootstrap-4'); }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#transaction_type').on('change', function() {
            $('#transactionForm').submit();
        });
    });
</script>
@endsection

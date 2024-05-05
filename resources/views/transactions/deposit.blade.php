@extends('layouts.app')

@section('title', 'Add Deposit')

@section('content')
    <section class="p-3" style="min-height:calc(100vh - 112px)">
        <div class="message"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title m-0 float-left">Add Deposit</h3>

                            <div class="float-right ml-2 mr-3">
                                <h3>
                                    Balance : {{ auth()->user()->balance }}

                                </h3>
                            </div>
                            <a href="{{ route('transactions.withdraw') }}" class="btn btn-info float-right">WithDraw</a>
                        </div>
                    </div>

                </div>
                @if(Session::has('status'))
                <p id="hide" class="alert mt-3 mb-3 {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('status') }}</p>
            @endif
                <div  class="col-md-12">
                    <form action="{{ route('transactions.add_deposit') }}" method="post">
                        @method('POST')
                        @csrf
                        <div class="form-group mt-2">
                            <label for="exampleInputEmail1">Add Deposit</label>
                            <input type="number" step=".001" min=0 max="999999999" name="amount" required class="form-control"  id="exampleInputEmail1" value="{{ old('email') }}"  placeholder="Amount" >
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script>

</script>
@endsection

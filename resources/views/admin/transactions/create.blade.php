@php use App\Models\BankAccount; @endphp
@php use App\Models\Accounts; @endphp
@php use App\Models\Countries; @endphp

@extends('admin.layouts.master')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Register New Transaction</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Please enter transaction information</h5>
                        <form action="{{ route('admin.transactions.store') }}" method="POST">
                            @csrf


                            <div class="row mb-4">
                                <div class="col-lg-4 col-xl-4">
                                    <label for="bank_id" class="form-label">Bank Name</label>
                                    <select class="form-select" id="bank_id" name="bank_id" onchange="get_ex_rate(this.value);" required >
                                        <option value="">Select</option>
                                        @foreach(BankAccount::orderBy('bank_name')->get() as $p)
                                            <option value="{{ $p->id }}"  >{{ $p->bank_account_title }} [{{ $p->bank_name }}] [{{ $p->bank_currency }}]</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="bank_id" class="form-label">Account Name</label>
                                    <select class="form-select" id="account_id" name="account_id" required >
                                        <option value="">Select</option>
                                        @foreach(Accounts::orderBy('account_name')->get() as $p)
                                            <option value="{{ $p->id }}"  >{{ $p->account_name }} [{{ $p->account_type }}]</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="transaction_date" class="form-label">Date</label>
                                    <input type="date" placeholder="" class="form-control" id="transaction_date" name="transaction_date" value="{{ empty(old('transaction_date')) ? date("Y-m-d")  : old('transaction_date') }}" required>
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="type" class="form-label">Type</label>
                                    <select class="form-select" id="type" name="type" required >
                                        <option value="CR">CR</option>
                                        <option value="DR">DR</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-8 col-xl-8">
                                    <label for="reference" class="form-label">Reference</label>
                                    <input type="reference" placeholder="" class="form-control" id="reference" name="reference" value="{{ old('reference') }}">
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="transaction_pdf" class="form-label">Transaction Invoice/PDF</label>
                                    <input type="file" class="form-control" id="transaction_pdf" name="transaction_pdf"  value="{{ old('transaction_pdf') }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-2 col-xl-2">
                                    <label for="transaction_amount" class="form-label">Transaction Amount</label>
                                    <input type="text" placeholder="" class="form-control" id="transaction_amount" onkeyup="update_final_amount();" name="transaction_amount"  value="{{ old('transaction_amount')  }}" required>
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="bank_charges" class="form-label">Bank Charges</label>
                                    <input type="text" placeholder="" class="form-control" id="bank_charges" onkeyup="update_final_amount();" name="bank_charges"  value="{{ old('bank_charges')  }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="final_amount" class="form-label">Final Amount</label>
                                    <input type="text" placeholder="" class="form-control" id="final_amount" name="final_amount" readonly value="{{ old('final_amount')  }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="ex_rate" class="form-label">Ex-Rate</label>
                                    <input type="text" placeholder="" class="form-control" id="ex_rate" name="ex_rate" readonly value="{{ old('ex_rate')  }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="usd_amount" class="form-label">USD Amount</label>
                                    <input type="text" placeholder="" class="form-control" id="usd_amount" name="usd_amount" readonly value="{{ old('usd_amount')  }}">
                                </div>




                            </div>








                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm rounded" type="submit" name="submit">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


<script>
    function update_final_amount(){
        var transaction_amount = parseFloat($('#transaction_amount').val());
        var bank_charges = parseFloat($('#bank_charges').val());
        var ex_rate = $('#ex_rate').val();
        if(isNaN(transaction_amount)){
            transaction_amount = 0;
        }
        if(isNaN(bank_charges)){
            bank_charges = 0;
        }
        if(isNaN(ex_rate)){
            ex_rate = 0;
        }
        var final_amount = parseFloat(transaction_amount - bank_charges);
        $('#final_amount').val(final_amount);

        var usd_amount = (final_amount / ex_rate).toFixed(2)
        $('#usd_amount').val(usd_amount);

    }



    function get_ex_rate(bank_id){
        @foreach(BankAccount::orderBy('bank_name')->get() as $p)
        if(bank_id == {{$p->id}}){
            if('USD' == '{{$p->bank_currency}}'){
                $('#ex_rate').val(1);
            }else{
                $('#ex_rate').val(143.73);
            }
        }
        @endforeach
        update_final_amount();

    }



</script>

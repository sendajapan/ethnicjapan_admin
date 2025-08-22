@php use App\Models\BankAccount; @endphp
@php use App\Models\Accounts; @endphp
@extends('admin.layouts.master')

@php
    $bank_id = 0;
    $account_id = 0;
    $date_from = date('Y-m-01');
    $date_to = date('Y-m-t');

    if(isset($_REQUEST['bank_id'])){ if($_REQUEST['bank_id']!=''){ $bank_id = $_REQUEST['bank_id']; } }
    if(isset($_REQUEST['account_id'])){ if($_REQUEST['account_id']!=''){ $account_id = $_REQUEST['account_id']; } }
    if(isset($_REQUEST['date_from'])){ if($_REQUEST['date_from']!=''){ $date_from = $_REQUEST['date_from']; } }
    if(isset($_REQUEST['date_to'])){ if($_REQUEST['date_to']!=''){ $date_to = $_REQUEST['date_to']; } }


    $id = last(request()->segments());
    if($type == 'bank'){ if(isset($id)){ if($id!=''){ $bank_id = $id; } } }else if($type == 'account'){ if(isset($id)){ if($id!=''){ $account_id = $id; } } }



@endphp


@section('content')
    <section class="content-main">
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-xxl-12">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="table-responsive p-3">
                            <h1>Statement</h1>

                            <form action="{{ route('admin.transactions.report', ['search', 'submit']) }}" method="POST">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="bank_id" class="form-label">Bank Name</label>
                                        <select class="form-select" id="bank_id" name="bank_id" onchange="get_ex_rate(this.value);" >
                                            <option value="">Select</option>
                                            @foreach(BankAccount::orderBy('bank_name')->get() as $p)
                                                <option {{ $p->id == $bank_id ? 'selected' : '' }} value="{{ $p->id }}"  >{{ $p->bank_account_title }} [{{ $p->bank_name }}] [{{ $p->bank_currency }}]</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="bank_id" class="form-label">Account Name</label>
                                        <select class="form-select" id="account_id" name="account_id" >
                                            <option value="">Select</option>
                                            @foreach(Accounts::orderBy('account_name')->get() as $p)
                                                <option value="{{ $p->id }}"  {{ $p->id == $account_id ? 'selected' : '' }} >{{ $p->account_name }} [{{ $p->account_type }}]</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="transaction_date" class="form-label">Date From</label>
                                        <input type="date" placeholder="" class="form-control" id="date_from" name="date_from" value="{{ empty($date_from) ? date("Y-m-d")  : $date_from }}" required>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="transaction_date" class="form-label">Date To</label>
                                        <input type="date" placeholder="" class="form-control" id="date_to" name="date_to" value="{{ empty($date_to) ? date("Y-m-d")  : $date_to }}" required>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 mt-30">
                                        <button class="btn btn-primary btn-sm rounded" type="submit" name="submit">SEARCH</button>
                                    </div>
                                </div>
                            </form>




                            <div class="row">
                                <div class="col-12">

                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col" colspan="8"></th>
                                            <th class="text-center" scope="col" colspan="2">Net Amount</th>
                                            <th class="text-end" scope="col">USD Transactions</th>
                                            <th scope="col"></th>
                                        </tr>
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Bank</th>
                                            <th scope="col">Account</th>
                                            <th scope="col">Reference</th>
                                            <th scope="col">Invoice/PDF</th>
                                            <th class="text-end" scope="col">Amount</th>
                                            <th class="text-end" scope="col">Bank Charges</th>
                                            <th class="text-end" scope="col">DR</th>
                                            <th class="text-end" scope="col">CR</th>
                                            <th class="text-end" scope="col">Balance</th>
                                            <th class="text-end" scope="col" data-sortable="true">Action</th>
                                        </tr>

                                        </thead>
                                        <tbody>
                                        @php
                                            $balance_amount = 0;
                                            $i=1;
                                            // Merge provider debts with bank transactions and sort by date
                                            $allTransactions = collect($data);
                                            if(isset($providerDebts) && $providerDebts->count() > 0) {
                                                $allTransactions = $allTransactions->merge($providerDebts);
                                            }
                                            $allTransactions = $allTransactions->sortBy('transaction_date');
                                        @endphp
                                        @foreach($allTransactions as $row)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$row->transaction_date}}</td>
                                                <td>{{$row->bank_account_title}} - {{$row->bank_name}}</td>
                                                <td>{{$row->account_name}}</td>
                                                <td>{{$row->reference}}</td>
                                                <td>{{$row->transaction_pdf}}</td>
                                                <td class="text-end">{{$row->transaction_amount >= 0 ? $row->bank_currency : ''}} {{number_format($row->transaction_amount,0)}}</td>
                                                <td class="text-end">{{$row->bank_charges >= 0 ? $row->bank_currency : ''}} {{number_format($row->bank_charges,0)}}</td>
                                                <td class="text-end">{{ $row->type == 'CR' ? $row->bank_currency.' '.number_format($row->final_amount,0) : '' }}</td>
                                                <td class="text-end">{{ $row->type == 'DR' ? $row->bank_currency.' '.number_format($row->final_amount,0) : '' }}</td>
                                                @php
                                                    if($type == 'bank'){
                                                        if($row->type == 'DR') {
                                                            $balance_amount += $row->final_amount;
                                                        } else {
                                                            $balance_amount -= $row->final_amount;
                                                        }
                                                    }else if($type == 'account'){
                                                        if($row->type == 'CR') {
                                                            $balance_amount += $row->final_amount;
                                                        } else {
                                                            $balance_amount -= $row->final_amount;
                                                        }
                                                    } else{
                                                        if($row->type == 'CR') {
                                                            $balance_amount += $row->final_amount;
                                                        } else {
                                                            $balance_amount -= $row->final_amount;
                                                        }
                                                    }
                                                @endphp
                                                <td class="text-end">{{ $balance_amount }}</td>
                                                <td class="text-end">
                                                    @if(isset($row->is_debt) && $row->is_debt)
                                                        <a target="_blank" href="{{route('admin.purchase.edit', $row->shipment_id)}}" class="btn btn-sm font-sm rounded btn-dark">
                                                            <i class="material-icons md-edit fs-6"></i>
                                                        </a>
                                                    @else
                                                        <a target="_blank" href="{{route('admin.transactions.edit',$row->bank_transaction_id)}}" class="btn btn-sm font-sm rounded btn-dark">
                                                            <i class="material-icons md-edit fs-6"></i>
                                                        </a>
                                                        <a href="{{route('admin.transactions.destroy', $row->bank_transaction_id)}}" class="btn btn-sm delete-part-category font-sm rounded btn-danger">
                                                            <i class="material-icons md-delete_forever fs-6"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @php
                                            @endphp
                                        @endforeach
                                        <tfoot>
                                        <tr>
                                            <th class="text-end" colspan="10">Balance</th>
                                            <th class="text-end">{{ number_format($balance_amount) }}</th>
                                            <th class="text-end"></th>
                                        </tr>
                                        </tfoot>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br><hr><br>


                            @if(!empty($data2) && count($data2)>0)
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th scope="col" colspan="8"></th>
                                                <th class="text-center" scope="col" colspan="2">Net Amount</th>
                                                <th class="text-end" scope="col">JPY Transactions</th>
                                                <th scope="col"></th>
                                            </tr>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Bank</th>
                                                <th scope="col">Account</th>
                                                <th scope="col">Reference</th>
                                                <th scope="col">Invoice/PDF</th>
                                                <th class="text-end" scope="col">Amount</th>
                                                <th class="text-end" scope="col">Bank Charges</th>
                                                <th class="text-end" scope="col">DR</th>
                                                <th class="text-end" scope="col">CR</th>
                                                <th class="text-end" scope="col">Balance</th>
                                                <th class="text-end" scope="col" data-sortable="true">Action</th>
                                            </tr>

                                            </thead>
                                            <tbody>
                                            @php
                                                $balance_amount = 0;
                                                $i=1;
                                            @endphp
                                            @foreach($data2 as $row)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$row->transaction_date}}</td>
                                                    <td>{{$row->bank_account_title}} - {{$row->bank_name}}</td>
                                                    <td>{{$row->account_name}}</td>
                                                    <td>{{$row->reference}}</td>
                                                    <td>{{$row->transaction_pdf}}</td>
                                                    <td class="text-end">{{$row->transaction_amount >= 0 ? $row->bank_currency : ''}} {{number_format($row->transaction_amount,0)}}</td>
                                                    <td class="text-end">{{$row->bank_charges >= 0 ? $row->bank_currency : ''}} {{number_format($row->bank_charges,0)}}</td>
                                                    <td class="text-end">{{ $row->type == 'DR' ? $row->bank_currency.' '.number_format($row->final_amount,0) : '' }}</td>
                                                    <td class="text-end">{{ $row->type == 'CR' ? $row->bank_currency.' '.number_format($row->final_amount,0) : '' }}</td>
                                                    <td class="text-end">{{$row->bank_currency }} {{ $row->type == 'CR' ? number_format($balance_amount += $row->final_amount,0) : number_format($balance_amount-=$row->final_amount,0) }}</td>
                                                    <td class="text-end">
                                                        <a target="_blank" href="{{route('admin.transactions.edit',$row->bank_transaction_id)}}" class="btn btn-sm font-sm rounded btn-dark">
                                                            <i class="material-icons md-edit fs-6"></i>
                                                        </a>
                                                        <a href="{{route('admin.transactions.destroy', $row->bank_transaction_id)}}" class="btn btn-sm delete-part-category font-sm rounded btn-danger">
                                                            <i class="material-icons md-delete_forever fs-6"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @php
                                                @endphp
                                            @endforeach
                                            <tfoot>
                                            <tr>
                                                <th class="text-end" colspan="10">Balance</th>
                                                <th class="text-end">{{ number_format($balance_amount) }}</th>
                                                <th class="text-end"></th>
                                            </tr>
                                            </tfoot>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>

    <script>
        function performDeleteRequest(url) {
            $.ajax({
                type: 'DELETE',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: handleDeleteSuccess,
                error: handleDeleteError
            });
        }

        function confirmDelete(url) {
            Swal.fire({
                title: "Are you sure you want to delete this entry?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    performDeleteRequest(url);
                }
            });
        }



        $(document).ready(function () {
            $('body').on('click', '.delete-part-category', function (event) {
                event.preventDefault();
                confirmDelete($(this).attr('href'));
            });
        });
    </script>

@endpush












<style>
    td{padding:0.2rem 0.5rem !important;}
    th{font-weight: bold !important;}
</style>

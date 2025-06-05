@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Supplier Details: {{ $data->provider_name }}</h4>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Supplier information <a href="{{ route('admin.provider.edit', $data->id) }}" class="btn btn-sm font-sm rounded btn-dark">
                                <i class="material-icons md-edit fs-6"></i> Edit
                            </a></h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-lg-7 col-xl-7">

                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col" width="30%">Supplier Name</th>
                                        <th scope="col" width="70%">{{ $data->provider_name }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">{{ $data->provider_company_name }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Country Name</th>
                                        <th scope="col">{{ $data->provider_country_name }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Provider Physical Address</th>
                                        <th scope="col">{{ $data->provider_physical_address }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Provider Pickup Address (If Different)</th>
                                        <th scope="col">{{ $data->provider_pickup_address }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Provider Remit Address (If Different)</th>
                                        <th scope="col">{{ $data->provider_remit_address }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Office Phone</th>
                                        <th scope="col">{{ $data->provider_office_phone }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Account Receivable Contact Email</th>
                                        <th scope="col">{{ $data->provider_primary_contact_name }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Primary Contact Name</th>
                                        <th scope="col">{{ $data->provider_primary_contact_email }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Primary Contact Email</th>
                                        <th scope="col">{{ $data->provider_account_receivable_contact_email }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Food Safety Contact Phone</th>
                                        <th scope="col">{{ $data->provider_food_safety_contact_phone }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Food Safety Contact Email</th>
                                        <th scope="col">{{ $data->provider_food_safety_contact_email }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Emergency Recall Contact Phone</th>
                                        <th scope="col">{{ $data->provider_emergency_recall_contact_phone }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Emergency Recall Contact Email</th>
                                        <th scope="col">{{ $data->provider_emergency_recall_contact_email }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">List of Items from Supplier / Provider</th>
                                        <th scope="col">{{ $data->provider_list_of_products }}</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>


                            <div class="col-lg-5 col-xl-5">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th colspan="2" scope="col">Documents</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td class="p-2">GFSI PROCESSING PLANT CERTIFICATION</td>
                                        <td class="p-2">
                                            @if(!empty($data->gfsi_processing_plant_certification_file))
                                                <a target="_blank" href="{{url('/'.$data->gfsi_processing_plant_certification_file)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                                    <i class="material-icons md-picture_as_pdf fs-6"></i>Download ({{$data->gfsi_processing_plant_certification_type}})
                                                </a>
                                            @else
                                                <a class="btn btn-info disabled font-sm btn-outline-danger">
                                                    Not Uploaded
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-2">SOCIAL CERTIFICATION (SMETA)</td>
                                        <td class="p-2">
                                            @if(!empty($data->social_certification_smeta))
                                                <a target="_blank" href="{{url('/'.$data->social_certification_smeta)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                                    <i class="material-icons md-picture_as_pdf fs-6"></i>Download
                                                </a>
                                            @else
                                                <a class="btn btn-info disabled font-sm btn-outline-danger">
                                                    Not Uploaded
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-2">FDA REGISTRATION</td>
                                        <td class="p-2">
                                            @if(!empty($data->fda_registration))
                                                <a target="_blank" href="{{url('/'.$data->fda_registration)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                                    <i class="material-icons md-picture_as_pdf fs-6"></i>Download
                                                </a>
                                            @else
                                                <a class="btn btn-info disabled font-sm btn-outline-danger">
                                                    Not Uploaded
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-2">SUPPLIER QUESTIONARY SHEET</td>
                                        <td class="p-2">
                                            @if(!empty($data->supplier_questionary_sheet))
                                                <a target="_blank" href="{{url('/'.$data->supplier_questionary_sheet)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                                    <i class="material-icons md-picture_as_pdf fs-6"></i>Download
                                                </a>
                                            @else
                                                <a class="btn btn-info disabled font-sm btn-outline-danger">
                                                    Not Uploaded
                                                </a>
                                            @endif
                                        </td>
                                    </tr>


                                    </tbody>
                                </table>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

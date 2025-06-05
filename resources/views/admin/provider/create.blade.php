@php use App\Models\Countries; @endphp
@extends('admin.layouts.master')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Create New Supplier / Provider</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Please enter Supplier information</h5>
                        <form action="{{ route('admin.provider.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf




                                    <div class="row mb-4">
                                        <div class="col-lg-4 col-xl-4">
                                            <label for="provider_name" class="form-label">Supplier Name</label>
                                            <input type="text" placeholder="Supplier Name" class="form-control" id="provider_name" name="provider_name"  value="{{ old('provider_name') }}" required>
                                        </div>
                                        <div class="col-lg-4 col-xl-4">
                                            <label for="provider_company_name" class="form-label">Company Name</label>
                                            <input type="text" placeholder="Company Name" class="form-control" id="provider_company_name" name="provider_company_name"  value="{{ old('provider_company_name') }}" required>
                                        </div>
                                        <div class="col-lg-4 col-xl-4">
                                            <label for="provider_country_name" class="form-label">Country Name</label>
                                            <select class="form-select" id="provider_country_name" name="provider_country_name"  value="{{ old('provider_country_name') }}">
                                                <option value="">Select</option>
                                                @foreach(Countries::orderBy('country_name')->get() as $p)
                                                    <option value="{{ $p->country_name }}">{{ $p->country_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-lg-4 col-xl-4">
                                            <label for="provider_physical_address" class="form-label">Provider Physical Address</label>
                                            <textarea placeholder="Type here" class="form-control" rows="4" id="provider_physical_address" name="provider_physical_address">{{ old('provider_physical_address') }}</textarea>
                                        </div>
                                        <div class="col-lg-4 col-xl-4">
                                            <label for="provider_pickup_address" class="form-label">Provider Pickup Address (If Different)</label>
                                            <textarea placeholder="Type here" class="form-control" rows="4" id="provider_pickup_address" name="provider_pickup_address">{{ old('provider_pickup_address') }}</textarea>
                                        </div>
                                        <div class="col-lg-4 col-xl-4">
                                            <label for="provider_remit_address" class="form-label">Provider Remit Address (If Different)</label>
                                            <textarea placeholder="Type here" class="form-control" rows="4" id="provider_remit_address" name="provider_remit_address">{{ old('provider_remit_address') }}</textarea>
                                        </div>
                                    </div>
                            <div class="row">

                            <div class="col-lg-8 col-xl-8">

                                    <div class="row mb-4">
                                        <div class="col-lg-6 col-xl-6">
                                            <label for="provider_office_phone" class="form-label">Office Phone</label>
                                            <input type="text" placeholder="Phone Number" class="form-control" id="provider_office_phone" name="provider_office_phone"  value="{{ old('provider_office_phone') }}" >
                                        </div>
                                        <div class="col-lg-6 col-xl-6">
                                            <label for="provider_account_receivable_contact_email" class="form-label">Account Receivable Contact Email</label>
                                            <input type="text" placeholder="Email Address" class="form-control" id="provider_account_receivable_contact_email" name="provider_account_receivable_contact_email"  value="{{ old('provider_account_receivable_contact_email') }}" >
                                        </div>
                                    </div>


                                    <div class="row mb-4">
                                        <div class="col-lg-6 col-xl-6">
                                            <label for="provider_primary_contact_name" class="form-label">Primary Contact Name</label>
                                            <input type="text" placeholder="Phone Number" class="form-control" id="provider_primary_contact_name" name="provider_primary_contact_name"  value="{{ old('provider_primary_contact_name') }}" >
                                        </div>
                                        <div class="col-lg-6 col-xl-6">
                                            <label for="provider_primary_contact_email" class="form-label">Primary Contact Email</label>
                                            <input type="text" placeholder="Email Address" class="form-control" id="provider_primary_contact_email" name="provider_primary_contact_email"  value="{{ old('provider_primary_contact_email')  }}" >
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-lg-6 col-xl-6">
                                            <label for="provider_food_safety_contact_phone" class="form-label">Food Safety Contact Phone</label>
                                            <input type="text" placeholder="Phone Number" class="form-control" id="provider_food_safety_contact_phone" name="provider_food_safety_contact_phone"  value="{{ old('provider_food_safety_contact_phone')  }}" >
                                        </div>
                                        <div class="col-lg-6 col-xl-6">
                                            <label for="provider_food_safety_contact_email" class="form-label">Food Safety Contact Email</label>
                                            <input type="text" placeholder="Email Address" class="form-control" id="provider_food_safety_contact_email" name="provider_food_safety_contact_email"  value="{{ old('provider_food_safety_contact_email') }}" >
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-lg-6 col-xl-6">
                                            <label for="provider_emergency_recall_contact_phone" class="form-label">Emergency Recall Contact Phone</label>
                                            <input type="text" placeholder="Phone Number" class="form-control" id="provider_emergency_recall_contact_phone" name="provider_emergency_recall_contact_phone"  value="{{ old('provider_emergency_recall_contact_phone') }}" >
                                        </div>
                                        <div class="col-lg-6 col-xl-6">
                                            <label for="provider_emergency_recall_contact_email" class="form-label">Emergency Recall Contact Email</label>
                                            <input type="text" placeholder="Email Address" class="form-control" id="provider_emergency_recall_contact_email" name="provider_emergency_recall_contact_email"  value="{{ old('provider_emergency_recall_contact_email') }}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <div class="row">
                                        <div class="col-lg-12 col-xl-12">
                                            <label for="provider_list_of_products" class="form-label">List of Items from Supplier / Provider</label>
                                            <textarea placeholder="Type here" class="form-control" rows="4" id="provider_list_of_products" name="provider_list_of_products" style="height:250px;">{{ old('provider_list_of_products') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-1 col-xl-1">
                                    <label for="gfsi_processing_plant_certification_type" class="form-label">Type</label>
                                    <select class="form-select" id="gfsi_processing_plant_certification_type" name="gfsi_processing_plant_certification_type"  value="{{ old('gfsi_processing_plant_certification_type') }}">
                                        <option value="">Select</option>
                                        <option value="BRC">BRC</option>
                                        <option value="FSSC2200">FSSC2200</option>
                                        <option value="SQF">SQF</option>
                                        <option value="GLOBAL GAP">GLOBAL GAP</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="gfsi_processing_plant_certification_file" class="form-label">GFSI PROCESSING PLANT CERTIFICATION</label>
                                    <input type="file" class="form-control" id="gfsi_processing_plant_certification_file" name="gfsi_processing_plant_certification_file"  value="{{ old('gfsi_processing_plant_certification_file') }}">
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="social_certification_smeta" class="form-label">SOCIAL CERTIFICATION (SMETA)</label>
                                    <input type="file" class="form-control" id="social_certification_smeta" name="social_certification_smeta"  value="{{ old('social_certification_smeta') }}">
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="fda_registration" class="form-label">FDA REGISTRATION</label>
                                    <input type="file" class="form-control" id="fda_registration" name="fda_registration"  value="{{ old('fda_registration') }}">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-4 col-xl-4">
                                    <label for="supplier_questionary_sheet" class="form-label">SUPPLIER QUESTIONARY SHEET</label>
                                    <input type="file" class="form-control" id="supplier_questionary_sheet" name="supplier_questionary_sheet"  value="{{ old('supplier_questionary_sheet') }}">
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

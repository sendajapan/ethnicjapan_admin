@php use App\Models\Category; @endphp
@extends('admin.layouts.master')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Create New Item</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Please enter item information</h5>
                        <form action="{{ route('admin.item.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-lg-2 col-xl-2">
                                    <img for="item_photo" style="max-height:120px" src="{{url('/assets/imgs/item_placeholder.jpg')}}">
                                    <input type="file" class="form-control" id="item_photo" name="item_photo"  value="{{ old('item_photo') }}">


                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="category_id" class="form-label">Category Name</label>
                                    <select class="form-select" id="category_id" name="category_id"  value="{{ old('category_id') }}" required>
                                        <option value="">Select</option>
                                        @foreach(Category::orderBy('category_name')->get() as $p)
                                            <option value="{{ $p->id }}">{{ $p->category_name }}</option>
                                        @endforeach
                                    </select>

                                    <br>

                                    <label for="item_name" class="form-label">Item Name</label>
                                    <input type="text" placeholder="ex. Item Name" class="form-control" id="item_name" name="item_name"  value="{{ old('item_name') }}" required>
                                </div>
                                <div class="col-lg-6 col-xl-6">
                                    <label for="item_description" class="form-label">Item Description</label>
                                    <textarea placeholder="Type here" class="form-control" rows="4" id="item_description" name="item_description">{{ old('item_description') }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-4 col-xl-4">
                                    <label for="item_origin" class="form-label">Item Origin</label>
                                    <input type="text" placeholder="ex. Peru" class="form-control" id="item_origin" name="item_origin"  value="{{ old('item_origin') }}" required>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="hts_code" class="form-label">HTS Code</label>
                                    <input type="text" placeholder="ex. 1800.00.00" class="form-control" id="hts_code" name="hts_code"  value="{{ old('hts_code') }}" required>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="default_price" class="form-label">Default Price</label>
                                    <input type="text" placeholder="ex. 9.95" class="form-control" id="default_price" name="default_price"  value="{{ old('default_price')  }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-xl-12">
                                    <label class="form-label">ORGANIC CERTIFICATION JAS EXPORTER</label>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-3 col-xl-3">
                                    <label for="organic_certification_jas_exporter_jas" class="form-label">JAS</label>
                                    <input type="file" class="form-control" id="organic_certification_jas_exporter_jas" name="organic_certification_jas_exporter_jas"  value="{{ old('organic_certification_jas_exporter_jas') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="organic_certification_jas_exporter_nop" class="form-label">NOP</label>
                                    <input type="file" class="form-control" id="organic_certification_jas_exporter_nop" name="organic_certification_jas_exporter_nop"  value="{{ old('organic_certification_jas_exporter_nop') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="organic_certification_jas_exporter_cor" class="form-label">COR</label>
                                    <input type="file" class="form-control" id="organic_certification_jas_exporter_cor" name="organic_certification_jas_exporter_cor"  value="{{ old('organic_certification_jas_exporter_cor') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="organic_certification_jas_exporter_eu" class="form-label">EU</label>
                                    <input type="file" class="form-control" id="organic_certification_jas_exporter_eu" name="organic_certification_jas_exporter_eu"  value="{{ old('organic_certification_jas_exporter_eu') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xl-12">
                                    <label class="form-label">PRODUCER ORGANIC CERTIFICATION</label>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-3 col-xl-3">
                                    <label for="producer_organic_certification_jas" class="form-label">JAS</label>
                                    <input type="file" class="form-control" id="producer_organic_certification_jas" name="producer_organic_certification_jas"  value="{{ old('producer_organic_certification_jas') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="producer_organic_certification_nop" class="form-label">NOP</label>
                                    <input type="file" class="form-control" id="producer_organic_certification_nop" name="producer_organic_certification_nop"  value="{{ old('producer_organic_certification_nop') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="producer_organic_certification_cor" class="form-label">COR</label>
                                    <input type="file" class="form-control" id="producer_organic_certification_cor" name="producer_organic_certification_cor"  value="{{ old('producer_organic_certification_cor') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="producer_organic_certification_eu" class="form-label">EU</label>
                                    <input type="file" class="form-control" id="producer_organic_certification_eu" name="producer_organic_certification_eu"  value="{{ old('producer_organic_certification_eu') }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-3 col-xl-3">
                                    <label for="spec_sheet" class="form-label">SPEC SHEET</label>
                                    <input type="file" class="form-control" id="spec_sheet" name="spec_sheet"  value="{{ old('spec_sheet') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="halal_certification_if_needed" class="form-label">HALAL CERTIFICATION</label>
                                    <input type="file" class="form-control" id="halal_certification_if_needed" name="halal_certification_if_needed"  value="{{ old('halal_certification_if_needed') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="kosher_certification_if_needed" class="form-label">KOSHER CERTIFICATION</label>
                                    <input type="file" class="form-control" id="kosher_certification_if_needed" name="kosher_certification_if_needed"  value="{{ old('kosher_certification_if_needed') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="product_flow_chart" class="form-label">PRODUCT FLOW CHART</label>
                                    <input type="file" class="form-control" id="product_flow_chart" name="product_flow_chart"  value="{{ old('product_flow_chart') }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-3 col-xl-3">
                                    <label for="fair_trade" class="form-label">FAIR TRADE</label>
                                    <input type="file" class="form-control" id="fair_trade" name="fair_trade"  value="{{ old('fair_trade') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="rainforest_alliance" class="form-label">RAINFOREST ALLIANCE</label>
                                    <input type="file" class="form-control" id="rainforest_alliance" name="rainforest_alliance"  value="{{ old('rainforest_alliance') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="security_plan" class="form-label">SECURITY PLAN</label>
                                    <input type="file" class="form-control" id="security_plan" name="security_plan"  value="{{ old('security_plan') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="heavy_metals_declaration" class="form-label">HEAVY METALS DECLARATION</label>
                                    <input type="file" class="form-control" id="heavy_metals_declaration" name="heavy_metals_declaration"  value="{{ old('heavy_metals_declaration') }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-3 col-xl-3">
                                    <label for="gluten_free" class="form-label">GLUTEN FREE</label>
                                    <input type="file" class="form-control" id="gluten_free" name="gluten_free"  value="{{ old('gluten_free') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="nutrition_chart" class="form-label">NUTRITION CHART</label>
                                    <input type="file" class="form-control" id="nutrition_chart" name="nutrition_chart"  value="{{ old('nutrition_chart') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="non_gmo_declaration" class="form-label">NON GMO DECLARATION</label>
                                    <input type="file" class="form-control" id="non_gmo_declaration" name="non_gmo_declaration"  value="{{ old('non_gmo_declaration') }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="traceability_exercise" class="form-label">TRACEABILITY EXERCISE</label>
                                    <input type="file" class="form-control" id="traceability_exercise" name="traceability_exercise"  value="{{ old('traceability_exercise') }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-3 col-xl-3">
                                    <label for="vegan_declaration" class="form-label">VEGAN DECLARATION</label>
                                    <input type="file" class="form-control" id="vegan_declaration" name="vegan_declaration"  value="{{ old('vegan_declaration') }}">
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

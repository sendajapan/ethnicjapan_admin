@php use App\Models\Category; @endphp
@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Update {{ $data->item_name }}</h4>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Please enter item information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.item.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">

                                <div class="col-lg-2 col-xl-2">
                                    @if(!empty($data->item_photo))
                                        <img for="item_photo" style="max-height:120px" src="{{url('/'.$data->item_photo)}}">
                                    @else
                                        <img for="item_photo" style="max-height:120px" src="{{url('/assets/imgs/item_placeholder.jpg')}}">
                                    @endif
                                        <input type="file" class="form-control" id="item_photo" name="item_photo"  value="{{ old('item_photo') }}">
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="category_id" class="form-label">Category Name</label>
                                    <select class="form-select" id="category_id" name="category_id"  value="{{ old('category_id') }}" required>
                                        <option value="">Select</option>
                                        @foreach(Category::orderBy('category_name')->get() as $p)
                                            <option {{ $p->id == $data->category->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->category_name }}</option>
                                        @endforeach
                                    </select>

                                    <br>

                                    <label for="item_name" class="form-label">Item Name</label>
                                    <input type="text" placeholder="ex. Item Name" class="form-control" id="item_name" name="item_name" value="{{ $data->item_name }}" required>
                                </div>
                                <div class="col-lg-6 col-xl-6">
                                    <label for="item_description" class="form-label">Item Description</label>
                                    <textarea placeholder="Type here" class="form-control" rows="6" id="item_description" name="item_description">{{ $data->item_description }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-4 col-xl-4">
                                    <label for="item_origin" class="form-label">Item Origin</label>
                                    <input type="text" placeholder="ex. Peru" class="form-control" id="item_origin" name="item_origin"  value="{{ $data->item_origin }}" required>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="hts_code" class="form-label">HTS Code</label>
                                    <input type="text" placeholder="ex. 1800.00.00" class="form-control" id="hts_code" name="hts_code"  value="{{ $data->hts_code }}" required>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="hts_code" class="form-label">Default Price</label>
                                    <input type="text" placeholder="ex. 9.95" class="form-control" id="default_price" name="default_price"  value="{{ $data->default_price }}" required>
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
                                    @if(!empty($data->organic_certification_jas_exporter_jas))
                                        <a target="_blank" href="{{url('/'.$data->organic_certification_jas_exporter_jas)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="organic_certification_jas_exporter_jas" name="organic_certification_jas_exporter_jas"  value="{{ $data->organic_certification_jas_exporter_jas }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="organic_certification_jas_exporter_nop" class="form-label">NOP</label>
                                    @if(!empty($data->organic_certification_jas_exporter_nop))
                                        <a target="_blank" href="{{url('/'.$data->organic_certification_jas_exporter_nop)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="organic_certification_jas_exporter_nop" name="organic_certification_jas_exporter_nop"  value="{{ $data->organic_certification_jas_exporter_nop }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="organic_certification_jas_exporter_cor" class="form-label">COR</label>
                                    @if(!empty($data->organic_certification_jas_exporter_cor))
                                        <a target="_blank" href="{{url('/'.$data->organic_certification_jas_exporter_cor)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="organic_certification_jas_exporter_cor" name="organic_certification_jas_exporter_cor"  value="{{ $data->organic_certification_jas_exporter_cor }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="organic_certification_jas_exporter_eu" class="form-label">EU</label>
                                    @if(!empty($data->organic_certification_jas_exporter_eu))
                                        <a target="_blank" href="{{url('/'.$data->organic_certification_jas_exporter_eu)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="organic_certification_jas_exporter_eu" name="organic_certification_jas_exporter_eu"  value="{{ $data->organic_certification_jas_exporter_eu }}">
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
                                    @if(!empty($data->producer_organic_certification_jas))
                                        <a target="_blank" href="{{url('/'.$data->organic_certification_jas_exporter_jas)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="producer_organic_certification_jas" name="producer_organic_certification_jas"  value="{{ $data->producer_organic_certification_jas }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="producer_organic_certification_nop" class="form-label">NOP</label>
                                    @if(!empty($data->producer_organic_certification_nop))
                                        <a target="_blank" href="{{url('/'.$data->producer_organic_certification_nop)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="producer_organic_certification_nop" name="producer_organic_certification_nop"  value="{{ $data->producer_organic_certification_nop }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="producer_organic_certification_cor" class="form-label">COR</label>
                                    @if(!empty($data->producer_organic_certification_cor))
                                        <a target="_blank" href="{{url('/'.$data->producer_organic_certification_cor)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="producer_organic_certification_cor" name="producer_organic_certification_cor"  value="{{ $data->producer_organic_certification_cor }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="producer_organic_certification_eu" class="form-label">EU</label>
                                    @if(!empty($data->producer_organic_certification_eu))
                                        <a target="_blank" href="{{url('/'.$data->producer_organic_certification_eu)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="producer_organic_certification_eu" name="producer_organic_certification_eu"  value="{{ $data->producer_organic_certification_eu }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-3 col-xl-3">
                                    <label for="spec_sheet" class="form-label">SPEC SHEET</label>
                                    @if(!empty($data->spec_sheet))
                                        <a target="_blank" href="{{url('/'.$data->spec_sheet)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="spec_sheet" name="spec_sheet"  value="{{ $data->spec_sheet }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="halal_certification_if_needed" class="form-label">HALAL CERTIFICATION</label>
                                    @if(!empty($data->halal_certification_if_needed))
                                        <a target="_blank" href="{{url('/'.$data->halal_certification_if_needed)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="halal_certification_if_needed" name="halal_certification_if_needed"  value="{{ $data->halal_certification_if_needed }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="kosher_certification_if_needed" class="form-label">KOSHER CERTIFICATION</label>
                                    @if(!empty($data->kosher_certification_if_needed))
                                        <a target="_blank" href="{{url('/'.$data->kosher_certification_if_needed)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="kosher_certification_if_needed" name="kosher_certification_if_needed"  value="{{ $data->kosher_certification_if_needed }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="product_flow_chart" class="form-label">PRODUCT FLOW CHART</label>
                                    @if(!empty($data->product_flow_chart))
                                        <a target="_blank" href="{{url('/'.$data->product_flow_chart)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="product_flow_chart" name="product_flow_chart"  value="{{ $data->product_flow_chart }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-3 col-xl-3">
                                    <label for="fair_trade" class="form-label">FAIR TRADE</label>
                                    @if(!empty($data->fair_trade))
                                        <a target="_blank" href="{{url('/'.$data->fair_trade)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="fair_trade" name="fair_trade"  value="{{ $data->fair_trade }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="rainforest_alliance" class="form-label">RAINFOREST ALLIANCE</label>
                                    @if(!empty($data->rainforest_alliance))
                                        <a target="_blank" href="{{url('/'.$data->rainforest_alliance)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="rainforest_alliance" name="rainforest_alliance"  value="{{ $data->rainforest_alliance }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="security_plan" class="form-label">SECURITY PLAN</label>
                                    @if(!empty($data->security_plan))
                                        <a target="_blank" href="{{url('/'.$data->security_plan)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="security_plan" name="security_plan"  value="{{ $data->security_plan }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="heavy_metals_declaration" class="form-label">HEAVY METALS DECLARATION</label>
                                    @if(!empty($data->heavy_metals_declaration))
                                        <a target="_blank" href="{{url('/'.$data->heavy_metals_declaration)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="heavy_metals_declaration" name="heavy_metals_declaration"  value="{{ $data->heavy_metals_declaration }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-3 col-xl-3">
                                    <label for="gluten_free" class="form-label">GLUTEN FREE</label>
                                    @if(!empty($data->gluten_free))
                                        <a target="_blank" href="{{url('/'.$data->gluten_free)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="gluten_free" name="gluten_free"  value="{{ $data->gluten_free }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="nutrition_chart" class="form-label">NUTRITION CHART</label>
                                    @if(!empty($data->nutrition_chart))
                                        <a target="_blank" href="{{url('/'.$data->nutrition_chart)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="nutrition_chart" name="nutrition_chart"  value="{{ $data->nutrition_chart }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="non_gmo_declaration" class="form-label">NON GMO DECLARATION</label>
                                    @if(!empty($data->non_gmo_declaration))
                                        <a target="_blank" href="{{url('/'.$data->non_gmo_declaration)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="non_gmo_declaration" name="non_gmo_declaration"  value="{{ $data->non_gmo_declaration }}">
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <label for="traceability_exercise" class="form-label">TRACEABILITY EXERCISE</label>
                                    @if(!empty($data->traceability_exercise))
                                        <a target="_blank" href="{{url('/'.$data->traceability_exercise)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="traceability_exercise" name="traceability_exercise"  value="{{ $data->traceability_exercise }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-3 col-xl-3">
                                    <label for="vegan_declaration" class="form-label">VEGAN DECLARATION</label>
                                    @if(!empty($data->vegan_declaration))
                                        <a target="_blank" href="{{url('/'.$data->vegan_declaration)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control" id="vegan_declaration" name="vegan_declaration"  value="{{ $data->vegan_declaration }}">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm rounded" type="submit" name="submit">UPDATE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

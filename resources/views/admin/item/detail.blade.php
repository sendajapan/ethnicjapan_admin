@php use App\Models\Category; @endphp
@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Item Details: {{ $data->item_name }}</h4>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Item information <a href="{{ route('admin.item.edit', $data->id) }}" class="btn btn-sm font-sm rounded btn-dark">
                                <i class="material-icons md-edit fs-6"></i> Edit
                            </a></h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-lg-5 col-xl-5">

                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">
                                            @if(!empty($data->item_photo))
                                                <img for="item_photo" style="max-height:120px" src="{{url('/'.$data->item_photo)}}">
                                            @else
                                                <img for="item_photo" style="max-height:120px" src="{{url('/assets/imgs/item_placeholder.jpg')}}">
                                            @endif

                                        </th>
                                        <th scope="col">{{ $data->item_name }}</th>
                                    </tr>
                                    <tr>
                                        <th width="30%" scope="col">Category:</th>
                                        <th width="70%" scope="col">@foreach(Category::orderBy('category_name')->get() as $p)
                                                @php if($p->id == $data->category->id){ echo $p->category_name; } @endphp
                                            @endforeach</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Item Description:</th>
                                        <th scope="col">{{ $data->item_description }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Item Origin:</th>
                                        <th scope="col">{{ $data->item_origin }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">HTS Code:</th>
                                        <th scope="col">{{ $data->hts_code }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Default Price:</th>
                                        <th scope="col">{{ $data->default_price }}</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                                <div class="col-lg-6 col-xl-6">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th colspan="2" scope="col">Documents</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="p-2">ORGANIC CERTIFICATION JAS EXPORTER</td>
                                            <td class="p-2">
                                                @if(!empty($data->organic_certification_jas_exporter_jas))
                                                    <a target="_blank" href="{{url('/'.$data->organic_certification_jas_exporter_jas)}}" class="btn btn-youtube font-sm btn-outline-danger mr-10">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> JAS
                                                    </a>
                                                @endif
                                                @if(!empty($data->organic_certification_jas_exporter_nop))
                                                    <a target="_blank" href="{{url('/'.$data->organic_certification_jas_exporter_nop)}}" class="btn btn-youtube font-sm btn-outline-danger mr-10">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> NOP
                                                    </a>
                                                @endif
                                                @if(!empty($data->organic_certification_jas_exporter_cor))
                                                    <a target="_blank" href="{{url('/'.$data->organic_certification_jas_exporter_cor)}}" class="btn btn-youtube font-sm btn-outline-danger mr-10">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> COR
                                                    </a>
                                                @endif
                                                @if(!empty($data->organic_certification_jas_exporter_eu))
                                                    <a target="_blank" href="{{url('/'.$data->organic_certification_jas_exporter_eu)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> EU
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">PRODUCER ORGANIC CERTIFICATION</td>
                                            <td class="p-2">
                                                @if(!empty($data->producer_organic_certification_jas))
                                                    <a target="_blank" href="{{url('/'.$data->producer_organic_certification_jas)}}" class="btn btn-youtube font-sm btn-outline-danger mr-10">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> JAS
                                                    </a>
                                                @endif
                                                @if(!empty($data->producer_organic_certification_nop))
                                                    <a target="_blank" href="{{url('/'.$data->producer_organic_certification_nop)}}" class="btn btn-youtube font-sm btn-outline-danger mr-10">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> NOP
                                                    </a>
                                                @endif
                                                @if(!empty($data->producer_organic_certification_cor))
                                                    <a target="_blank" href="{{url('/'.$data->producer_organic_certification_cor)}}" class="btn btn-youtube font-sm btn-outline-danger mr-10">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> COR
                                                    </a>
                                                @endif
                                                @if(!empty($data->producer_organic_certification_eu))
                                                    <a target="_blank" href="{{url('/'.$data->producer_organic_certification_eu)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> EU
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">SPEC SHEET</td>
                                            <td class="p-2">
                                                @if(!empty($data->spec_sheet))
                                                    <a target="_blank" href="{{url('/'.$data->spec_sheet)}}" class="btn btn-youtube font-sm btn-outline-danger">
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
                                            <td class="p-2">HALAL CERTIFICATION</td>
                                            <td class="p-2">
                                                @if(!empty($data->halal_certification_if_needed))
                                                    <a target="_blank" href="{{url('/'.$data->halal_certification_if_needed)}}" class="btn btn-youtube font-sm btn-outline-danger">
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
                                            <td class="p-2">KOSHER CERTIFICATION</td>
                                            <td class="p-2">
                                                @if(!empty($data->kosher_certification_if_needed))
                                                    <a target="_blank" href="{{url('/'.$data->kosher_certification_if_needed)}}" class="btn btn-youtube font-sm btn-outline-danger">
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
                                            <td class="p-2">PRODUCT FLOW CHART</td>
                                            <td class="p-2">
                                                @if(!empty($data->product_flow_chart))
                                                    <a target="_blank" href="{{url('/'.$data->product_flow_chart)}}" class="btn btn-youtube font-sm btn-outline-danger">
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
                                            <td class="p-2">FAIR TRADE</td>
                                            <td class="p-2">
                                                @if(!empty($data->fair_trade))
                                                    <a target="_blank" href="{{url('/'.$data->fair_trade)}}" class="btn btn-youtube font-sm btn-outline-danger">
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
                                            <td class="p-2">RAINFOREST ALLIANCE</td>
                                            <td class="p-2">
                                                @if(!empty($data->rainforest_alliance))
                                                    <a target="_blank" href="{{url('/'.$data->rainforest_alliance)}}" class="btn btn-youtube font-sm btn-outline-danger">
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
                                            <td class="p-2">SECURITY PLAN</td>
                                            <td class="p-2">
                                                @if(!empty($data->security_plan))
                                                    <a target="_blank" href="{{url('/'.$data->security_plan)}}" class="btn btn-youtube font-sm btn-outline-danger">
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
                                            <td class="p-2">HEAVY METALS DECLARATION</td>
                                            <td class="p-2">
                                                @if(!empty($data->heavy_metals_declaration))
                                                    <a target="_blank" href="{{url('/'.$data->heavy_metals_declaration)}}" class="btn btn-youtube font-sm btn-outline-danger">
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
                                            <td class="p-2">GLUTEN FREE</td>
                                            <td class="p-2">
                                                @if(!empty($data->gluten_free))
                                                    <a target="_blank" href="{{url('/'.$data->gluten_free)}}" class="btn btn-youtube font-sm btn-outline-danger">
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
                                            <td class="p-2">NUTRITION CHART</td>
                                            <td class="p-2">
                                                @if(!empty($data->nutrition_chart))
                                                    <a target="_blank" href="{{url('/'.$data->nutrition_chart)}}" class="btn btn-youtube font-sm btn-outline-danger">
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
                                            <td class="p-2">NON GMO DECLARATION</td>
                                            <td class="p-2">
                                                @if(!empty($data->non_gmo_declaration))
                                                    <a target="_blank" href="{{url('/'.$data->non_gmo_declaration)}}" class="btn btn-youtube font-sm btn-outline-danger">
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
                                            <td class="p-2">TRACEABILITY EXERCISE</td>
                                            <td class="p-2">
                                                @if(!empty($data->traceability_exercise))
                                                    <a target="_blank" href="{{url('/'.$data->traceability_exercise)}}" class="btn btn-youtube font-sm btn-outline-danger">
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
                                            <td class="p-2">VEGAN DECLARATION</td>
                                            <td class="p-2">
                                                @if(!empty($data->vegan_declaration))
                                                    <a target="_blank" href="{{url('/'.$data->vegan_declaration)}}" class="btn btn-youtube font-sm btn-outline-danger">
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

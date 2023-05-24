@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/certificate.css')}}">
@endpush
@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if (permissionCheck('certificate.create'))
                @if(!isset($certificates))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12">
                            <a href="{{route('certificate.index')}}" class="primary-btn small fix-gr-bg">
                                {{__('certificate.Certificate')}}
                                {{__('certificate.List')}}
                            </a>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12">
                            <a href="{{route('certificate.create')}}" class="primary-btn small fix-gr-bg">
                                <span class="ti-plus pr-2"></span>
                                {{__('certificate.Add')}}
                            </a>
                        </div>
                    </div>
                @endif
            @endif
            <div class="row">
                @if(!isset($certificates))
                    @include('certificate::certificate.addEdit')
                @endif
                <div class="{{isset($certificates) ? 'col-lg-12' : 'col-lg-8'}}">
                    @isset($certificates)
                        <div class="main-title">
                            <h3 class="mb-20">{{__('certificate.Certificate List')}}</h3>
                        </div>
                    @else
                        <div class="main-title">
                            <h3 class="mb-20">{{__('certificate.Preview')}} (
                                <span id="width"></span>
                                x
                                <span id="height"></span>
                                )
                                <small>
                                    {{__('certificate.All measurement depends on background height & width')}}
                                </small>
                            </h3>
                        </div>
                    @endisset
                    @isset($certificates)
                        @include('certificate::certificate.certificateList')
                    @else
                        @include('certificate::certificate.preview')
                    @endisset
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/course.js"></script>
    <script src="{{asset('public/backend/js/certificate.js')}}"></script>
    <script src="{{asset('public/js/html2pdf.bundle.js')}}"></script>
@endpush

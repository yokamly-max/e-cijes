@extends('layouts.site2')

@section('title')
    {{ __('service_last') }}
@endsection

@section('entite')
    {{ __('service_page') }}
@endsection


@section('contenu')

<!-- {{ App::getLocale() }} -->

        <!-- Start Breadcrumb Section -->
        <!-- ========================================== -->
        <section class="breadcrumb-section">
            <div class="bg bg-image" style="background-image: url('{{ env('APP_URL') . $slider->vignette }}')"></div>
            <div class="container">
                <div class="title-outer">
                    <div class="page-title">
                        <h2 class="title">{{ __('service_last') }}</h2>
                        <ul class="page-breadcrumb">
                            <li><a href="{{ route('index.index') }}">{{ __('accueil') }}</a></li>
                            <li>{{ __('service_page') }}</li>
                        </ul>
                    </div>
                    <!-- <div class="text">
                        <div class="icon"><i class="icon-arrow-up-right"></i></div>
                        <p>Completely restore extensive materials interactive solutions. <br> Progressively myocardinate viral paradigms</p>
                    </div> -->
                </div>
            </div>
        </section>
        <!-- ========================================== -->
        <!-- End Breadcrumb Section -->


        <!--==============================
        Blog Details Section
        ==============================-->
        <section class="blog-details-section space bg-white">
            <div class="container">
                <div class="row gy-30 flex-column-reverse flex-lg-row">

                    <div class="col-xl-8 col-lg-8">
                        @if (count($services) > 0)
                        <!--==============================
        Service Section Three
        ==============================-->
        <section class="service-section style-3 bg-white">
            <div class="">
                <div class="row gy-30">
                    @foreach ($services as $service)
                    <div class="col-lg-6 col-md-6 col-sm-6 wow fadeInLeft">
                        <div class="service-single-box">
                            <div class="inner-box">
                                @if ($service->vignette != '')
                                <img src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $service->vignette }}&w=384&h=280&zc=1&q=100" alt="{{ $service->titre }}">
                                @endif
                                <div class="border mt-50 xs-mt-40 mb-30"></div>
                                <h4 class="title">{{ $service->titre }}</h4>
                                <p class="text">{{ $service->resume }}</p>
                                <a href="{{ env('APP_URL') }}service/{{ $service->id }}-{{ getEnleveAccent($service->titre) }}.html" class="theme-btn service-btn">
                                    <i class="fa-solid fa-plus"></i>
                                    <span class="link-text">{{ __('lireplus') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
        </section>
        @endif

                    </div>

                    <div class="col-xl-4 col-lg-6">
						@include('layouts.sidebar')
                        
                    </div>

                </div>
            </div>
        </section>


        
            

@endsection

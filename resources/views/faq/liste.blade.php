@extends('layouts.site2')

@section('title')
    {{ __('faq_last') }}
@endsection

@section('entite')
    {{ __('faq_page') }}
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
                        <h2 class="title">{{ __('faq_last') }}</h2>
                        <ul class="page-breadcrumb">
                            <li><a href="{{ route('index.index') }}">{{ __('accueil') }}</a></li>
                            <li>{{ __('faq_page') }}</li>
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

                    <div class="faq-column col-xl-8 col-lg-8">
                        @if (count($faqs) > 0)
                        <div class="inner-column mt-15 md-mt-0">
                            <ul class="accordion-box style-2">
                 @php
                    $i = 0;
                @endphp
                @foreach ($faqs as $faq)
                @php
                    $i++;
                @endphp

                                <li class="accordion @if ($i == 1) active-block @endif">
                                    <div class="acc-btn @if ($i == 1) active @endif">{{ $faq->question }}
                                        <div class="icon"><i class="fa-regular fa-angle-right"></i></div>
                                    </div>
                                    <div class="acc-content @if ($i == 1) active @endif">
                                        <div class="content">
                                            <div class="text">{!! $faq->reponse !!}</div>
                                        </div>
                                    </div>
                                </li>

        @if ($i == 3)
        

                    @php
                        $i = 0;
                    @endphp
                    @endif


                @endforeach
                                
                            </ul>
                        </div>
                        {{ $faqs->links() }}

                        @endif

                    </div>

                    <div class="col-xl-4 col-lg-6">
						@include('layouts.sidebar')
                        
                    </div>

                </div>
            </div>
        </section>


        
            

@endsection

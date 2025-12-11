@extends('layouts.site')

@section('title')
	{{ __('site_name') }}
@endsection


@section('contenu')


        <!--==============================
        Hero Section Style Four
        ==============================-->
        
	@if (count($sliders) > 0)
        <section class="hero-section style-4" style="background-image: url({{ env('APP_URL') }}site/assets/images/banner/home4-bg01.jpg);">
            <div class="p-top-right wow slideInDown" data-wow-delay="500ms" data-wow-duration="1000ms"><img src="{{ env('APP_URL') }}site/assets/images/banner/home4-shape01.png" alt="shape"></div>
            <div class="hero-slider swiper">
                <div class="swiper-wrapper">
                    @foreach ($sliders as $slider)
                    <div class="swiper-slide">
                        <div class="container">
                            <div class="row align-items-center">
                                <!-- Left Side (Text Content) -->
                                <div class="col-lg-5">
                                    <div class="hero-content md-mb-50">
                                        <!--<span class="sub-title"><i class="icon-small-hand"></i> Building Wealth, Securing Futures</span>-->
                                        <h1 class="title">{{ $slider->titre }}</h1>
                                        <div class="pt-35 pb-35"><div class="border"></div></div>
                                        <p class="text">{{ $slider->resume }}</p>
                                        <a href="{{ $slider->lienurl }}" class="theme-btn bg-dark">
                                            <span class="link-effect">
                                                <span class="effect-1">{{ __('liresuite') }}</span>
                                                <span class="effect-1">{{ __('liresuite') }}</span>
                                            </span><i class="fa-regular fa-arrow-right-long"></i>
                                        </a>
                                        <!--<ul class="feature-list">
                                            <li>Expert Help Center</li>
                                            <li>Proven Results</li>
                                        </ul>-->
                                    </div>
                                </div>
                
                                <!-- Right Side (Image) -->
                                <div class="col-lg-7">
                                    <div class="hero-right">
                                        <div class="image-box">
                                            <img src="{{ env('APP_URL') . $slider->vignette }}" alt="">
                                        </div>
                                        <!--<div class="thumb-info">
                                            <img src="{{ env('APP_URL') }}site/assets/images/banner/home4-info.png" alt="">
                                        </div>
                                        <div class="agency-info">
                                            <span class="icon"><i class="fa-solid fa-paper-plane"></i></span>
                                            <p>Finance <br> Solutions</p>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				@endforeach
                    
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>
	@endif
        <!--======== / Hero Section ========-->


        <!--==============================
        About Section Four
        ==============================-->
        @if ($pagelibre->id > 0)
        <section class="about-section style-4 space bg-white overflow-hidden">
            <div class="p-top-right wow slideInRight"><img src="{{ env('APP_URL') }}site/assets/images/about/home4-shape01.png" alt="{{ $pagelibre->titre }}"></div>
            <div class="container">
                <div class="row gy-30 align-items-center">
                    <div class="col-lg-6">
                        <div class="about-image-wrapper mr-60 lg-mr-30 md-mr-0 direction-rtl">
                            <div class="about-image overlay-anim2 img-anim-left wow fadeInLeft">
                                <img src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $pagelibre->vignette }}&w=516&h=425&zc=1&q=100" alt="{{ $pagelibre->titre }}" />
                            </div>
                            <div class="shape d-none d-xxl-block"><img src="{{ env('APP_URL') }}site/assets/images/about/home4-dot-shape.png" alt="..."></div>
                            <!--<div class="about-single-card direction-ltr">
                                <div class="inner">
                                    <div class="p-top-right wow slideInRight"><img src="{{ env('APP_URL') }}site/assets/images/about/home4-card-shape.png" alt="Shape"></div>
                                    <div class="icon"><i class="flaticon-multiple-users"></i></div>
                                    <h4 class="title">Meet Our Financial Advisor Professional Members</h4>
                                    <div class="members">
                                        <div class="social">
                                            <img src="{{ env('APP_URL') }}site/assets/images/social/social-img01.jpg" alt="Client 01">
                                            <img src="{{ env('APP_URL') }}site/assets/images/social/social-img02.jpg" alt="Client 02">
                                            <img src="{{ env('APP_URL') }}site/assets/images/social/social-img03.jpg" alt="Client 03">
                                        </div>
                                        <span class="text">+36 Members</span>
                                    </div>
                                </div>
                            </div>-->
                            <!--<div class="circle-box">
                                <div class="logo-box"><img src="{{ env('APP_URL') }}site/assets/images/shapes/star2.png" alt=""></div>
                                <div class="text-inner" style="animation: 10s linear 0s infinite normal none running text-rotate;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="250.5" height="250.5" viewBox="0 0 250.5 250.5">
                                        <path d="M.25,125.25a125,125,0,1,1,125,125,125,125,0,0,1-125-125" id="e-path-35ee1b2"></path>
                                        <text>
                                            <textPath id="e-text-path-35ee1b2" href="#e-path-35ee1b2" startOffset="0%">* IT BUSINESS  *  CONSULTANTIS  *  DEVELOPMENTS</textPath>
                                        </text>
                                    </svg>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <div class="col-lg-6">
                       <div class="about-content-wrapper">
                            <div class="title-area two">
                                <div class="sub-title"><span><i class="asterisk"></i></span>{{ __('site_sigle') }}</div>
                                <h2 class="sec-title">{{ $pagelibre->titre }}</h2>
                                <p class="sec-text text-gray" style="text-align: justify;">{!! $pagelibre->description !!}</p>
                            </div>
                            <!--<div class="feature-list">
                                <div class="feature-item">
                                    <div class="icon"><i class="flaticon-service"></i></div>
                                    <p>Online Finance Advisor Consultation</p>
                                </div>
                                <div class="feature-item">
                                    <div class="icon"><i class="flaticon-people"></i></div>
                                    <p>Business Goal Setting Accountability</p>
                                </div>
                            </div>
                            <div class="pt-35 pb-25">
                                <div class="border"><span class="bar"></span></div>
                            </div>
                            <ul class="features-list ml-60 md-ml-0">
                                <li>Increasing your productivity for best sales</li>
                                <li>Audience growth & competitor analysis</li>
                            </ul>-->
                            <a href="{{ env('APP_URL') }}page/{{ $pagelibre->id }}-{{ getEnleveAccent($pagelibre->titre) }}.html" class="theme-btn bg-dark mt-35 ml-60 md-ml-0">
                                <span class="link-effect">
                                    <span class="effect-1">{{ __('savoirplus') }}</span>
                                    <span class="effect-1">{{ __('savoirplus2') }}</span>
                                </span><i class="fa-regular fa-arrow-right-long"></i>
                            </a>
                       </div>
                    </div>
                </div>
            </div>
        </section>
	@endif

        <div class="wrapper-section br-30 overflow-hidden mb-30 md-mb-0">
            
            <!--==============================
            Choose Section Four
            ==============================-->
            @if (count($chiffres) > 0)
            <section class="choose-section space bg-theme3 overflow-hidden style-4">
                <div class="p-top-right wow slideInRight"><img src="{{ env('APP_URL') }}site/assets/images/choose/shape01.png" alt="Choose shape"></div>
                <div class="container">
                    <div class="row gy-30">
                        <div class="col-lg-6">
                            <div class="choose-content-wrapper">
                                <div class="title-area three">
                                    <div class="sub-title"><span><i class="asterisk"></i></span>{{ __('chiffre_last') }}</div>
                                    <h2 class="sec-title">{{ __('chiffre_last2') }}</h2>
                                </div>
                                <div class="milestone">
                                    @php
                                    $i = 0;
                                    @endphp
                                    @foreach ($chiffres as $chiffre)
                                    @php
                                    $i++;
                                    @endphp
                                    <div class="milestone-item @if($i == 2) dark-green @elseif($i == 3) orange @elseif($i == 4) light-green @endif">
                                        <span class="label">{{ $chiffre->titre }}</span>
                                        <span class="value"><span class="count-number odometer" data-count="{{ $chiffre->chiffre }}">0</span>+</span>
                                    </div>
                    				@endforeach
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="choose-image-wrapper">
                                <div class="thumb-bg"><img src="{{ env('APP_URL') }}site/assets/images/choose/home4-bg01.png" alt=""></div>
                                <div class="thumb">
                                    <img src="{{ env('APP_URL') }}site/assets/images/choose/home4-img01.png" alt="">
                                </div>
                                <!--<div class="expert-card">
                                    <div class="expert-info">
                                        <div class="social">
                                            <img src="{{ env('APP_URL') }}site/assets/images/social/social-img01.jpg" alt="Client 01">
                                            <img src="{{ env('APP_URL') }}site/assets/images/social/social-img02.jpg" alt="Client 02">
                                            <img src="{{ env('APP_URL') }}site/assets/images/social/social-img03.jpg" alt="Client 03">
                                        </div>
                                        <div class="count">
                                            <span class="count-number odometer" data-count="36">0</span>+
                                        </div>
                                    </div>
                                    <div class="expert-text">
                                        <span class="arrow"><i class="flaticon-arrows"></i></span>
                                        <p>Ready to help you Expert People</p>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @endif
        </div>

        <div class="wrapper-section br-30 overflow-hidden mb-30 md-mb-0">
            
            <!--==============================
            Process Section Four
            ==============================-->
            @if (count($services) > 0)
            <section class="process-section space bg-theme3 overflow-hidden style-4">
                <div class="container">
                    <div class="title-area three text-center">
                        <div class="sub-title"><span><i class="asterisk"></i></span>{{ __('service_last') }}</div>
                        <h2 class="sec-title">{{ __('service_last2') }}</h2>
                    </div>
                    <div class="row gy-30">
                                    @php
                                    $i = 0;
                                    @endphp
                        @foreach ($services as $service)
                                    @php
                                    $i++;
                                    @endphp
                        <div class="col-lg-4 col-md-6 col-sm-6 wow fadeInLeft">
                            <div class="process-single-box br-10">
                                <div class="inner-box">
                                    <div class="header" style="margin-bottom: 10px !important;">
                                        <!--<div class="icon"><i class="icon-comercial"></i></div>-->
                                        <h4 class="title m-0">{{ $service->titre }}</span></h4>
                                    </div>
                                    <p class="text">{{ $service->resume }}</p>
                                    <a href="{{ env('APP_URL') }}service/{{ $service->id }}-{{ getEnleveAccent($service->titre) }}.html" class="btn btn-xs btn-light text-1 text-uppercase">{{ __('liresuite') }}</a>
                                    <div class="box-footer">
                                        <div class="box-count">
                                            <span>0{{ $i }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						@endforeach
                        
                    </div>
                </div>
            </section>
            @endif

            
        </div>

        <div class="wrapper-section bg-theme3 br-30 overflow-hidden mb-30 md-mb-0">
            <!--==============================
            Testimonial Section
            ==============================-->
            @if (count($temoignages) > 0)
            <section class="testimonial-section space-top pb-90 style-4">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="testi-content-wrap">
                                <div class="title-area two">
                                    <div class="sub-title"><span><i class="asterisk"></i></span>{{ __('temoignage_last') }}</div>
                                    <h2 class="sec-title">{!! __('temoignage_last2') !!}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="testi-slider-5 swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($temoignages as $temoignage)
                                    <div class="swiper-slide">
                                        <div class="testimonial-card">
                                            <div class="inner-box">
                                                @if ($temoignage->vignette != '')
                                                <div class="image-box">
                                                    <img class="br-10" src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $temoignage->vignette }}&w=312&h=380&zc=1&q=100" alt="{{ $temoignage->nom }}">
                                                </div>
                                                @endif
                                                <div class="content">
                                                    
                                                    <div class="inner">
                                                        <!--<div class="d-flex justify-content-between align-items-center mb-25">
                                                            <div class="d-flex align-items-center gap-15">
                                                                <div class="icon"><img src="{{ env('APP_URL') }}site/assets/images/testimonial/home4-google.png" alt=""></div>
                                                                <div class="rating">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star-half-alt"></i>
                                                                </div>
                                                            </div>
                                                            <div class="quote-icon">
                                                                <i class="flaticon-quote"></i>
                                                            </div>
                                                        </div>-->
                                                        <p class="text">{{ $temoignage->commentaire }}</p>
                                                        
                                                    </div>
                                                    <div class="user-info">
                                                        <h5 class="user-name">{{ $temoignage->nom }}</h5>
                                                        <p class="user-title">{{ $temoignage->profil }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                </div>
                                <div class="array-button">
                                    <button class="array-prev"><i class="fa-light fa-arrow-left-long"></i></button>
                                    <button class="array-next active"><i class="fa-light fa-arrow-right-long"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @endif

            <!--==============================
            Brands Section
            ==============================-->
            @if (count($partenaires) > 0)
            <div class="brands-section space-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sponsors-outer">
                                <div class="trusted-partners mt--15"><span class="bg-theme3 pr-10">{{ __('partenaire_last2') }}</span></div>
                                <div class="brands-slider swiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($partenaires as $partenaire)
                                        @if ($partenaire->vignette != '')
                                        <div class="swiper-slide">
                                            <div class="brand-item">
                                                <a class="image" href="{{ env('APP_URL') }}partenaire/{{ $partenaire->id }}-{{ getEnleveAccent($partenaire->titre) }}.html">
                                                    <img src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $partenaire->vignette }}&w=125&h=50&zc=1&q=100" alt="{{ $partenaire->titre }}">
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                        
                                    </div>
                                </div>
                                <!--<div class="trusted-partners text-right mb--10"><span class="bg-theme3 pl-10">Almost <span class="text-theme">3k+ Partners</span> we have</span></div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif	
        </div>

        
        <div class="wrapper-section br-30">
            
            <!--==============================
            Call To Action Section Three
            ==============================-->
            <section class="cta-section style-3 space">
                <div class="bg image"><img src="{{ env('APP_URL') }}site/assets/images/choose/home4-bg01.jpg" alt=".."></div>
                <div class="overlay"></div>
                <div class="container">
                    <div class="row gy-30 align-items-center">
                        <div class="col-lg-3">
                            <div class="image-box">
                                <div class="thumb"><img src="{{ env('APP_URL') }}site/assets/images/choose/home4-img01.png" alt=""></div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="cta-text">
                                <div class="title-area mb-0 white">
                                    <h2 class="sec-title" style="font-size: 30px !important;">{!! __('contact_index3') !!}</h2>
                                </div>
                                <p><i class="fa-regular fa-check"></i> {{ __('contact_index2') }}</p>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="cta-button">
                                <a href="{{ env('APP_URL') }}contacts.html" class="cta-link"><i class="icon-arrow-up-right"></i> {{ __('contact_index') }}</a>
                              </div>
                        </div>
                    </div>
                </div>
            </section>

            <!--==============================
            Blog Section
            ==============================-->
            @if (count($actualites) > 0)
            <section class="blog-section space bg-theme3">
                <div class="container">
                    <div class="title-area three text-center">
                        <div class="sub-title"><span><i class="asterisk"></i></span>{{ __('actualite_last') }}</div>
                        <h2 class="sec-title">{{ __('actualite_last2') }}</h2>
                    </div>
                    <div class="row gy-30">
                        @foreach ($actualites as $actualite)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <article class="blog-single-box">
                                <div class="inner-box">
                                    @if ($actualite->vignette != '')
                                    <div class="blog-image">
                                        <img src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $actualite->vignette }}&w=550&h=412&zc=1&q=100" alt="{{ $actualite->titre }}">
                                        @if ($actualite->actualitetype_id > 0)
                                        <div class="category-tag">
                                            {{ $actualite->actualitetype->titre ?? '' }}
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                    <div class="blog-content">
                                        <div class="author">
                                            <span class="name">{{ \Carbon\Carbon::parse($actualite->dateactualite)->translatedFormat('d F Y') }}</span>
                                        </div>
                                        <div class="pt-25 pb-20"><div class="border dark"></div></div>
                                        <h4 class="title"><a href="{{ env('APP_URL') }}actualite/{{ $actualite->id }}-{{ getEnleveAccent($actualite->titre) }}.html">{{ $actualite->titre }}</a></h4>
                                        <p class="text">{{ $actualite->resume }}</p>
                                        <a href="{{ env('APP_URL') }}actualite/{{ $actualite->id }}-{{ getEnleveAccent($actualite->titre) }}.html" class="continue-reading">{{ __('liresuite') }}</a>
                                    </div>
                                </div>
                            </article>                        
                        </div>
                        @endforeach
                        
                    </div>
                </div>
            </section>
            @endif


            <!--======= Contact Wrapper =======-->
            <!--<div class="contact-wrapper space-bottom bg-theme3">
                <div class="contact-option">
                    <i class="fa-regular fa-envelope"></i>
                    <span>Looking for help?</span>
                    <a href="contact.html" class="contact-link">Contact us Today</a>
                </div>
                <div class="social-option">
                    <i class="fa-regular fa-thumbs-up"></i>
                    <span>Keep in touch</span>
                    <a href="#" class="social-link">Like us on Facebook</a>
                </div>
            </div>-->
		</div>
				

@endsection

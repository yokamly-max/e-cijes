@extends('layouts.site2')

@section('title')
    {{ __('contact_formulaire') }}
@endsection

@section('entite')
    {{ __('contact_page') }}
@endsection


@section('contenu')
        <!-- Start Breadcrumb Section -->
        <!-- ========================================== -->
        <section class="breadcrumb-section">
            <div class="bg bg-image" style="background-image: url('{{ env('APP_URL') . $slider->vignette }}')"></div>
            <div class="container">
                <div class="title-outer">
                    <div class="page-title">
                        <h2 class="title">{{ __('contact_formulaire') }}</h2>
                        <ul class="page-breadcrumb">
                            <li><a href="{{ route('index.index') }}">{{ __('accueil') }}</a></li>
                            <li>{{ __('contact_page') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- ========================================== -->
        <!-- End Breadcrumb Section -->


        
        <!--==============================
        Contact Section Two
        ==============================-->
        <section class="contact-section style-2 space bg-theme3">
            <div class="container">
                <div class="row gy-30">
                    <div class="col-lg-5">
                        <div class="contact-content-wrap">
                            <div class="title-area twoT">
                                <div class="sub-title"><span><i class="asterisk"></i></span>{{ __('contact_page') }}</div>
                                <h2 class="sec-title">{{ __('contact_page2') }}</h2>
                                <p class="sec-text text-gray">{{ __('contact_page3') }}</p>
                            </div>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <div class="icon">
                                        <i class="fa-sharp fa-regular fa-location-dot"></i>
                                    </div>
                                    <div class="info">
                                        <h4 class="title">{{ __('adressesite') }}</h4>
                                        <p>{{ __('adressesite2') }}</p>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <div class="icon">
                                        <i class="fa-light fa-circle-phone"></i>
                                    </div>
                                    <div class="info">
                                        <h4 class="title">{{ __('telephonesite') }}</h4>
                                        <div class="content">
                                            {{ __('telephonesite_') }}: <a href="tel:{{ __('telephonesite3') }}">{{ __('telephonesite2') }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <div class="icon">
                                        <i class="fa-light fa-envelope"></i>
                                    </div>
                                    <div class="info">
                                        <h4 class="title">{{ __('emailsite') }}</h4>
                                        <div class="content">
                                            <a href="mailto:{{ __('emailsite2') }}">{{ __('emailsite2') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="social-links">
                                <a href="#">
                                    <span class="link-effect">
                                        <span class="effect-1">Facebook</span>
                                        <span class="effect-1">Facebook</span>
                                    </span>
                                </a>
                                <a href="#">
                                    <span class="link-effect">
                                        <span class="effect-1">Twitter/X</span>
                                        <span class="effect-1">Twitter/X</span>
                                    </span>
                                </a>
                                <a href="#">
                                    <span class="link-effect">
                                        <span class="effect-1">LinkedIn</span>
                                        <span class="effect-1">LinkedIn</span>
                                    </span>
                                </a>
                                <a href="#">
                                    <span class="link-effect">
                                        <span class="effect-1">Instagram</span>
                                        <span class="effect-1">Instagram</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="contact-form">
                            <h2 class="title mt--5 mb-35">{{ __('contact_formulaire2') }}</h2>
                            <form id="contact_form" class="contact_form" action="{{ route('contact.storeformulaire') }}" method="post">
                            @csrf

@if (session('status'))
    <div class="contact-form-success alert alert-success mt-4">
        <strong>Success!</strong> {{ session('status') }}
    </div>
@endif

@if ($errors)
    @foreach ($errors->all() as $error)
        <div class="contact-form-error alert alert-danger mt-4">
            <strong>Error!</strong> {{ $error }}
			<span class="mail-error-message text-1 d-block"></span>
        </div>
    @endforeach
@endif
                                <div class="form-grid">
                                    <div class="form-group">
                                        <span class="icon"><i class="fa-solid fa-user"></i></span>
                                        <input type="text" id="fullName" name="nom" placeholder="{{ __('commentaire_nom2') }}" required autocomplete="on" value="{{ old('nom') }}">
                                    </div>
                                    <div class="form-group">
                                        <span class="icon"><i class="fa-regular fa-envelope"></i></span>
                                        <input type="email" id="userEmail" name="email" placeholder="{{ __('contact_email2') }}" required autocomplete="on" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <!--<div class="form-grid">
                                    <div class="form-group">
                                        <span class="icon"><i class="fa-solid fa-phone"></i></span>
                                        <input type="text" id="phone" name="phone" placeholder="Phone No." required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <select class="custom-select" id="service" name="service" autocomplete="off">
                                            <option value="" disabled selected>What are you need?</option>
                                            <option value="air">Air Freight</option>
                                            <option value="ocean">Ocean Freight</option>
                                            <option value="rail">Rail transport</option>
                                            <option value="cargo">Cargo ship</option>
                                            <option value="bulk">Bulk cargo</option>
                                        </select>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <textarea id="msg" name="message" placeholder="{{ __('contact_message2') }}" required>{{ old('message') }}</textarea>
                                </div>
                                <!--<div class="form-group terms">
                                    <input type="checkbox" id="terms" required>
                                    <label for="terms">I agree to all terms and conditions.</label>
                                </div>-->
                                <!--<button type="submit" class="theme-btn bg-dark mt-35"  data-loading-text="Please wait...">
                                    <span class="link-effect">
                                        <span class="btn-title">Submit Now</span>
                                    </span><i class="fa-regular fa-arrow-right-long"></i>
                                </button>-->
                                <button type="submit" class="theme-btn bg-dark mt-35">{{ __('contact_envoie') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!--==============================
        Contact Map
        ==============================-->
        <!--<div class="contact-map">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="map-box">
                            <iframe class="map-canvas" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.2266377107035!2d90.38657937589684!3d23.73929618920158!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b85c71927841%3A0xde102c300beb3f0c!2sWebCode%20Institute!5e0!3m2!1sen!2sbd!4v1727077475625!5m2!1sen!2sbd" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>-->


@endsection

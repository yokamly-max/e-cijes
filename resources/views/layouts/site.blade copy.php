<!DOCTYPE html>
<html class="no-js" lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <title>@yield('title')</title>
    <meta content="{{ __('site_description') }}" name="description">
    <meta content="{{ __('site_name') }}" name="keywords">
    <meta content="INDEX,FOLLOW" name="robots">

    <!-- Mobile Specific Metas -->
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link href="{{ env('APP_URL') }}favicon.png" rel="icon" sizes="32x32" type="image/png">
    <meta content="#ffffff" name="msapplication-TileColor">
    <meta content="#ffffff" name="theme-color">

    <!--==============================
	  Google Fonts
	============================== -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <!--==============================
	    All CSS File
	============================== -->
    <link href="{{ env('APP_URL') }}site/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}site/assets/css/flaticon.min.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}site/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}site/assets/css/fancybox.min.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}site/assets/css/swiper-bundle.min.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}site/assets/css/animate.min.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}site/assets/css/select2.min.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}site/assets/css/jquery-ui.min.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}site/assets/css/odometer.css" rel="stylesheet">
    <!-- Theme Custom CSS -->
    <link href="{{ env('APP_URL') }}site/assets/css/style.css" rel="stylesheet">

</head>

<body id="body" class="bg-white">

    <div class="page-wrapper home-four">

        <!--==============================
        Preloader
        ==============================-->
        <!--<div class="loading-screen" id="loading-screen"> 
            <div class="preloader-close">x</div>
            <div class="animation-preloader">
                <div class="txt-loading">
                    <span data-text-preloader="B" class="letters-loading">B</span>
                    <span data-text-preloader="E" class="letters-loading">E</span>
                    <span data-text-preloader="N" class="letters-loading">N</span>
                    <span data-text-preloader="T" class="letters-loading">T</span>
                    <span data-text-preloader="O" class="letters-loading">O</span>
                    <span data-text-preloader="L" class="letters-loading">L</span>
                </div>
            </div>
        </div>-->
@php
    $pagelibre1 = DB::table('pagelibres')->where('etat', 1)->where('spotlight', 1)->where('langue_id', __('id'))->first();
    //$pagelibre2 = DB::table('pagelibres')->where('id', 1)->where('etat', 1)->where('spotlight', 0)->where('langue_id', __('id'))->first();
@endphp
        <!--==============================
        Header Area
        ==============================-->
        <header class="nav-header header-style5">
            <div class="sticky-wrapper">
                <div class="main-wrapper">
                    <!-- Main Menu Area -->
                    <div class="menu-area">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto logo">
                                <div class="header-logo">
                                    <a href="{{ env('APP_URL') }}">
                                        <img alt="logo" src="{{ env('APP_URL') }}site/assets/images/logo/logo.png">
                                        <img alt="logo" src="{{ env('APP_URL') }}site/assets/images/logo/logo.png">
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto nav-menu">
                                <nav class="main-menu d-none d-lg-inline-block lh-1 lh-1">
                                    <ul class="navigation">
                                        <li>
                                            <a href="{{ env('APP_URL') }}">{!! (__('accueil')) !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ env('APP_URL') }}page/{{ $pagelibre1->id }}-{{ getEnleveAccent($pagelibre1->titre) }}.html">{!! (__('site_menu')) !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ env('APP_URL') }}services.html">{!! (__('site_menu2')) !!}</a>
                                        </li>
                                        <li class="menu-item-has-children">
                                            <a href="#">{!! (__('site_menu3_')) !!}</a>
                                            <ul class="sub-menu">
                                                <li><a href="{{ env('APP_URL') }}partenaires.html">{!! (__('site_menu3')) !!}</a></li>
                                                <li><a href="{{ env('APP_URL') }}faqs.html">{!! (__('site_menu4')) !!}</a></li>
                                                <li><a href="{{ env('APP_URL') }}actualites.html">{!! (__('site_menu5')) !!}</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="{{ env('APP_URL') }}contacts.html">{!! (__('site_menu6')) !!}</a>
                                        </li>
                                    </ul>
                                </nav>
                                <div class="navbar-right d-inline-flex d-lg-none">
                                    <button class="menu-toggle sidebar-btn" type="button">
                                        <span class="line"></span>
                                        <span class="line"></span>
                                        <span class="line"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-auto header-right-wrapper">
                                <div class="header-right">
                                    <a href="tel:{{ __('telephonesite3') }}" class="header-btn"><span class="fa-solid fa-headphones"></span>{{ __('telephonesite2') }}</a>
                                    <button class="search-btn">
                                        <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    </button>
                                    <a href="https://p-cijes.cjes.africa/" class="theme-btn bg-theme" target="_blank">
                                        <span class="link-effect">
                                            <span class="effect-1">{{ __('site_connexion') }}</span>
                                            <span class="effect-1">{{ __('site_connexion') }}</span>
                                        </span><i class="fa-regular fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!--==============================
        Mobile Menu
        ============================== -->
        <div class="mobile-menu-wrapper">
            <div class="mobile-menu-area">
                <button class="menu-toggle"><i class="fas fa-times"></i></button>
                <div class="mobile-logo">
                    <a href="{{ env('APP_URL') }}"><img alt="" src="{{ env('APP_URL') }}site/assets/images/logo/logo-2.png"></a>
                </div>
                <div class="mobile-menu">
                    <ul class="navigation clearfix">
                        <!--Keep This Empty / Menu will come through Javascript-->
                    </ul>
                </div>
                <div class="sidebar-wrap">
                    <h6>{{ __('adressesite2') }}</h6>
                </div>
                <div class="sidebar-wrap">
                    <h6><a href="tel:{{ __('telephonesite3') }}">{{ __('telephonesite2') }}</a></h6>
                    <h6><a href="mailto:{{ __('emailsite2') }}">{{ __('emailsite2') }}</a></h6>
                </div>
                <div class="social-btn style3">
                    <a href="https://www.facebook.com/people/Conf%C3%A9d%C3%A9ration-des-Juniors-Entreprises-du-Togo/61552961216434/" target="_blank">
                        <span class="link-effect">
                            <span class="effect-1"><i class="fab fa-facebook"></i></span>
                            <span class="effect-1"><i class="fab fa-facebook"></i></span>
                        </span>
                    </a>
                    <a href="https://instagram.com/">
                        <span class="link-effect">
                            <span class="effect-1"><i class="fab fa-instagram"></i></span>
                            <span class="effect-1"><i class="fab fa-instagram"></i></span>
                        </span>
                    </a>
                    <a href="https://twitter.com/">
                        <span class="link-effect">
                            <span class="effect-1"><i class="fab fa-twitter"></i></span>
                            <span class="effect-1"><i class="fab fa-twitter"></i></span>
                        </span>
                    </a>
                    <a href="https://www.linkedin.com/company/cjet-confederations-des-juniors-entreprises-du-togo/?viewAsMember=true" target="_blank">
                        <span class="link-effect">
                            <span class="effect-1"><i class="fab fa-linkedin"></i></span>
                            <span class="effect-1"><i class="fab fa-linkedin"></i></span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <!--==============================
        Sticky Header
        ============================== -->
        <div class="sticky-header">
            <div class="container">
                <!-- Main Menu Area -->
                <div class="menu-area">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto logo">
                            <div class="header-logo">
                                <a href="{{ env('APP_URL') }}">
                                    <img alt="logo" src="{{ env('APP_URL') }}site/assets/images/logo/logo-2.png">
                                    <img alt="logo" src="{{ env('APP_URL') }}site/assets/images/logo/logo.png">
                                </a>
                            </div>
                        </div>
                        <div class="col-auto nav-menu">
                            <nav class="main-menu d-none d-lg-inline-block">
                                <ul class="navigation clearfix">
                                    <!--Keep This Empty / Menu will come through Javascript-->
                                </ul>
                            </nav>
                            <div class="navbar-right d-inline-flex d-lg-none">
                                <button class="menu-toggle sidebar-btn" type="button">
                                    <span class="line"></span>
                                    <span class="line"></span>
                                    <span class="line"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Area -->

        <!-- Header Search -->
        <div class="search-popup">
            <button class="close-search"><i class="fa-solid fa-xmark"></i></button>
            <form method="get" action="{{ route('index.recherche') }}">
                @csrf
                <div class="form-group">
                    <input id="search" type="search" name="recherche" placeholder="Recherche..." required="">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
        <!-- End Header Search -->




			

            @yield('contenu')



				

            <!--==============================
                Footer Section
            ==============================-->
            <footer class="footer-section bg-dark style-2 overflow-hidden br_bl-30 br_br-30">
                <div class="footer-top space">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 col-md-5 col-sm-6">
                                <div class="footer-widget">
                                    <h2 class="big-title">{!! __('footersite') !!}</h2>

                                <script language="javascript1.3" src="{{ env('APP_URL') }}newsletters.js"></script>

                                    <form class="newsletter-form" action="#" method="post">
                                        <div class="form-group">
                                            <div id="nivonewsletter">
                                            <input type="email" id="email" name="email" class="email" value="" placeholder="{{ __('newsletter_email') }}" autocomplete="on" required="">
                                            </div>
                                            <button type="button" style="
    display: inline-block;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    right: 10px;
    width: 38px;
    height: 38px;
    font-size: 16px;
    color: var(--white-color);
    background: var(--theme-color);
    border-radius: 50%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;" onclick="ouvre_newsletters(document.getElementById('email').value, 'nivonewsletter');">
                                                <i class="far fa-paper-plane"></i>
                                                <span class="btn-title"></span>
                                            </button>
                                        </div>
                                    </form>
                                    <div class="notify"><div class="icon"><i class="fa-regular fa-bell"></i></div> {{ __('newsletter_name2') }}</div>
                                </div>
                            </div>
                            <div class="col-lg-1 md-d-none"></div>
                            <div class="col-lg-3 col-md-2">
                                <div class="footer-widget ml-0">
                                    <h4 class="title">{{ __('autresliens') }}</h4>
                                    <ul class="list-unstyled">
                                        <li>
                                            <a href="{{ env('APP_URL') }}page/{{ $pagelibre1->id }}-{{ getEnleveAccent($pagelibre1->titre) }}.html">{!! (__('site_menu')) !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ env('APP_URL') }}services.html">{!! (__('site_menu2')) !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ env('APP_URL') }}partenaires.html">{!! (__('site_menu3')) !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ env('APP_URL') }}faqs.html">{!! (__('site_menu4')) !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ env('APP_URL') }}actualites.html">{!! (__('site_menu5')) !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ env('APP_URL') }}contacts.html">{!! (__('site_menu6')) !!}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="footer-widget social sm-mb-0">
                                    <h3 class="hello-title">Say hello</h3>
                                    <p><a class="email" href="mailto:{{ __('emailsite2') }}">{{ __('emailsite2') }}</a></p>
                                    <p><a class="number" href="tel:{{ __('telephonesite3') }}">{{ __('telephonesite2') }}</a></p>
                                    <hr />
                                    <div class="social-links">
                                        <a href="https://www.facebook.com/people/Conf%C3%A9d%C3%A9ration-des-Juniors-Entreprises-du-Togo/61552961216434/" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                                        <a href="#" class="social-icon"><i class="fab fa-x-twitter"></i></a>
                                        <a href="https://www.linkedin.com/company/cjet-confederations-des-juniors-entreprises-du-togo/?viewAsMember=true" target="_blank" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                                        <a href="#" class="social-icon"><i class="fab fa-pinterest-p"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row footer-bottom align-items-center">
                        <div class="col-md-2 md-mb-20">
                            <a href="{{ env('APP_URL') }}"><img src="{{ env('APP_URL') }}site/assets/images/logo/logo-2.png" alt=""></a>
                        </div>
                        <div class="col-md-10 text-md-end">
                            <p class="mb-0">{!! __('copyright') !!}</p>
                        </div>
                    </div>
                </div>
            </footer>    
    
    </div><!-- End Page Wrapper -->


    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" height="100%" viewBox="-1 -1 102 102" width="100%">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
        </svg>
    </div>


    <!-- Jquery -->
    <script src="{{ env('APP_URL') }}site/assets/js/vendor/jquery.min.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js/bootstrap.min.js"></script>

    <script src="{{ env('APP_URL') }}site/assets/js/swiper-bundle.min.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js/marquee.min.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js/jquery.fancybox.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js/select2.min.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js/jquery-ui.min.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js/jquery.validate.min.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js/jquery.appear.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js//jquery.odometer.min.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js/wow.min.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js/isotope.pkgd.min.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js/lenis.min.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js/splite-type.min.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js/vanilla-tilt.min.js"></script>
    <script src="{{ env('APP_URL') }}site/assets/js/chart.min.js"></script>
    
    <!-- Main Js File -->
    <script src="{{ env('APP_URL') }}site/assets/js/main.js"></script>

</body>


</html>
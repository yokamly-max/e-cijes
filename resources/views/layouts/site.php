<!DOCTYPE html>
<html lang="fr">
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>@yield('title')</title>	

		<meta name="keywords" content="{{ __('site_name') }}" />
		<meta name="description" content="{{ __('site_description') }}">
		<meta name="author" content="okler.net">

		<!-- Favicon -->
		<link rel="shortcut icon" href="{{ env('APP_URL') }}site/img/favicon.png" type="image/x-icon" />
		<link rel="apple-touch-icon" href="{{ env('APP_URL') }}site/img/apple-touch-icon.png">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

		<!-- Web Fonts  -->
		<link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CShadows+Into+Light&display=swap" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{ env('APP_URL') }}site/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="{{ env('APP_URL') }}site/vendor/fontawesome-free/css/all.min.css">
		<link rel="stylesheet" href="{{ env('APP_URL') }}site/vendor/animate/animate.compat.css">
		<link rel="stylesheet" href="{{ env('APP_URL') }}site/vendor/simple-line-icons/css/simple-line-icons.min.css">
		<link rel="stylesheet" href="{{ env('APP_URL') }}site/vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="{{ env('APP_URL') }}site/vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="{{ env('APP_URL') }}site/vendor/magnific-popup/magnific-popup.min.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{ env('APP_URL') }}site/css/theme.css">
		<link rel="stylesheet" href="{{ env('APP_URL') }}site/css/theme-elements.css">
		<link rel="stylesheet" href="{{ env('APP_URL') }}site/css/theme-blog.css">
		<link rel="stylesheet" href="{{ env('APP_URL') }}site/css/theme-shop.css">

		<!-- Skin CSS -->
		<link id="skinCSS" rel="stylesheet" href="{{ env('APP_URL') }}site/css/skins/default.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{ env('APP_URL') }}site/css/custom.css">

	</head>
	<body data-plugin-page-transition>
		<div class="body">
			<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 70}">
				<div class="header-body border-color-primary header-body-bottom-border">
					<div class="header-top header-top-default border-bottom-0">
						<div class="container">
							<div class="header-row py-2">
								<div class="header-column justify-content-start">
									<div class="header-row">
										<nav class="header-nav-top">
										<nav class="header-nav-top">
											<ul class="nav nav-pills">

												<li class="nav-item">
													<a href="https://grm.aau.org/" target="_blank">MGRP</a>
												</li>
												<li class="nav-item">
													<a href="{{ env('APP_URL') }}faqs.html"><i class="fas fa-chart-bar text-4 text-color-primary" style="top: 0;"></i> {{ __('faq_page') }}</a>
												</li>
												<li class="nav-item">
													<a href="{{ env('APP_URL') }}publications.html"><i class="far fa-calendar-alt text-4 text-color-primary" style="top: 0;"></i> {{ __('publication_page') }}</a>
												</li>
												<li class="nav-item">
													<a href="{{ env('APP_URL') }}liens.html"><i class="fas fa-compress text-4 text-color-primary" style="top: 0;"></i> {{ __('lien_page') }}</a>
												</li>
												<li class="nav-item">
													<a href="http://www.cersa-togo.org/webmail" target="_blank"><i class="fas fa-envelope text-4 text-color-primary" style="top: 0;"></i> Webmail</a>
												</li>
@if(__('id') == 1)
												<li class="nav-item">
													<a href="{{ env('APP_URL') }}language/en"><img src="{{ env('APP_URL') }}site/img/blank.gif" class="flag flag-us" alt="English" /></a>
												</li>
@endif
@if(__('id') == 2)
												<li class="nav-item">
													<a href="{{ env('APP_URL') }}language/fr"><img src="{{ env('APP_URL') }}site/img/blank.gif" class="flag flag-fr" alt="Français" /></a>
												</li>
@endif

												<!-- <li class="nav-item dropdown nav-item-left-border  d-sm-block nav-item-left-border-remove nav-item-left-border-md-show">
													<a class="nav-link" href="#" role="button" id="dropdownLanguage" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<img src="{{ env('APP_URL') }}site/img/blank.gif" class="flag flag-us" alt="English" /> English
														<i class="fas fa-angle-down"></i>
													</a>
													<div class="dropdown-menu" aria-labelledby="dropdownLanguage">
														<a class="dropdown-item" href="#"><img src="{{ env('APP_URL') }}site/img/blank.gif" class="flag flag-us" alt="English" /> English</a>
														<a class="dropdown-item" href="#"><img src="{{ env('APP_URL') }}site/img/blank.gif" class="flag flag-fr" alt="Française" /> Française</a>
													</div>
												</li> -->
												
											</ul>										

										</nav>
									</div>
								</div>
								<div class="header-column justify-content-end">
									<div class="header-row">
										<nav class="header-nav-top">

										<ul class="header-social-icons social-icons d-sm-block header-nav-top">
											<li class="social-icons-facebook"><a href="https://www.facebook.com/CERSATOGO/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
											<li class="social-icons-twitter"><a href="https://twitter.com/cersatogo1" target="_blank" title="Twitter"><i class="fab fa-x-twitter"></i></a></li>
											<li class="social-icons-youtube"><a href="https://www.youtube.com/channel/UC2OZOY64-3xYGijp1q1sw_Q" target="_blank" title="Youtube"><i class="fab fa-youtube"></i></a></li>
										</ul>
										</nav>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column">
								<div class="header-row">
									<div class="header-logo">
										<a href="{{ env('APP_URL') }}">
											<img alt="{{ env('APP_NAME') }}" height="100"  data-sticky-height="50"  src="{{ env('APP_URL') }}site/img/logo-default-slim.png">
										</a>
									</div>
								</div>
							</div>
							<div class="header-column justify-content-end">
								<div class="header-row">
									<div class="header-nav header-nav-links order-2 order-lg-1">
										<div class="header-nav-main header-nav-main-square header-nav-main-effect-2 header-nav-main-sub-effect-1">
											<nav class="collapse">
												<ul class="nav nav-pills" id="mainNav">
                                                    <li class="dropdown">
                                                        <a class="dropdown-item" href="{{ env('APP_URL') }}">
                                                            {!! strtoupper(__('accueil')) !!}
                                                        </a>
                                                    </li>
    
                                                    @php
                                                        $menus = DB::table('menus')
                                                            ->where('parent', 0)
                                                            ->where('etat', 1)
                                                            ->orderBy('ordre', 'asc')
                                                            ->get();
                                                    @endphp
    
                                                    @foreach ($menus as $menu)
                                                        @if ($menu->url != '')
                                                            <li class="dropdown">
                                                                <a class="dropdown-item" href="{{ $menu->url }}">
                                                                    {!! strtoupper($menu->titre) !!}
                                                                </a>
                                                            </li>
                                                        @elseif ($menu->table_id > 0)
                                                            @php
                                                                $tabletype = DB::select(
                                                                    'select * from tabletypes where id = ' .
                                                                        $menu->tabletype_id .
                                                                        '',
                                                                );
                                                                $tables = $tabletype[0]->table;
                                                                $table_ = substr($tables, 0, -1);
                                                                $table_ = str_replace('pagelibre', 'page', $table_);
                                                                $tabletitre = 'titre';
                                                                $table_titre = ucfirst($tabletype[0]->titre);
    
                                                                //$table_s = DB::select('select * from '.$tables.' where id = '.$menu->table_id.'');
                                                                //echo $table_s[0]->titre;
    
                                                            @endphp
                                                            <li class="dropdown">
                                                                <a class="dropdown-item"
                                                                    href="{{ env('APP_URL') }}{{ $table_ }}/{{ $menu->table_id }}-{{ getEnleveAccent($menu->titre) }}.html">
                                                                    {!! strtoupper($menu->titre) !!}
                                                                </a>
                                                            </li>
                                                        @elseif ($menu->tabletype_id > 0)
                                                            @php
                                                                $tabletype = DB::select(
                                                                    'select * from tabletypes where id = ' .
                                                                        $menu->tabletype_id .
                                                                        '',
                                                                );
                                                                $tables = $tabletype[0]->table;
                                                                $table_ = substr($tables, 0, -1);
                                                                $table_ = str_replace('pagelibre', 'page', $table_);
                                                                $tabletitre = 'titre';
                                                                $table_titre = ucfirst($tabletype[0]->titre);
    
                                                                //$table_s = DB::select('select * from '.$tables.' where id = '.$menu->table_id.'');
                                                                //echo $table_s[0]->titre;
    
                                                            @endphp
                                                            <li class="dropdown">
                                                                <a class="dropdown-item"
                                                                    href="{{ env('APP_URL') }}{{ $table_ }}s.html">
                                                                    {!! strtoupper($menu->titre) !!}
                                                                </a>
                                                            </li>
                                                        @else
                                                            @php
                                                                $menu2s = DB::table('menus')
                                                                    ->where('parent', $menu->id)
                                                                    ->where('etat', 1)
                                                                    ->orderBy('ordre', 'asc')
                                                                    ->get();
                                                            @endphp
    
                                                            @if (count($menu2s) > 0)
                                                                <li class="dropdown">
                                                                    <a class="dropdown-item dropdown-toggle" href="#">
                                                                        {!! strtoupper($menu->titre) !!}
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        @foreach ($menu2s as $menu2)
                                                                            @if ($menu2->url != '')
                                                                                <li>
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ $menu2->url }}">
                                                                                        {!! strtoupper($menu2->titre) !!}
                                                                                    </a>
                                                                                </li>
                                                                            @elseif ($menu2->table_id > 0)
                                                                                @php
                                                                                    $tabletype = DB::select(
                                                                                        'select * from tabletypes where id = ' .
                                                                                            $menu2->tabletype_id .
                                                                                            '',
                                                                                    );
                                                                                    $tables = $tabletype[0]->table;
                                                                                    $table_ = substr($tables, 0, -1);
                                                                                    $table_ = str_replace('pagelibre', 'page', $table_);
                                                                                    $tabletitre = 'titre';
                                                                                    $table_titre = ucfirst(
                                                                                        $tabletype[0]->titre,
                                                                                    );
    
                                                                                    //$table_s = DB::select('select * from '.$tables.' where id = '.$menu2->table_id.'');
                                                                                    //echo $table_s[0]->titre;
    
                                                                                @endphp
                                                                                <li>
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ env('APP_URL') }}{{ $table_ }}/{{ $menu2->table_id }}-{{ getEnleveAccent($menu2->titre) }}.html">
                                                                                        {!! strtoupper($menu2->titre) !!}
                                                                                    </a>
                                                                                </li>
                                                                            @elseif ($menu2->tabletype_id > 0)
                                                                                @php
                                                                                    $tabletype = DB::select(
                                                                                        'select * from tabletypes where id = ' .
                                                                                            $menu2->tabletype_id .
                                                                                            '',
                                                                                    );
                                                                                    $tables = $tabletype[0]->table;
                                                                                    $table_ = substr($tables, 0, -1);
                                                                                    $table_ = str_replace('pagelibre', 'page', $table_);
                                                                                    $tabletitre = 'titre';
                                                                                    $table_titre = ucfirst(
                                                                                        $tabletype[0]->titre,
                                                                                    );
    
                                                                                    //$table_s = DB::select('select * from '.$tables.' where id = '.$menu2->table_id.'');
                                                                                    //echo $table_s[0]->titre;
    
                                                                                @endphp
                                                                                <li>
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ env('APP_URL') }}{{ $table_ }}s.html">
                                                                                        {!! strtoupper($menu2->titre) !!}
                                                                                    </a>
                                                                                </li>
                                                                            @else
    
                                                                            @php
                                                                                $menu3s = DB::table('menus')
                                                                                    ->where('parent', $menu2->id)
                                                                                    ->where('etat', 1)
                                                                                    ->orderBy('ordre', 'asc')
                                                                                    ->get();
                                                                            @endphp
    
                                                                            @if (count($menu3s) > 0)
                                                                                <li class="dropdown-submenu">
                                                                                    <a class="dropdown-item" href="#">
                                                                                        {!! strtoupper($menu2->titre) !!}
                                                                                    </a>
                                                                                    <ul class="dropdown-menu">
                                                                                        @foreach ($menu3s as $menu3)
                                                                                            @if ($menu3->url != '')
                                                                                                <li>
                                                                                                    <a class="dropdown-item"
                                                                                                        href="{{ $menu3->url }}">
                                                                                                        {!! strtoupper($menu3->titre) !!}
                                                                                                    </a>
                                                                                                </li>
                                                                                            @elseif ($menu3->table_id > 0)
                                                                                                @php
                                                                                                    $tabletype = DB::select(
                                                                                                        'select * from tabletypes where id = ' .
                                                                                                            $menu3->tabletype_id .
                                                                                                            '',
                                                                                                    );
                                                                                                    $tables = $tabletype[0]->table;
                                                                                                    $table_ = substr($tables, 0, -1);
                                                                                                    $table_ = str_replace('pagelibre', 'page', $table_);
                                                                                                    $tabletitre = 'titre';
                                                                                                    $table_titre = ucfirst(
                                                                                                        $tabletype[0]->titre,
                                                                                                    );
    
                                                                                                    //$table_s = DB::select('select * from '.$tables.' where id = '.$menu3->table_id.'');
                                                                                                    //echo $table_s[0]->titre;
    
                                                                                                @endphp
                                                                                                <li>
                                                                                                    <a class="dropdown-item"
                                                                                                        href="{{ env('APP_URL') }}{{ $table_ }}/{{ $menu3->table_id }}-{{ getEnleveAccent($menu3->titre) }}.html">
                                                                                                        {!! strtoupper($menu3->titre) !!}
                                                                                                    </a>
                                                                                                </li>
                                                                                            @elseif ($menu3->tabletype_id > 0)
                                                                                                @php
                                                                                                    $tabletype = DB::select(
                                                                                                        'select * from tabletypes where id = ' .
                                                                                                            $menu3->tabletype_id .
                                                                                                            '',
                                                                                                    );
                                                                                                    $tables = $tabletype[0]->table;
                                                                                                    $table_ = substr($tables, 0, -1);
                                                                                                    $table_ = str_replace('pagelibre', 'page', $table_);
                                                                                                    $tabletitre = 'titre';
                                                                                                    $table_titre = ucfirst(
                                                                                                        $tabletype[0]->titre,
                                                                                                    );
    
                                                                                                    //$table_s = DB::select('select * from '.$tables.' where id = '.$menu3->table_id.'');
                                                                                                    //echo $table_s[0]->titre;
    
                                                                                                @endphp
                                                                                                <li>
                                                                                                    <a class="dropdown-item"
                                                                                                        href="{{ env('APP_URL') }}{{ $table_ }}s.html">
                                                                                                        {!! strtoupper($menu3->titre) !!}
                                                                                                    </a>
                                                                                                </li>
                                                                                            @else
                                                                                                <li>
                                                                                                    <a class="dropdown-item"
                                                                                                        href="#">
                                                                                                        {!! strtoupper($menu3->titre) !!}
                                                                                                    </a>
                                                                                                </li>
                                                                                            @endif
                                                                                        @endforeach
    
                                                                                    </ul>
                                                                                </li>
                                                                            @else
                                                                                <li>
                                                                                    <a class="dropdown-item"
                                                                                        href="#">
                                                                                        {!! strtoupper($menu2->titre) !!}
                                                                                    </a>
                                                                                </li>
                                                                            @endif
                                                                            @endif
                                                                        @endforeach
    
                                                                    </ul>
                                                                </li>
                                                            @else
                                                                <li class="dropdown">
                                                                    <a class="dropdown-item" href="#">
                                                                        {!! strtoupper($menu->titre) !!}
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endif
    
    
                                                    @endforeach
                                                    <!-- <li class="dropdown">
                                                        <a class="dropdown-item"
                                                            href="{{ env('APP_URL') }}contacts.html">
                                                            {!! strtoupper(__('contact_menu')) !!}
                                                        </a>
                                                    </li> -->
                                                </ul>
											</nav>
										</div>

										<button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
											<i class="fas fa-bars"></i>
										</button>
									</div>
									<div class="header-nav-features header-nav-features-no-border header-nav-features-lg-show-border order-1 order-lg-2">
										<div class="header-nav-feature header-nav-features-search d-inline-flex">
											<a href="#" class="header-nav-features-toggle text-decoration-none" data-focus="headerSearch" aria-label="Search"><i class="fas fa-search header-nav-top-icon"></i></a>
											<div class="header-nav-features-dropdown" id="headerTopSearchDropdown">
												<form role="search" action="{{ route('index.recherche') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                        <div class="simple-search input-group">
                                                            <input class="form-control text-1" id="recherche" name="recherche" type="search" value="{{ old('recherche') }}" placeholder="Search...">
                                                            <button class="btn" type="submit" aria-label="Search">
                                                                <i class="fas fa-search header-nav-top-icon"></i>
                                                            </button>
                                                        </div>
                                                    </form>
											</div>
										</div>
										
									</div>
								</div>
							</div>
							<div class="header-column">
								<div class="header-row">
									<div class="header-logo">
										<a href="index.html">
											<img alt="UNIVERSITE DE LOME" height="100"  data-sticky-height="50"  src="{{ env('APP_URL') }}site/img/logo-ul-slim.png">
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>



			

            @yield('contenu')



				

			<footer id="footer">
				<div class="container">

                    <script language="javascript1.3" src="{{ env('APP_URL') }}newsletters.js"></script>

					<div class="row py-5 my-4">
						<div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
							<h5 class="text-3 mb-3">{{ __('newsletter_name') }}</h5>
							<p class="pe-1">{{ __('newsletter_name2') }}</p>
                            <div id="nivonewsletter">
							<form id="newsletterForm" action="#" method="GET" class="me-4 mb-3 mb-md-0">
                            @csrf

								<div class="input-group input-group-rounded">
									<input class="form-control form-control-sm bg-light" placeholder="{{ __('newsletter_email') }}" name="email" id="email" type="email">
									<button class="btn btn-light text-color-dark" type="button" onclick="ouvre_newsletters(document.getElementById('email').value);"><strong>GO!</strong></button>
								</div>
							</form>
                        </div>
						</div>
						<div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
							<h5 class="text-3 mb-3">{{ __('autresliens') }}</h5>
							<ul class="list-unstyled mb-0">
								<li class="mb-2 pb-1">
									<a href="https://grm.aau.org/" target="_blank">
										<p class="text-3 text-color-light opacity-8 mb-0"><i class="fas fa-angle-right text-color-primary"></i><strong class="ms-2 font-weight-semibold">MGRP</strong></p>
										
									</a>
								</li>
								<li class="mb-2 pb-1">
									<a href="{{ env('APP_URL') }}faqs.html">
										<p class="text-3 text-color-light opacity-8 mb-0"><i class="fas fa-angle-right text-color-primary"></i><strong class="ms-2 font-weight-semibold">{{ __('faq_page') }}</strong></p>
										
									</a>
								</li>
								<li>
									<a href="{{ env('APP_URL') }}publications.html">
										<p class="text-3 text-color-light opacity-8 mb-0"><i class="fas fa-angle-right text-color-primary"></i><strong class="ms-2 font-weight-semibold">{{ __('publication_page') }}</strong></p>
										
									</a>
								</li>
								<li>
									<a href="{{ env('APP_URL') }}liens.html">
										<p class="text-3 text-color-light opacity-8 mb-0"><i class="fas fa-angle-right text-color-primary"></i><strong class="ms-2 font-weight-semibold">{{ __('lien_page') }}</strong></p>
										
									</a>
								</li>
							</ul>
						</div>
						<div class="col-md-6 col-lg-4 mb-4 mb-md-0">
							<div class="contact-details">
								<h5 class="text-3 mb-3">{{ __('contact_page') }} </h5>
								<ul class="list list-icons list-icons-lg">
									<li class="mb-1"><i class="far fa-dot-circle text-color-primary"></i><p class="m-0">{!! __('adressesite') !!}</p></li>
									<li class="mb-1"><i class="fab fa-whatsapp text-color-primary"></i><p class="m-0"><a href="tel:{{ __('telephonesite2') }}">{{ __('telephonesite') }}</a></p></li>
									<li class="mb-1"><i class="far fa-envelope text-color-primary"></i><p class="m-0"><a href="mailto:{{ __('emailsite') }}">{{ __('emailsite') }}</a></p></li>
								</ul>
							</div>
						</div>
						<div class="col-md-6 col-lg-2">
							<h5 class="text-3 mb-3">{{ __('reseauxsociaux') }}</h5>
							<ul class="social-icons">
								<li class="social-icons-facebook"><a href="https://www.facebook.com/CERSATOGO/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
								<li class="social-icons-twitter"><a href="https://twitter.com/cersatogo1" target="_blank" title="Twitter"><i class="fab fa-x-twitter"></i></a></li>
								<li class="social-icons-youtube"><a href="https://www.youtube.com/channel/UC2OZOY64-3xYGijp1q1sw_Q" target="_blank" title="Youtube"><i class="fab fa-youtube"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="footer-copyright">
					<div class="container py-2">
						<div class="row py-4">

							<div class="col-lg-6 d-flex align-items-center justify-content-center justify-content-lg-start mb-4 mb-lg-0">
								<p>{!! __('copyright') !!}</p>
							</div>
							<div class="col-lg-6 d-flex align-items-center justify-content-center justify-content-lg-end">
								<nav id="sub-menu">
									<ul>
										<li><i class="fas fa-angle-right"></i><a href="{{ env('APP_URL') }}contacts.html" class="ms-1 text-decoration-none"> {{ __('contact_page') }} </a></li>
										<li><i class="fas fa-angle-right"></i><a href="http://www.cersa-togo.org/webmail" target="_blank" class="ms-1 text-decoration-none"> Webmail </a></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>

		<!-- Vendor -->
		<script src="{{ env('APP_URL') }}site/vendor/plugins/js/plugins.min.js"></script>

		<!-- Theme Base, Components and Settings -->
		<script src="{{ env('APP_URL') }}site/js/theme.js"></script>

		<!-- Theme Custom -->
		<script src="{{ env('APP_URL') }}site/js/custom.js"></script>

		<!-- Theme Initialization Files -->
		<script src="{{ env('APP_URL') }}site/js/theme.init.js"></script>

	<!-- Examples -->
		<script src="{{ env('APP_URL') }}site/js/examples/examples.portfolio.js"></script>

	</body>
</html>

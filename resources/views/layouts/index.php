@extends('layouts.site')

@section('title')
	{{ __('site_name') }}
@endsection


@section('contenu')

<div role="main" class="main">
	@if (count($grosplans) > 0)
	<div class="owl-carousel owl-carousel-light owl-carousel-light-init-fadeIn owl-theme manual dots-inside dots-horizontal-center dots-light show-dots-hover show-dots-xs nav-inside nav-inside-plus nav-dark nav-md nav-font-size-md show-nav-hover mb-0" data-plugin-options="{'autoplayTimeout': 7000}" data-dynamic-height="['600px','600px','600px','550px','500px']" style="height: 600px;">
		<div class="owl-stage-outer">
			<div class="owl-stage">

				@foreach ($grosplans as $grosplan)
				<!-- Carousel Slide 1 -->
				<div class="owl-item position-relative overlay overlay-color-primary overlay-show overlay-op-1" style="background-image: url({{ env('APP_URL') . $grosplan->vignette }}); background-size: cover; background-position: center; height: 600px;">
					<div class="container position-relative z-index-3 h-100">
						<div class="d-flex flex-column align-items-center justify-content-center h-100">
							<!--<h3 class="position-relative text-color-light text-5 line-height-5 font-weight-medium px-4 mb-2 appear-animation" data-appear-animation="fadeInDownShorter" data-plugin-options="{'minWindowWidth': 0}">
								<span class="position-absolute right-100pct top-50pct transform3dy-n50 opacity-3">
									<img src="{{ env('APP_URL') }}site/img/slides/slide-title-border.png" class="w-auto appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="250" data-plugin-options="{'minWindowWidth': 0}" alt="" />
								</span>
								AVEZ-VOUS BESOIN D'UNE FORMATION</span></span>
								<span class="position-absolute left-100pct top-50pct transform3dy-n50 opacity-3">
									<img src="{{ env('APP_URL') }}site/img/slides/slide-title-border.png" class="w-auto appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="250" data-plugin-options="{'minWindowWidth': 0}" alt="" />
								</span>
							</h3>-->
							<h1 class="text-color-light font-weight-extra-bold text-13 mb-3 appear-animation" data-appear-animation="blurIn" data-appear-animation-delay="500" data-plugin-options="{'minWindowWidth': 0}">{{ $grosplan->titre }}</h1>
							<p class="text-4-5 text-color-light font-weight-light mb-0" data-plugin-animated-letters data-plugin-options="{'startDelay': 1000, 'minWindowWidth': 0}">{{ $grosplan->resume }}</p>
							
										

							@if ($grosplan->url != '')
							<a href="{{ $grosplan->url }}" class="btn btn-primary btn-modern font-weight-bold text-3 py-3 btn-px-5 appear-animation" style="margin-top:20px;" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1800" data-plugin-options="{'minWindowWidth': 0}">{{ __('voirplus') }} <i class="fas fa-arrow-right ms-2"></i></a>
						@elseif ($grosplan->table_id > 0)
							@php
								$tabletype = DB::select(
									'select * from tabletypes where id = ' .
										$grosplan->tabletype_id .
										'',
								);
								$tables = $tabletype[0]->table;
								$table_ = substr($tables, 0, -1);
								$table_ = str_replace('pagelibre', 'page', $table_);
								$tabletitre = 'titre';
								$table_titre = ucfirst($tabletype[0]->titre);

								//$table_s = DB::select('select * from '.$tables.' where id = '.$grosplan->table_id.'');
								//echo $table_s[0]->titre;

							@endphp

							<a href="{{ env('APP_URL') }}{{ $table_ }}/{{ $grosplan->table_id }}-{{ getEnleveAccent($grosplan->titre) }}.html" class="btn btn-primary btn-modern font-weight-bold text-3 py-3 btn-px-5 appear-animation" style="margin-top:20px;" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1800" data-plugin-options="{'minWindowWidth': 0}">{{ __('voirplus') }} <i class="fas fa-arrow-right ms-2"></i></a>
						@elseif ($grosplan->tabletype_id > 0)
							@php
								$tabletype = DB::select(
									'select * from tabletypes where id = ' .
										$grosplan->tabletype_id .
										'',
								);
								$tables = $tabletype[0]->table;
								$table_ = substr($tables, 0, -1);
								$table_ = str_replace('pagelibre', 'page', $table_);
								$tabletitre = 'titre';
								$table_titre = ucfirst($tabletype[0]->titre);

								//$table_s = DB::select('select * from '.$tables.' where id = '.$grosplan->table_id.'');
								//echo $table_s[0]->titre;

							@endphp

							<a href="{{ env('APP_URL') }}{{ $table_ }}s.html" class="btn btn-primary btn-modern font-weight-bold text-3 py-3 btn-px-5 appear-animation" style="margin-top:20px;" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1800" data-plugin-options="{'minWindowWidth': 0}">{{ __('voirplus') }} <i class="fas fa-arrow-right ms-2"></i></a>
						@endif

						</div>
						
					</div>
				</div>
				@endforeach

				
			</div>
		</div>
		<div class="owl-dots mb-5">
			@php
				$i = 0;
			@endphp
				@foreach ($grosplans as $grosplan)
			@php
				$i++;
			@endphp
			@if ($i == 1)
					<button role="button" class="owl-dot active"><span></span></button>
			@else
					<button role="button" class="owl-dot"><span></span></button>
			@endif
				@endforeach
		</div>
	</div>
	@endif

	<div class="home-intro" id="home-intro" style="margin-bottom:0 !important;">
		<div class="container">

			<div class="row align-items-center">
				<div class="col-lg-8">
					<p>
						{{ $pagelibre->titre }}
							<span>{{ $pagelibre->resume }}</span>
						</p>
				</div>
				<div class="col-lg-4">
					<div class="get-started text-start text-lg-end">
						<a href="{{ env('APP_URL') }}prestations.html" class="btn btn-primary btn-lg text-3 font-weight-semibold px-4 py-3">{{ __('savoirplus2') }}</a>
						<div class="learn-more">ou <a href="{{ env('APP_URL') }}page/{{ $pagelibre->id }}-{{ getEnleveAccent($pagelibre->titre) }}.html">{{ __('savoirplus') }}</a></div>
					</div>
				</div>
			</div>

		</div>
	</div>

	

	@if (isset($grosplan2->vignette) && $grosplan2->vignette != '')
	<div class=""><!-- container -->
		<div class=""><!-- row -->
				<div class=""><!-- col -->
				<img src="{{ env('APP_URL') . $grosplan2->vignette }}" class="img-fluid" alt="{{ $grosplan2->titre }}" />
				</div>
		</div>	
	</div>
	@endif


</div>

	<section class="section bg-color-light border-0 m-0">
		<div class="container">
			<div class="row text-center text-md-start">
				@if (isset($pagelibre2->vignette) && $pagelibre2->vignette != '')
				<div class="col-md-6 mb-6 mb-md-0 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="200">
					<div class="row align-items-center justify-content-center justify-content-md-start">
						<div class="col-4">
							<img class="img-fluid mb-4 mb-lg-0" src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $pagelibre2->vignette }}&w=586&h=586&zc=1&q=100" alt="{{ $pagelibre2->titre }}">
						</div>
						<div class="col-lg-8">
							<h2 class="font-weight-bold text-5 line-height-5 mb-1"><a href="{{ env('APP_URL') }}page/{{ $pagelibre2->id }}-{{ getEnleveAccent($pagelibre2->titre) }}.html">{{ $pagelibre2->titre }}</a></h2>
							<p class="mb-0">{{ $pagelibre2->resume }}</p>
						</div>
					</div>
				</div>
				@endif
				@if (isset($pagelibre3->vignette) && $pagelibre3->vignette != '')
				<div class="col-md-6 mb-6 mb-md-0 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="200">
					<div class="row align-items-center justify-content-center justify-content-md-start">
						<div class="col-4">
							<img class="img-fluid mb-4 mb-lg-0" src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $pagelibre3->vignette }}&w=586&h=586&zc=1&q=100" alt="{{ $pagelibre3->titre }}">
						</div>
						<div class="col-lg-8">
							<h2 class="font-weight-bold text-5 line-height-5 mb-1"><a href="{{ env('APP_URL') }}page/{{ $pagelibre3->id }}-{{ getEnleveAccent($pagelibre3->titre) }}.html">{{ $pagelibre3->titre }}</a></h2>
							<p class="mb-0">{{ $pagelibre3->resume }}</p>
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
	</section>								




	@if (isset($pagelibre4->vignette) && $pagelibre4->vignette != '')
	<section class="section section-secondary border-0 py-0 m-0 appear-animation" data-appear-animation="fadeIn">
		<div class="container">
			<div class="row align-items-center justify-content-center justify-content-lg-between pb-5 pb-lg-0">
				<div class="col-lg-5 order-2 order-lg-1 pt-4 pt-lg-0 pb-5 pb-lg-0 mt-5 mt-lg-0 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200">
					<h2 class="font-weight-bold text-color-light text-7 mb-2">{{ $pagelibre4->titre }}</h2>
					<p class="lead font-weight-light text-color-light text-4">{{ $pagelibre4->resume }}</p>
					<a href="{{ env('APP_URL') }}page/{{ $pagelibre4->id }}-{{ getEnleveAccent($pagelibre4->titre) }}.html" class="btn btn-primary btn-px-5 btn-py-2 text-2">{{ __('lireplus') }}</a>
				</div>
				<div class="col-9 offset-lg-1 col-lg-5 order-1 order-lg-2 scale-2">
					<img class="img-fluid box-shadow-3 my-2 border-radius" src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $pagelibre4->vignette }}&w=586&h=624&zc=1&q=100" alt="{{ $pagelibre4->titre }}">
				</div>
			</div>
		</div>
	</section>
	@endif



			@if (count($chiffres) > 0)
	<section class="section section-primary border-top-0 mb-0">
		<div class="container">
	
			<h4 class="mb-3">{{ __('chiffre_last') }} </h4>
			<div class="row counters counters-sm counters-text-light">
				@foreach ($chiffres as $chiffre)
				<div class="col-sm-6 col-lg-3 mb-5 mb-lg-0">
					<div class="counter">
						<strong data-to="{{ $chiffre->chiffre }}" data-append="+">0</strong>
						<label class="opacity-5 text-4 mt-1">{{ $chiffre->titre }}</label>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>
			@endif
	
	

	

			@if (isset($galeriephoto->vignette) && $galeriephoto->vignette != '')
			<article class="post post-large blog-single-post border-0 m-0 p-0" style="margin: 50px !important;">
				@if ($galeriephoto->vignette != '')
					<div class="post-image ms-0">
					<iframe style="width:100%;" height="399" src="https://www.youtube.com/embed/{{ $galeriephoto->vignette }}?rel=0" frameborder="0" allowfullscreen></iframe>										
					</div>
				@endif

					<div class="post-content ms-0">
						<h4 class="font-weight-semi-bold" style="text-align: center;"><a href="#">{{ $galeriephoto->titre }}</a></h4>
					</div>
			</article>
			@endif
		
		





	
			@if (count($actualites) > 0)
	<section>

	<div class="container py-4">

		<div class="row">
			<div class="col">
				<div class="blog-posts">
					<h4 class="mb-3">{{ __('actualite_last') }}</h4>
					<div class="row">

						@foreach ($actualites as $actualite)
						<div class="col-md-4 col-lg-3">
							<article class="post post-medium border-0 pb-0 mb-5">
								@if ($actualite->vignette != '')
								<div class="post-image">
									<a href="{{ env('APP_URL') }}actualite/{{ $actualite->id }}-{{ getEnleveAccent($actualite->titre) }}.html">
										<img src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $actualite->vignette }}&w=550&h=412&zc=1&q=100" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="{{ $actualite->titre }}" />
									</a>
								</div>
								@endif

								<div class="post-content">

									<h2 class="font-weight-semibold text-5 line-height-6 mt-3 mb-2"><a href="{{ env('APP_URL') }}actualite/{{ $actualite->id }}-{{ getEnleveAccent($actualite->titre) }}.html">
										@php /*		
										$nbretitre = strlen($actualite->titre);
								if($nbretitre < 65){
									$actualite_titre = $actualite->titre;
									$nbreresume = 120 + (65 - $nbretitre);
								}else{
									$actualite_titre =  substr($actualite->titre, 0, 65)."...";
									$nbreresume = 120;
								}*/
								@endphp
										{{ $actualite->titre }}</a></h2>
									<p>
										@php /*		
									if(strlen($actualite->resume) < $nbreresume){
										$actualite_resume = $actualite->resume;
									}else{
										$actualite_resume = substr($actualite->resume, 0, $nbreresume)."...";
									}*/
									@endphp
											{{ $actualite->resume }}</p>

									<div class="post-meta">
										<span><i class="far fa-calenda"></i> {{ \Carbon\Carbon::parse($actualite->date)->translatedFormat('d F Y') }} </span>
                                        @php 
                                        $commentaires = DB::table('commentaires')->where('etat', 1)->where('actualite_id', $actualite->id)->orderBy('id', 'desc')->get();
                                        @endphp
										<span><i class="far fa-comments"></i> <a href="#">{{ count($commentaires) }} {{ __('commentaire_last2') }}</a></span>
										<span class="d-block mt-2"><a href="{{ env('APP_URL') }}actualite/{{ $actualite->id }}-{{ getEnleveAccent($actualite->titre) }}.html" class="btn btn-xs btn-light text-1 text-uppercase">{{ __('liresuite') }}</a></span>
									</div>

								</div>
							</article>
						</div>
						@endforeach

						

					</div>


				</div>
			</div>

		</div>

	</div>				
	</section>
	@endif

	
	
			
	
	
	
	
	
	
	
	@if (count($partenaires) > 0)
				<section class="section section-height-4 section-with-shape-divider bg-color-grey border-0 pb-5 m-0">
					<div class="shape-divider" style="height: 123px;">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1920 123" preserveAspectRatio="xMinYMin">
							<polygon fill="#F4F4F4" points="0,90 221,60 563,88 931,35 1408,93 1920,41 1920,-1 0,-1 "/>
							<polygon fill="#FFFFFF" points="0,75 219,44 563,72 930,19 1408,77 1920,25 1920,-1 0,-1 "/>
						</svg>
					</div>
					<div class="container">

						<div class="row row-gutter-sm justify-content-center appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">
							<div class="container ">
						<div class="row justify-content-center">
							<div class="col-lg-11 col-xl-10 text-center">
								<h4 class="mb-3">{{ __('partenaire_last2') }}</h4>
							
							</div>
						</div>
						<div class="col appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250">
							<div class="owl-carousel owl-theme custom-carousel-vertical-center-items custom-dots-style-1" data-plugin-options="{'responsive': {'0': {'items': 1}, '476': {'items': 3}, '768': {'items': 3}, '992': {'items': 5}, '1200': {'items': 5}, '1600': {'items': 7}}, 'autoplay': false, 'autoplayTimeout': 3000, 'dots': true}">
							@foreach ($partenaires as $partenaire)
							@if ($partenaire->vignette != '')
								<div class="text-center" style="margin:5px;">
									<a href="{{ env('APP_URL') }}partenaire/{{ $partenaire->id }}-{{ getEnleveAccent($partenaire->titre) }}.html">
									<img class="d-inline-block" src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $partenaire->vignette }}&w=220&h=200&zc=1&q=100" alt="{{ $partenaire->titre }}"  />
									</a>
								</div>
								@endif
								@endforeach
								
							</div>
						</div>
					</div>

					</div>
					</div>
				</section>
				@endif				
	
	
				@if (count($temoignages) > 0)
				<section class="video section section-height-3 section-text-light section-video section-center overlay overlay-show overlay-op-7 mt-0" data-video-path="{{ env('APP_URL') }}site/video/dark" data-plugin-video-background data-plugin-options="{'posterType': 'jpg', 'position': '50% 50%', 'overlay': true}">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								
							

						<div class="row">						
							<div class="col">
								<div class="owl-carousel show-nav-title custom-dots-style-1 custom-dots-position custom-xs-arrows-style-2 mb-0" data-plugin-options="{'items': 1, 'autoHeight': true, 'loop': false, 'nav': false, 'dots': true}">
								@foreach ($temoignages as $temoignage)
									<div class="row">
									@if ($temoignage->vignette != '')
										<div class="col-8 col-sm-4 col-lg-2 text-center pt-5">
											<img src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $temoignage->vignette }}&w=120&h=120&zc=1&q=100" alt class="img-fluid rounded-circle" />
										</div>
										@endif
										<div class="col-12 col-sm-12 col-lg-10">
											<div class="testimonial custom-testimonial-style-1 testimonial-with-quotes mb-0">
												<blockquote class="pb-2" style="background:transparent !important;">
													<p>{{ $temoignage->resume }}</p>
												</blockquote>
												<div class="testimonial-author float-start">
													<p>{{ $temoignage->titre }}<br />{{ \Carbon\Carbon::parse($temoignage->date)->translatedFormat('d F Y') }}</p>
												</div>
											</div>
										</div>
									</div>
									
									@endforeach
								</div>
							</div>
						</div>
						
					
							</div>
						</div>
					</div>
				</section>  
				@endif


				

	

</div>
				

@endsection

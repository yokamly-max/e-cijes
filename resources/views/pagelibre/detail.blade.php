@extends('layouts.site2')

@section('title')
    {{ $pagelibre->titre }}
@endsection

@section('entite')
    {{ __('pagelibre_page') }}
@endsection


@section('contenu')


        <!-- Start Breadcrumb Section -->
        <!-- ========================================== -->
        <section class="breadcrumb-section">
            <div class="bg bg-image" style="background-image: url('{{ env('APP_URL') . $slider->vignette }}')"></div>
            <div class="container">
                <div class="title-outer">
                    <div class="page-title">
                        <h2 class="title">{{ $pagelibre->titre }}</h2>
                        <ul class="page-breadcrumb">
                            <li><a href="{{ route('index.index') }}">{{ __('accueil') }}</a></li>
                            <li>{{ __('pagelibre_page') }}</li>
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
                        <div class="blog-details-left">
                            <div class="blog-list-card style-2">
								@if ($pagelibre->vignette != '')
                                <div class="image overlay-anim1">
                                    <a href="#">
										<img src="{{ env('APP_URL') . $pagelibre->vignette }}" alt="{{ $pagelibre->titre }}">
									</a>
                                </div>
								@endif
                                <div class="card-content">
                                    <h3 class="title"><a href="#">{{ $pagelibre->titre }}</a></h3>
                                    <div class="pt-20 pb-25"><div class="border dark"></div></div>
                                    <p class="mb-25">{{ $pagelibre->resume }}</p>
                                    <div>{!! $pagelibre->description !!}</div>
                                    
                                </div>
                            </div>
                            

							

                @if (count($pagelibres) > 0)

                @php
                    $i = 0;
                @endphp
                @foreach ($pagelibres as $pagelibre)
                    @php
                        $i++;
                    @endphp
								 
                                @if ($i == 1) 
                                @else 
                                @endif
								
                            <div class="blog-list-card style-2">
								@if ($pagelibre->vignette != '')
                                <div class="image overlay-anim1">
                                    <a href="#">
										<img src="{{ env('APP_URL') . $pagelibre->vignette }}" alt="{{ $pagelibre->titre }}">
									</a>
                                </div>
								@endif
                                <div class="card-content">
                                    <h3 class="title"><a href="#">{{ $pagelibre->titre }}</a></h3>
                                    <div class="pt-20 pb-25"><div class="border dark"></div></div>
                                    <p class="mb-25">{{ $pagelibre->resume }}</p>
                                    <div>{!! $pagelibre->description !!}</div>
                                    
                                </div>
                            </div>
							

                @endforeach
						
                @endif

                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4">
						@include('layouts.sidebar')
                        
                    </div>

                </div>
            </div>
        </section>


        
            

@endsection

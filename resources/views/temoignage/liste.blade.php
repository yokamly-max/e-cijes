@extends('layouts.site2')

@section('title')
    {{ __('temoignage_last') }}
@endsection

@section('entite')
    {{ __('temoignage_page') }}
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
                        <h2 class="title">{{ __('temoignage_last') }}</h2>
                        <ul class="page-breadcrumb">
                            <li><a href="{{ route('index.index') }}">{{ __('accueil') }}</a></li>
                            <li>{{ __('temoignage_page') }}</li>
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
<!--==============================
        Testimonial Section Three
        ==============================-->
        <section class="testimonial-section style-3">
            <div class="container">
                
                        @if (count($temoignages) > 0)
                <div class="row gy-30" id="testimonials-container">
                @php
                    $i = 0;
                @endphp
                @foreach ($temoignages as $temoignage)
                @php
                    $i++;
                @endphp
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="testimonial-card style-3">
                            <div class="content-inner">
                                <div class="card-header">
                                    @if ($temoignage->vignette != '')
                                    <img src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $temoignage->vignette }}&w=70&h=70&zc=1&q=100" alt="{{ $temoignage->nom }}" class="user-image">
                                    @endif
                                    <div class="user-details">
                                        <h5 class="user-name">{{ $temoignage->nom }}</h5>
                                        <p class="user-title">{{ $temoignage->profil }}</p>
                                    </div>
                                </div>
                                <p class="user-review">
                                    {{ $temoignage->commentaire }}
                                </p>
                            </div>
                            <div class="rating-inner">
                                <span class="stars">
                                    <i class="fa fa-calender"></i> 
                                </span>
                                <span class="rating-text">{{ \Carbon\Carbon::parse($temoignage->created_at)->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    @if ($i == 2)
                    
                    @php
                        $i = 0;
                    @endphp
                    @endif


                @endforeach

                </div>


                    {{ $temoignages->links() }}
                 

                @endif

            </div>
        </section>

                    </div>

                    <div class="col-xl-4 col-lg-6">
						@include('layouts.sidebar')
                        
                    </div>

                </div>
            </div>
        </section>


        
            

@endsection

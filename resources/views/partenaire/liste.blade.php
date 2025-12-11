@extends('layouts.site2')

@section('title')
    {{ __('partenaire_last') }}
@endsection

@section('entite')
    {{ __('partenaire_page') }}
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
                        <h2 class="title">{{ __('partenaire_last') }}</h2>
                        <ul class="page-breadcrumb">
                            <li><a href="{{ route('index.index') }}">{{ __('accueil') }}</a></li>
                            <li>{{ __('partenaire_page') }}</li>
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
        Feature Section Two
        ==============================-->
        <section class="feature-section style-2">
            <div class="container">
        @if (count($partenaires) > 0)

        @php
                    $i = 0;
                    $partenairetype = 0;
                @endphp


                @foreach ($partenaires as $partenaire)

                    @if ($partenaire->vignette != '')
                    @if ($partenairetype != $partenaire->partenairetype_id)
                    @if ($partenairetype != 0)
                    </div>
                    @endif
                <div class="title-area three text-center">
                    <div class="sub-title"><span><i class="asterisk"></i></span>@if ($partenaire->partenairetype_id > 0)
                            {{ $partenaire->partenairetype->titre }}
                        @endif</div>
                </div>
                <div class="row gy-30">
                        @php
                    $partenairetype = $partenaire->partenairetype_id;
                    $i = 0;
                @endphp
                    @endif
                @php
                    $i++;
                @endphp

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="feature-single-box">
                            <a href="{{ env('APP_URL') }}partenaire/{{ $partenaire->id }}-{{ getEnleveAccent($partenaire->titre) }}.html">
                            <img class="img-fluid" src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $partenaire->vignette }}&w=390&h=200&zc=1&q=100" alt="{{ $partenaire->titre }}">
                            <h4 class="title">{{ $partenaire->titre }}</h4>
                            <p class="text">{{ $partenaire->contact }}</p>
                            </a>
                        </div>
                    </div>

                @endif

                @endforeach

            </div>
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

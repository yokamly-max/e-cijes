@extends('layouts.site2')

@section('title')
    {{ __('chiffre_last') }}
@endsection

@section('entite')
    {{ __('chiffre_page') }}
@endsection


@section('contenu')


        <!-- Start Breadcrumb Section -->
        <!-- ========================================== -->
        <section class="breadcrumb-section">
            <div class="bg bg-image" style="background-image: url('{{ env('APP_URL') . $slider->vignette }}')"></div>
            <div class="container">
                <div class="title-outer">
                    <div class="page-title">
                        <h2 class="title">{{ __('chiffre_last') }}</h2>
                        <ul class="page-breadcrumb">
                            <li><a href="{{ route('index.index') }}">{{ __('accueil') }}</a></li>
                            <li>{{ __('chiffre_page') }}</li>
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
        Counter Section
        ==============================-->
        
            @if (count($chiffres) > 0)

        <section class="counter-section py-30">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-12">
                        <div class="achievement-stats">

                @php
                    $i = 0;
                @endphp
                @foreach ($chiffres as $chiffre)
                @php
                    $i++;
                @endphp

                            <div class="stat-item">
                                <div class="count-box"><span class="count-number odometer" data-count="{{ $chiffre->chiffre }}"></span>+</div>
                                <p class="text">{{ $chiffre->titre }}</p>
                            </div>


                    @if ($i == 3)

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="counter-section py-30">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-12">
                        <div class="achievement-stats">

                    @php
                        $i = 0;
                    @endphp
                    @endif

                @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </section>
                
                {{ $chiffres->links() }}

        @endif
								
                    </div>

                    <div class="col-xl-4 col-lg-6">
						@include('layouts.sidebar')
                        
                    </div>

                </div>
            </div>
        </section>


        
            

@endsection

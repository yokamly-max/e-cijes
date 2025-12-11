@extends('layouts.site2')

@section('title')
    {{ __('actualite_last') }}
@endsection

@section('entite')
    {{ __('actualite_page') }}
@endsection


@section('contenu')

        <!-- Start Breadcrumb Section -->
        <!-- ========================================== -->
        <section class="breadcrumb-section">
            <div class="bg bg-image" style="background-image: url('{{ env('APP_URL') . $slider->vignette }}')"></div>
            <div class="container">
                <div class="title-outer">
                    <div class="page-title">
                        <h2 class="title">{{ __('actualite_last') }}</h2>
                        <ul class="page-breadcrumb">
                            <li><a href="{{ route('index.index') }}">{{ __('accueil') }}</a></li>
                            <li>{{ __('actualite_page') }}</li>
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
                   @if (count($actualites) > 0)    
 
<div class="row gx-25 gy-25">
    @foreach ($actualites as $actualite)
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <article class="blog-single-box">
                            <div class="inner-box">
                                @if ($actualite->vignette != '')
                                <div class="blog-image">
                                    <img src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $actualite->vignette }}&w=384&h=280&zc=1&q=100" alt="{{ $actualite->titre }}">
                                    <div class="category-tag">
                                        @if ($actualite->actualitetype_id > 0)
                                            {{ $actualite->actualitetype->titre ?? '' }}
                                        @endif
                                    </div>
                                </div>
                                @endif
                                <div class="blog-content">
                                    <div class="author">
                                        <span class="name">{{ \Carbon\Carbon::parse($actualite->dateactualite)->translatedFormat('d F Y') }} - 
                                        
                                        @php 
                                        $commentaires = DB::table('commentaires')->where('etat', 1)->where('actualite_id', $actualite->id)->orderBy('id', 'desc')->get();
                                        @endphp
                                        <span><i class="far fa-comments"></i> <a href="#">{{ count($commentaires) }} {{ __('commentaire_last2') }}</a></span> </span>
                                    </div>
                                    <div class="pt-25 pb-20"><div class="border dark"></div></div>
                                    <h4 class="title mb-10"><a href="{{ env('APP_URL') }}actualite/{{ $actualite->id }}-{{ getEnleveAccent($actualite->titre) }}.html">{{ $actualite->titre }}</a></h4>
                                    <p>{{ $actualite->resume }}</p>
                                    <a href="{{ env('APP_URL') }}actualite/{{ $actualite->id }}-{{ getEnleveAccent($actualite->titre) }}.html" class="continue-reading">{{ __('liresuite') }}</a>
                                </div>
                            </div>
                        </article>                        
                    </div>
                    @endforeach
                    
                </div>

                
                {{ $actualites->links() }}
                <!--<ul class="pagination-menu mt-60 vxs-mt-40">
                    <li><a href="#" class="current">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#"><span class="icon fa-light fa-arrow-right-long"></span></a></li>
                </ul>-->
@endif
                    </div>

                    <div class="col-xl-4 col-lg-6">
						@include('layouts.sidebar')
                        
                    </div>

                </div>
            </div>
        </section>


        
            

@endsection

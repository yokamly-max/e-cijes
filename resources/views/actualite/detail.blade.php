@extends('layouts.site2')

@section('title')
    {{ $actualite->titre }}
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
                        <h2 class="title">{{ $actualite->titre }}</h2>
                        <ul class="page-breadcrumb">
                            <li><a href="{{ route('index.index') }}">{{ __('accueil') }}</a></li>
                            <li><a href="{{ route('actualite.liste') }}">{{ __('actualite_page') }}</a></li>
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
								@if ($actualite->vignette != '')
                                <div class="image overlay-anim1">
                                    <a href="#"><img src="{{ env('APP_URL') . $actualite->vignette }}" alt="{{ $actualite->titre }}"></a>
                                </div>
								@endif
                                <div class="card-content">
									@if ($actualite->actualitetype_id > 0)
                                    <span class="category">{{ $actualite->actualitetype->titre }}</span>
									@endif
                                    <h3 class="title"><a href="#">{{ $actualite->titre }}</a></h3>
                                    <div class="author-info">
                                        <div class="author">
                                            <span class="name">
												@php 
                                        $commentaires = DB::table('commentaires')->where('etat', 1)->where('actualite_id', $actualite->id)->orderBy('id', 'desc')->get();
                                        @endphp
                                        <span><i class="far fa-comments"></i> <a href="#">{{ count($commentaires) }} {{ __('commentaire_last2') }}</a></span></span>
                                        </div>
                                        <span class="date"><i class="icon-calender"></i> {{ \Carbon\Carbon::parse($actualite->dateactualite)->translatedFormat('d F Y') }}</span>
                                    </div>
                                    <div class="pt-20 pb-25"><div class="border dark"></div></div>
                                    <div class="blogs-quote">
                                        <p>{{ $actualite->resume }}</p>
                                    </div>
                                    <div>{!! $actualite->description !!}</div>
                                    
                                </div>
                            </div>

                            <!-- Comment One -->
                            <div class="comment-one">
							@if (count($commentaires) > 0)
                                <h3 class="comment-one__title">{{ __('commentaire_last') }} {{ count($commentaires) }}</h3>
								@foreach ($commentaires as $commentaire)
                                <div class="comment-one__single">
                                    <div class="comment-one__image"> <img src="{{ env('APP_URL') }}avatar.jpg" alt="{{ $commentaire->nom }}"> </div>
                                    <div class="comment-one__content">
                                        <div class="title"><h5>{{ $commentaire->nom }}</h5><span>{{ \Carbon\Carbon::parse($commentaire->created_at)->translatedFormat('d F Y') }}</span></div>
                                        <p>{{ $commentaire->message }}</p>
                                    </div>
                                </div>
								@endforeach
							@endif
                                <div class="comment-form">
                                    <h3 class="comment-one__title">{{ __('commentaire_ajouter') }}</h3>
                                    <form class="" action="{{ route('commentaire.store') }}" method="post">
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
                            <input type="hidden" name="actualite_id" id="actualite_id" value="{{ $actualite->id }}">

                                        <div class="row">
                                            <div class="mb-20">
												<textarea placeholder="{{ __('commentaire_resume2') }}" rows="6" class="form-control" name="resume" id="resume"></textarea>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-20">
                                                    <input type="text" value="{{ old('nom') }}" placeholder="{{ __('commentaire_nom2') }} *" class="form-control" name="nom" id="nom" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-20">
													<input type="email" value="{{ old('email') }}" placeholder="{{ __('commentaire_email2') }} *" data-msg-email="{{ __('commentaire_email3') }}" class="form-control" name="email" id="email" required>
                                                </div>
                                            </div>
                                            <div class="mb-25">
												<input type="text" value="{{ old('siteweb') }}" placeholder="{{ __('commentaire_siteweb2') }}" class="form-control" name="siteweb" id="siteweb">
                                            </div>
                                        </div>
                                        <div class="mb-0">
											<input type="submit" value="{{ __('commentaire_ajouter2') }}" class="theme-btn bg-dark mt-25">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6">
						@include('layouts.sidebar')
                        
                    </div>

                </div>
            </div>
        </section>


@endsection

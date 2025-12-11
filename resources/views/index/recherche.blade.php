@extends('layouts.site2')

@section('title')
	{{ __('site_name') }}
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
                        <h2 class="title">{{ __('recherche_last') }} : {{ $_GET['recherche'] ?? '' }}</h2>
                        <ul class="page-breadcrumb">
                            <li><a href="{{ route('index.index') }}">{{ __('accueil') }}</a></li>
                            <li>{{ __('recherche_page') }}</li>
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

									<table class="table table-striped table-bordered table-hover">
										<tbody>
                        @if (count($pagelibres) > 0)
											<tr>
												<th colspan="2">
                                                {{ __('pagelibre_page') }}
                                                </th>
											</tr>
                    @foreach ($pagelibres as $pagelibre)
											<tr>
												<td>
                                                {{ \Carbon\Carbon::parse($pagelibre->created_at)->translatedFormat('d M Y') }}
												</td>
												<td>
                                                {{ $pagelibre->titre }}<br />
                                                {{ $pagelibre->resume }}
                                                <a href="{{ env('APP_URL') }}pagelibre/{{ $pagelibre->id }}-{{ getEnleveAccent($pagelibre->titre) }}.html">
                                    {{ __('liresuite') }}
                                </a>
												</td>
											</tr>
                @endforeach
											<tr>
												<th colspan="2">
                                                <br style="border: 1px border;" />
                                                </th>
											</tr>
        @endif



										
                        @if (count($services) > 0)
											<tr>
												<th colspan="2">
                                                {{ __('service_page') }}
                                                </th>
											</tr>
                    @foreach ($services as $service)
											<tr>
												<td style="width: 20%">
                                                {{ \Carbon\Carbon::parse($service->created_at)->translatedFormat('d M Y') }}
												</td>
												<td>
                                                {{ $service->titre }}<br />
                                                {{ $service->resume }}
                                <a href="{{ env('APP_URL') }}service/{{ $service->id }}-{{ getEnleveAccent($service->titre) }}.html">
                                    {{ __('liresuite') }}
                                </a>
												</td>
											</tr>
                @endforeach
											<tr>
												<th colspan="2">
                                                <br style="border: 1px solid;" />
                                                </th>
											</tr>
        @endif






        


										
                        @if (count($chiffres) > 0)
											<tr>
												<th colspan="2">
                                                {{ __('chiffre_page') }}
                                                </th>
											</tr>
                    @foreach ($chiffres as $chiffre)
											<tr>
												<td style="width: 20%">
                                                {{ \Carbon\Carbon::parse($chiffre->created_at)->translatedFormat('d M Y') }}
												</td>
												<td>
                                                {{ $chiffre->chiffre }} {{ $chiffre->titre }}
												</td>
											</tr>
                @endforeach
											<tr>
												<th colspan="2">
                                                <br style="border: 1px solid;" />
                                                </th>
											</tr>
        @endif






        


										
                        @if (count($temoignages) > 0)
											<tr>
												<th colspan="2">
                                                {{ __('temoignage_page') }}
                                                </th>
											</tr>
                    @foreach ($temoignages as $temoignage)
											<tr>
												<td style="width: 20%">
                                                {{ \Carbon\Carbon::parse($temoignage->created_at)->translatedFormat('d M Y') }}
												</td>
												<td>
                                                {{ $temoignage->nom }} - 
                                                {{ $temoignage->profil }}<br />
                                                {!! $temoignage->commentaire !!}
												</td>
											</tr>
                @endforeach
											<tr>
												<th colspan="2">
                                                <br style="border: 1px solid;" />
                                                </th>
											</tr>
        @endif






        


										
                        @if (count($partenaires) > 0)
											<tr>
												<th colspan="2">
                                                {{ __('partenaire_page') }}
                                                </th>
											</tr>
                    @foreach ($partenaires as $partenaire)
											<tr>
												<td style="width: 20%">
                                                {{ \Carbon\Carbon::parse($partenaire->created_at)->translatedFormat('d M Y') }}
												</td>
												<td>
                                                {{ $partenaire->titre }} 
                                <a href="{{ env('APP_URL') }}partenaire/{{ $partenaire->id }}-{{ getEnleveAccent($partenaire->titre) }}.html">
                                    {{ __('liresuite') }}
                                </a>
												</td>
											</tr>
                @endforeach
											<tr>
												<th colspan="2">
                                                <br style="border: 1px solid;" />
                                                </th>
											</tr>
        @endif






        


										
                        @if (count($actualites) > 0)
											<tr>
												<th colspan="2">
                                                {{ __('actualite_page') }}
                                                </th>
											</tr>
                    @foreach ($actualites as $actualite)
											<tr>
												<td style="width: 20%">
                                                {{ \Carbon\Carbon::parse($actualite->created_at)->translatedFormat('d M Y') }}
												</td>
												<td>
                                                {{ $actualite->titre }}<br />
                                                {{ $actualite->resume }}
                                <a href="{{ env('APP_URL') }}actualite/{{ $actualite->id }}-{{ getEnleveAccent($actualite->titre) }}.html">
                                    {{ __('liresuite') }}
                                </a>
												</td>
											</tr>
                @endforeach
											<tr>
												<th colspan="2">
                                                <br style="border: 1px solid;" />
                                                </th>
											</tr>
        @endif






        


										
                        @if (count($faqs) > 0)
											<tr>
												<th colspan="2">
                                                {{ __('faq_page') }}
                                                </th>
											</tr>
                    @foreach ($faqs as $faq)
											<tr>
												<td style="width: 20%">
                                                {{ \Carbon\Carbon::parse($faq->created_at)->translatedFormat('d M Y') }}
												</td>
												<td>
                                                {{ $faq->question }}<br />
                                                {!! $faq->reponse !!}
												</td>
											</tr>
                @endforeach
											<tr>
												<th colspan="2">
                                                <br style="border: 1px solid;" />
                                                </th>
											</tr>
        @endif






        
										</tbody>
									</table>





                    </div>

                    <div class="col-xl-4 col-lg-6">
						@include('layouts.sidebar')
                        
                    </div>

                </div>
            </div>
        </section>


        
            

@endsection

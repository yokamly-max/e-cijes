@extends('layouts.site2')

@section('title')
    {{ __('document_last') }}
@endsection

@section('entite')
    {{ __('document_page') }}
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
                        <h2 class="title">
                    @if (isset($documenttype->id) && $documenttype->id > 0)
                        {{ $documenttype->titre }}
                    @else
                        {{ __('document_last') }}
                    @endif
                        </h2>
                        <ul class="page-breadcrumb">
                            <li><a href="{{ route('index.index') }}">{{ __('accueil') }}</a></li>
                            <li>{{ __('document_page') }}</li>
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

            @if (count($documents) > 0)

            <div class="row">
								<div class="col pb-3">


									<table class="table table-striped table-bordered table-hover">
										<tbody>
                                        @php
                    $i = 0;
                    $documenttype = 0;
                @endphp

                @foreach ($documents as $document)
                @php
                    $i++;
                @endphp

                
                @if ($documenttype != $document->documenttype_id)
                    @if ($documenttype != 0)
                    
                    @endif
											<tr>
												<th colspan="4">
                                                @if ($document->documenttype_id > 0)
                                            {{ $document->documenttype->titre }}
                                        @endif
                                    </th>
											</tr>

                                            @php
                    $documenttype = $document->documenttype_id;
                    $i = 0;
                @endphp
                    @endif
                @php
                    $i++;
                @endphp

											<tr>
												<td>
                                                {{ \Carbon\Carbon::parse($document->datedocument)->translatedFormat('d') }} {{ \Carbon\Carbon::parse($document->datedocument)->translatedFormat('F') }} {{ \Carbon\Carbon::parse($document->datedocument)->translatedFormat('Y') }}
												</td>
												<td>
                                                {{ $document->titre }}
												</td>
												<td>
                                                @if ($document->documenttype_id > 0)
                                            {{ $document->documenttype->titre }}
                                        @endif
												</td>
												<td>
                                                @if ($document->fichier != '')
                                                <a href="{{ env('APP_URL') . $document->fichier }}" target="_blank" class="btn btn-xs btn-light text-1 text-uppercase">{{ __('telecharger') }}</a>
                                                @endif
												</td>
											</tr>
                    


                @endforeach
										</tbody>
									</table>

                                    {{ $documents->links() }}
									

								</div>
							</div>

                            @endif



                    </div>

                    <div class="col-xl-4 col-lg-6">
						@include('layouts.sidebar')
                        
                    </div>

                </div>
            </div>
        </section>


@endsection

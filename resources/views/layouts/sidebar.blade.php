<div class="sidebar-widget blog-sidebar pl-15 lg-pl-0">
                            <div class="widget-box sidebar-search">
                                <form method="get" action="{{ route('index.recherche') }}" class="sidebar__search-form">
                @csrf
                                    <input type="search" name="recherche" placeholder="Recherche..." required >
                                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </form>
                            </div>

@php
    $services1 = DB::table('services')->where('etat', 1)->where('spotlight', 0)->where('langue_id', __('id'))->limit(5)->get();
@endphp
                            @if (count($services1) > 0)
                            <div class="sidebar-category-list">
                                <h4 class="sidebar-title"> {{ __('service_last') }} </h4>
                                <div class="widget-box">
                                    <ul class="categories">
                                        @foreach ($services1 as $service)
                                        <li><a href="{{ env('APP_URL') }}service/{{ $service->id }}-{{ getEnleveAccent($service->titre) }}.html">{{ $service->titre }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif


@php
    $actualites1 = DB::table('actualites')->where('etat', 1)->where('spotlight', 0)->where('langue_id', __('id'))->limit(5)->get();
@endphp
                            @if (count($actualites1) > 0)
                            <div class="sidebar-latest-posts">
                                <h4 class="sidebar-title"> {{ __('actualite_last') }} </h4>
                                <div class="widget-box">
                                    <div class="latest-posts">
                                        @foreach ($actualites1 as $actualite)
                                        @if ($actualite->vignette != '')
                                        <div class="post">
                                            <a href="{{ env('APP_URL') }}actualite/{{ $actualite->id }}-{{ getEnleveAccent($actualite->titre) }}.html"><img src="{{ env('APP_URL') }}timthumb.php?src={{ env('APP_URL') . $actualite->vignette }}&w=88&h=88&zc=1&q=100" alt="{{ $actualite->titre }}"></a>
                                            <div class="post-content">
                                                <a href="{{ env('APP_URL') }}actualite/{{ $actualite->id }}-{{ getEnleveAccent($actualite->titre) }}.html">{{ $actualite->titre }}</a>
                                                <p>{{ \Carbon\Carbon::parse($actualite->dateactualite)->translatedFormat('d F Y') }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif



                            <!-- <div class="sidebar-tags">
                                <h4 class="sidebar-title"> Latest Posts </h4>
                                <div class="widget-box">
                                    <div class="tag-list">
                                        <span class="tag">BUSINESS</span>
                                        <span class="tag active">FINANCE</span>
                                        <span class="tag">DATA</span>
                                        <span class="tag">CORPORATE</span>
                                        <span class="tag">CONSULTING</span>
                                        <span class="tag">MARKETING</span>
                                        <span class="tag">TRADING</span>
                                    </div>
                                </div>
                            </div> -->

                            <div class="sidebar-newsletter">
                                <h4 class="sidebar-title"> Newsletter </h4>
                                <div class="widget-box mb-0">
                                    <form class="newsletter-form">
                                        <div class="form-group">
                                            <div id="nivonewsletter3">
                                            <input type="email" id="email" name="email" class="email mb-0"  placeholder="Enter email" autocomplete="on" required="">
                                            </div>
                                            <button type="button" style="
    display: inline-block;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    right: 10px;
    width: 38px;
    height: 38px;
    font-size: 16px;
    color: var(--white-color);
    background: var(--theme-color);
    border-radius: 50%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;" onclick="ouvre_newsletters(document.getElementById('email').value, 'nivonewsletter3');">
                                                <i class="far fa-paper-plane"></i>
                                                <span class="btn-title"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>



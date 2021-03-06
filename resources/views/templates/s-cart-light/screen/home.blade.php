@php
/*
$layout_page = home
*/ 
@endphp

@extends($sc_templatePath.'.layout')
@php
    $productsNew = $modelProduct->start()->getProductLatest()->setlimit(sc_config('product_top'))->getData();
    $productsHot = $modelProduct->start()->getProductBestSell()->setlimit(sc_config('product_top'))->getData();
    $news = $modelNews->start()->setlimit(sc_config('item_top'))->getData();
    $categoryHot = $modelCategory->start()->getCategoryTop()->setlimit(6)->getData();
@endphp

@section('block_main')
    <!--New Product-->
    <section class="section section-xxl bg-gray-21">
        <div class="container">

            <h2 class="wow fadeScale">{{ trans('front.products_hot') }}</h2>

            <div class="row row-30 row-lg-50">
                @foreach ($productsHot as $key => $productsHot)
                    <div class="col-sm-6 col-md-4 col-lg-3">

                    <!-- Product-->
                        <article class="product wow fadeInRight">
                            <div class="product-body">

                                {{-- Product image --}}
                                <div class="product-figure">
                                    <a href="{{ $productsHot->getUrl() }}">
                                        <img src="{{ asset($productsHot->getThumb()) }}" alt="{{ $productsHot->name }}" style="height: 200px; object-fit: cover;"/>
                                    </a>
                                </div>
                                {{--// Product image --}}

                                {{-- Product name --}}
                                <h5 class="product-title"><a href="{{ $productsHot->getUrl() }}">{{ $productsHot->name }}</a></h5>
                                {{--// Product name --}}

                                {{-- Display store - if use MultiStorePro --}}
                                @if (sc_config_global('MultiStorePro') && config('app.storeId') == 1)
                                    <div class="store-url"><a href="{{ $productsHot->goToStore() }}"><i class="fa fa-shopping-bag" aria-hidden="true"></i> {{ trans('front.store').' '. $productsHot->store_id  }}</a>
                                    </div>
                                @endif
                                {{-- //Display store - if use MultiStorePro --}}

                                {{-- Add to cart --}}
                                @if ($productsHot->allowSale())
                                    <a onClick="addToCartAjax('{{ $productsHot->id }}','default','{{ $productsHot->store_id }}')" class="button button-lg button-secondary button-zakaria add-to-cart-list"><i class="fa fa-cart-plus"></i> {{trans('front.add_to_cart')}}</a>
                                @endif
                                {{-- //Add to cart --}}

                                {!! $productsHot->showPrice() !!}
                            </div>

                            {{-- Product type --}}
                            @if ($productsHot->price != $productsHot->getFinalPrice() && $productsHot->kind !=SC_PRODUCT_GROUP)
                                <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" /></span>
                            @elseif($productsHot->kind == SC_PRODUCT_BUILD)
                                <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" /></span>
                            @elseif($productsHot->kind == SC_PRODUCT_GROUP)
                                <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" /></span>
                            @endif
                            {{-- //Product type --}}

                            {{-- wishlist, compare --}}
                            <div class="product-button-wrap">
                                <div class="product-button">
                                    <a class="button button-secondary button-zakaria" onClick="addToCartAjax('{{ $productsHot->id }}','wishlist','{{ $productsHot->store_id }}')">
                                        <i class="fas fa-heart"></i>
                                    </a>
                                </div>
                                <div class="product-button">
                                    <a class="button button-primary button-zakaria" onClick="addToCartAjax('{{ $productsHot->id }}','compare','{{ $productsHot->store_id }}')">
                                        <i class="fa fa-exchange"></i>
                                    </a>
                                </div>
                                {{-- //wishlist, compare --}}

                            </div>
                        </article>
                    </div>
                @endforeach

                    <div class="container" style="margin-bottom: 0px;">
                        <div class="row">
                            <div class="col text-center">
                                <div class="button-wrap fadeInUp animated text-center" data-caption-animate="fadeInUp" data-caption-delay="300">
                                    <a class="button button-zachem-tak-delat button-white button-zakaria" href="{{ sc_route('shop') }}" target="_self">
                                        Tất cả sản phẩm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </section>
      <!-- Hot Category-->
      <section class="section section-xxl bg-default">
        <div class="container">

          <h2 class="wow fadeScale">Danh mục sản phẩm thịnh hành</h2>
        </div>
{{--          <div class="row row-30 row-lg-50">--}}
              <div class="owl-carousel owl-style-7" data-items="1" data-sm-items="2" data-xl-items="3" data-xxl-items="4" data-nav="true" data-dots="true" data-margin="30" data-autoplay="true">

            @foreach ($categoryHot as $key => $categoryHot)
{{--            <div class="col-sm-6 col-md-4 col-lg-3">--}}
                <!-- Product-->
                <article class="product wow fadeInRight">
                  <div class="product-body">

{{--                     Product image--}}
                    <div class="product-figure">
                        <a href="{{ $categoryHot->getUrl() }}">
                        <img src="{{ asset($categoryHot->getThumb()) }}" alt="{{ $categoryHot->title }}" style="height: 200px; object-fit: cover;"/>
                        </a>
                    </div>
{{--                    // Product image--}}

{{--                     Product name--}}
                    <h5 class="product-title"><a href="{{ $categoryHot->getUrl() }}">{{ $categoryHot->title }}</a></h5>
{{--                    // Product name--}}

                  </div>

                </article>
{{--              </div>--}}
            @endforeach
          </div>
      </section>


      <!--New Product-->
      <section class="section section-xxl bg-gray-21">
          <div class="container">

              <h2 class="wow fadeScale">{{ trans('front.products_new') }}</h2>

              <div class="row row-30 row-lg-50">
                  @foreach ($productsNew as $key => $productNew)
                      <div class="col-sm-6 col-md-4 col-lg-3">
                          <!-- Product-->
                          <article class="product wow fadeInRight">
                              <div class="product-body">

                                  {{-- Product image --}}
                                  <div class="product-figure">
                                      <a href="{{ $productNew->getUrl() }}">
                                          <img src="{{ asset($productNew->getThumb()) }}" alt="{{ $productNew->name }}" style="height: 200px; object-fit: cover;"/>
                                      </a>
                                  </div>
                                  {{--// Product image --}}

                                  {{-- Product name --}}
                                  <h5 class="product-title"><a href="{{ $productNew->getUrl() }}">{{ $productNew->name }}</a></h5>
                                  {{--// Product name --}}

                                  {{-- Display store - if use MultiStorePro --}}
                                  @if (sc_config_global('MultiStorePro') && config('app.storeId') == 1)
                                      <div class="store-url"><a href="{{ $productNew->goToStore() }}"><i class="fa fa-shopping-bag" aria-hidden="true"></i> {{ trans('front.store').' '. $productNew->store_id  }}</a>
                                      </div>
                                  @endif
                                  {{-- //Display store - if use MultiStorePro --}}

                                  {{-- Add to cart --}}
                                  @if ($productNew->allowSale())
                                      <a onClick="addToCartAjax('{{ $productNew->id }}','default','{{ $productNew->store_id }}')" class="button button-lg button-secondary button-zakaria add-to-cart-list"><i class="fa fa-cart-plus"></i> {{trans('front.add_to_cart')}}</a>
                                  @endif
                                  {{-- //Add to cart --}}

                                  {!! $productNew->showPrice() !!}
                              </div>

                              {{-- Product type --}}
                              @if ($productNew->price != $productNew->getFinalPrice() && $productNew->kind !=SC_PRODUCT_GROUP)
                                  <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" /></span>
                              @elseif($productNew->kind == SC_PRODUCT_BUILD)
                                  <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" /></span>
                              @elseif($productNew->kind == SC_PRODUCT_GROUP)
                                  <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" /></span>
                              @endif
                              {{-- //Product type --}}

                              {{-- wishlist, compare --}}
                              <div class="product-button-wrap">
                                  <div class="product-button">
                                      <a class="button button-secondary button-zakaria" onClick="addToCartAjax('{{ $productNew->id }}','wishlist','{{ $productNew->store_id }}')">
                                          <i class="fas fa-heart"></i>
                                      </a>
                                  </div>
                                  <div class="product-button">
                                      <a class="button button-primary button-zakaria" onClick="addToCartAjax('{{ $productNew->id }}','compare','{{ $productNew->store_id }}')">
                                          <i class="fa fa-exchange"></i>
                                      </a>
                                  </div>
                                  {{-- //wishlist, compare --}}

                              </div>
                          </article>
                      </div>
                  @endforeach
                      <div class="container" style="margin-bottom: 0px;">
                          <div class="row">
                              <div class="col text-center">
                                  <div class="button-wrap fadeInUp animated text-center" data-caption-animate="fadeInUp" data-caption-delay="300">
                                      <a class="button button-zachem-tak-delat button-white button-zakaria" href="{{ sc_route('shop') }}" target="_self">
                                          Tất cả sản phẩm
                                      </a>
                                  </div>
                              </div>
                          </div>
                      </div>

              </div>
          </div>
      </section>
@endsection

@section('news')
  @if ($news)
  <!-- Our Blog-->
  <section class="section section-xxl section-last bg-default">
    <div class="container">
      <h2 class="wow fadeScale">{{ trans('front.blog') }}</h2>
    </div>
    <!-- Owl Carousel-->
    <div class="owl-carousel owl-style-7" data-items="1" data-sm-items="2" data-xl-items="3" data-xxl-items="4" data-nav="true" data-dots="true" data-margin="30" data-autoplay="true">
      @foreach ($news as $blog)
      <!-- Post Creative-->
      <article class="post post-creative"><a class="post-creative-figure" href="{{ $blog->getUrl() }}"><img src="{{ asset($blog->getThumb()) }}" alt="" width="420" height="368"/></a>
        <div class="post-creative-content">
          <h5 class="post-creative-title"><a href="{{ $blog->getUrl() }}">{{ $blog->title }}</a></h5>
          <div class="post-creative-time">
            <time datetime="{{ $blog->created_at }}">{{ $blog->created_at }}</time>
          </div>
        </div>
      </article>
      @endforeach
    </div>
  </section>
  @endif
@endsection

@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
{{-- Your scripts --}}
@endpush

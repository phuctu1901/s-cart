@php
$banners = $modelBanner->start()->getBanner()->getData()
@endphp
@if (!empty($banners))
<section class="section swiper-container swiper-slider swiper-slider-1" data-loop="true">
  <div class="swiper-wrapper text-center text-lg-left" >
    @foreach ($banners as $key => $banner)
    <div class="swiper-slide swiper-slide-caption context-dark" data-slide-bg="{{ asset($banner->image) }}" >
      <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)" style="background-color: rgba(0, 0, 0, 0.5);">
      <div class="swiper-slide-caption section-md text-center" >
        <div class="container " >
          <h1 class="swiper-title-1" data-caption-animate="fadeScale" data-caption-delay="100" style="font-weight: bold;">{{ $banner->title }}</h1>
          <p class="biggest text-white-70" data-caption-animate="fadeScale" data-caption-delay="200" style="font-weight: bold;">{{ $banner->desc }}</p>
          <div class="button-wrap" data-caption-animate="fadeInUp" data-caption-delay="300" >
            <a class="button button-zachem-tak-delat button-white button-zakaria" href="{{ $banner->url }}" target="{{ $banner->target }}" style="font-weight: bold;">
              Tìm hiểu thêm
            </a>
          </div>
        </div>
      </div>
      </div>
    </div>

    @endforeach
    <style>
      .opacity-mask {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        z-index: 2;
      }
    </style>
  </div>
  <!-- Swiper Pagination-->
  <div class="swiper-pagination"></div>
  <!-- Swiper Navigation-->
  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>
</section>
<!--slider-->
@endif
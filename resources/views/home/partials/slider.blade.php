<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
      aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
      aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
      aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    @if ($sliders->count() > 0)
      {{-- Show sliders from database --}}
      @foreach ($sliders as $key => $sliderItem)
        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">

          <img src="{{ asset('storage/' . $sliderItem->image) }}" class="d-block w-100" style="height: 500px;"
            alt="Slider">

          <div class="carousel-caption d-none d-md-block">
            <div class="custom-carousel-content bg-overlay">
              <h1>{{ $sliderItem->title }}</h1>
              <p>{!! $sliderItem->description !!}</p>
              <a href="#" class="btn btn-slider">Get Now</a>
            </div>
          </div>

        </div>
      @endforeach
    @else
      @php
        $defaultSliders = [
            'default_slider_images/banner-1.jpg',
            'default_slider_images/banner-2.jpg',
            'default_slider_images/banner-3.jpg',
        ];
      @endphp

      {{-- Show default images --}}
      @foreach ($defaultSliders as $key => $image)
        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">

          <img src="{{ asset($image) }}" class="d-block w-100" style="height: 500px;" alt="Default Slider">

          <div class="carousel-caption d-none d-md-block">
            <div class="custom-carousel-content bg-overlay">
              <h1>Welcome to CourseEdx</h1>
              <p>Learn Anytime, Anywhere</p>
              <a href="#" class="btn btn-slider">Get Started</a>
            </div>
          </div>

        </div>
      @endforeach
    @endif


  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

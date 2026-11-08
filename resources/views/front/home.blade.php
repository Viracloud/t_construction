@extends('front.layouts.master')

@section('banner')

@endsection

@section('content')
<section class="hero-slider-section">
    <div class="hero-slider owl-carousel owl-theme">

        @foreach($sliders as $slider)
        <div class="hero-slide-item banner-five-main-wrapper bg-style slider-bg-1" style="background-image: url('{{ asset('uploads/'.$slider->image) }}');">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 text-white">
                        <{{ $loop->first ? 'h1' : 'h2' }} class="mb-4 hero-slider-title">
                            {{ $slider->heading }}
                        </{{ $loop->first ? 'h1' : 'h2' }}>
                        <p class="hero-slide-paragraph">
                            {!! nl2br($slider->text) !!}
                        </p>
                        @if($slider->button_text != '' && $slider->button_link != '')
                        <div>
                            <a href="{{ $slider->button_link }}" class="primary-btns hover-icon-reverse">
                                <span class="btn-text-content">
                                    <span class="btn-icon-wrapper">
                                        <span class="btn-text">{{ $slider->button_text }}</span>
                                        <span class="btn-icon-hover"><i class="fa-solid fa-arrow-right"></i></span>
                                    </span>
                                </span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</section>


@if($page_data->about_status == 'Show')
<section class="px-3  overflow-hidden">
    <div class="container py-24">
        <div class="row align-items-center g-5">
            <div class="col-md-5">
                <div class="position-relative about-img-wrapper">
                    <img loading="lazy" src="{{ asset('uploads/shape-01.svg') }}" alt="" class="position-absolute about-shape1">
                    <img loading="lazy" src="{{ asset('uploads/'.$about_item->image) }}" class="img-fluid rounded-3 position-relative z-1" alt="{{ $global_setting->site_name }} - construction and renovation work in {{ $global_setting->business_city ?: 'Sydney' }}">
                    <img loading="lazy" src="{{ asset('uploads/shape-02.svg') }}" alt="" class="position-absolute about-shape2">

                    @if($about_item->experience_year != '' || $about_item->experience_text != '')
                    <div class="counter-badge position-absolute bg-white shadow p-4 rounded-3 d-flex align-items-center z-2">
                        <div>
                            @if($about_item->experience_year != '')
                            <h3 class="h2 fw-bold mb-0 text-primary">{{ $about_item->experience_year }}+</h3>
                            @endif
                            @if($about_item->experience_text != '')
                            <p class="small text-muted mb-0">{{ $about_item->experience_text }}</p>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!--@if($about_item->youtube_id != '')-->
                    <!--<a -->
                    <!-- href="https://www.youtube.com/watch?v={{ $about_item->youtube_id }}"-->
                    <!--    class="glightbox video-play-btn about-play-btns  mb-4 me-4 z-30 text-decoration-none">-->
                    <!--    <span class="play-icon shadow-lg">-->
                    <!--        <i class="fa-solid fa-play"></i>-->
                    <!--    </span>-->
                    <!--</a>-->
                    <!--@endif-->
                    
                </div>
            </div>

            <div class="col-md-7">
                <div class="section-title">
                    @if($about_item->subheading != '')
                    <p class="text-primary fw-bold text-uppercase mb-2">
                        {{ $about_item->subheading }}
                    </p>
                    @endif
                    <h2 class="main-title fw-600 mb-4">
                        {!! nl2br($about_item->heading) !!}
                    </h2>
                    <div class="description">
                        {!! nl2br($about_item->text) !!}
                    </div>
                </div>

                <div class="mt-4">
                    @if($about_item->phone_text != '' || $about_item->phone_number != '')
                    <div class="d-flex align-items-center mb-30">
                        <div class="call-icon bg-light p-3 rounded-circle me-3 border">
                            <i class="fa-solid fa-phone-volume text-primary fs-4"></i>
                        </div>
                        <div>
                            @if($about_item->phone_text != '')
                            <p class="text-muted mb-2">{{ $about_item->phone_text }}</p>
                            @endif
                            @if($about_item->phone_number != '')
                            <a href="tel:{{ $about_item->phone_number }}" class="h6 fw-bold text-decoration-none text-dark">{{ $about_item->phone_number }}</a>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($about_item->button_link != '' && $about_item->button_text != '')
                    <a href="{{ $about_item->button_link }}" class="primary-btns hover-icon-reverse">
                        <span class="btn-text-content">
                            <span class="btn-icon-wrapper">
                                <span class="btn-icon"><i class="fa-solid fa-phone"></i></span>
                                <span class="btn-text">{{ $about_item->button_text }}</span>
                            </span>
                        </span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif


@if($page_data->service_status == 'Show')
<section class="services-section px-3">
    <div class="container py-24">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 col-md-7">
                <span class="sub-title">{{ $page_data->service_subheading }}</span>
                <h2 class="main-title">{!! nl2br($page_data->service_heading) !!}</h2>
            </div>
            <div class="col-lg-5 offset-lg-1 col-md-5 mt-3 mt-md-0">
                <p class="description mb-0">
                    {!! nl2br($page_data->service_text) !!}
                </p>
            </div>
        </div>
        <div class="row g-4">
            @foreach($services as $service)
            <div class="col-md-6 col-lg-4">
                <div class="service-card p-4 h-100">
                    <div class="card-icon mb-4">
                        <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$service->icon) }}" alt="" width="55">
                    </div>
                    <h3 class="card-title">{{ $service->title }}</h3>
                    <p class="card-text">{!! nl2br($service->short_description) !!}</p>

                    <a href="{{ route('service',$service->slug) }}" class="read-more-btn">
                        <span class="ms-3">Read More</span>
                        <div class="arrow-circle">
                            <span class="arrow-icon">↗</span>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


@if($page_data->project_status == 'Show')
<section class="works-process-area px-3">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 col-md-7">
                <span class="sub-title">{{ $page_data->project_subheading }}</span>
                <h2 class="main-title">{!! nl2br($page_data->project_heading) !!}</h2>
            </div>
            <div class="col-lg-5 offset-lg-1 col-md-5 mt-3 mt-md-0">
                <p class="description mb-0">
                    {!! nl2br($page_data->project_text) !!}
                </p>
            </div>
        </div>

        <div class="row g-4">

            @foreach($projects as $project)
            <div class="col-md-6 col-xl-4">
                <div class="process-card position-relative overflow-hidden rounded-3 shadow-sm">
                    <div class="card-bg-img worker-bg-1" style="background-image: url('{{ asset('uploads/'.$project->image) }}');"></div>
                    <div class="card-content-normal p-4">
                        <h3 class="title works-title h5 fw-bold">
                            {{ $project->title }}
                        </h3>
                    </div>
                    <div class="card-content-hover p-4 d-flex flex-column justify-content-end">
                        <h3 class="title works-title h4 fw-bold mb-3">
                            {{ $project->title }}
                        </h3>
                        <div>
                            <a href="{{ route('project',$project->slug) }}" class="primary-btns hover-icon-reverse">
                                <span class="btn-text-content">
                                    <span class="btn-icon-wrapper">
                                        <span class="btn-icon">
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </span>
                                        <span class="btn-text">View Details</span>
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
@endif


@if($page_data->testimonial_status == 'Show')
<section class="testimonial-area py-5 bg-white position-relative">
    <div class="container py-24">
        <div class="row mb-5 text-center">
            <div class="col-12">
                <p class="sub-title">{{ $page_data->testimonial_subheading }}</p>
                <h2 class="main-title">{!! nl2br($page_data->testimonial_heading) !!}</h2>
            </div>
        </div>

        <div class="slider-container-relative position-relative px-md-5">
            <div class="owl-carousel owl-theme testimonial-slider-3">

                @foreach($testimonials as $testimonial)
                <div class="item  border shadow-sm px-40">
                    <div class="testimonial-card py-50 m-2 bg-white h-100">
                        <div class="author-info d-flex align-items-center mb-4">
                            <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$testimonial->image) }}"
                                class="rounded-circle me-3 border-2 border-white shadow-sm size-60"
                                alt="{{ $testimonial->name }}">
                            <div>
                                <h4 class="mb-0 fw-bold">{{ $testimonial->name }}</h4>
                                <p class="text-muted mb-0">{{ $testimonial->designation }}</p>
                            </div>
                        </div>
                        <p class="testimonial-text text-muted mb-3">
                            {!! nl2br($testimonial->comment) !!}
                        </p>
                        <div class="star-rating text-warning small">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
@endif


@if($page_data->team_status == 'Show')
<section class="team-area px-3">
    <div class="container py-24">
        <div class="row mb-5 text-center">
            <div class="col-12">
                <p class="sub-title">{{ $page_data->team_subheading }}</p>
                <h2 class="main-title">{!! nl2br($page_data->team_heading) !!}</h2>
            </div>
        </div>

        <div class="row g-4">
            
            @foreach($members as $member)
            <div class="col-xl-3 col-md-4 ">
                <div class="team-card-v2">
                    <div class="image-section">
                        <a href="{{ route('member', $member->slug) }}">
                            <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$member->image) }}" class="img-fluid w-100"
                                alt="{{ $member->name }}">
                        </a>
                        <div class="social-wrapper">
                            <ul class="list-unstyled mb-0 d-flex justify-content-center gap-2">
                                @if($member->facebook != '')
                                <li>
                                    <a href="{{ $member->facebook }}"><i class="fa-brands fa-facebook-f"></i></a>
                                </li>
                                @endif
                                @if($member->twitter != '')
                                <li>
                                    <a href="{{ $member->twitter }}"><i class="fa-brands fa-twitter"></i></a>
                                </li>
                                @endif
                                @if($member->linkedin != '')
                                <li>
                                    <a href="{{ $member->linkedin }}"><i class="fa-brands fa-linkedin-in"></i></a>
                                </li>
                                @endif
                                @if($member->instagram != '')
                                <li>
                                    <a href="{{ $member->instagram }}"><i class="fa-brands fa-instagram"></i></a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="content-area position-relative content-area-padding">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="title mb-2">
                                    <a href="{{ route('member', $member->slug) }}" class="title text-reset text-decoration-none fw-bold">{{ $member->name }}</a>
                                </h5>
                                <p class="designation text-muted mb-1">{{ $member->designation }}</p>
                            </div>
                            <a href="{{ route('member', $member->slug) }}" class="team-arrow-icon text-decoration-none text-reset">
                                <div class="arrow-circle">
                                    <span class="arrow-icon">↗</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</section>
@endif


@if($page_data->event_status == 'Show')
<section class="up-coming-events px-3">
    <div class="container py-24">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 col-md-7">
                <span class="sub-title">{{ $page_data->event_subheading }}</span>
                <h2 class="main-title">{!! nl2br($page_data->event_heading) !!}</h2>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('events') }}" class="primary-btns hover-icon-reverse">
                    <span class="btn-text-content">
                        <span class="btn-icon-wrapper">
                            <span class="btn-icon"><i class="fa-solid fa-arrow-right"></i></span>
                            <span class="btn-text">View Details</span>
                    </span>
                </a>
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col-12">
                <div class="owl-carousel event-carousel owl-theme">

                    @foreach($events as $event)
                    <div class="item">
                        <div class="single-event-card shadow-sm border rounded-4 overflow-hidden bg-white">
                            <div class="thumbnail position-relative overflow-hidden">
                                <a href="{{ route('event', $event->slug) }}">
                                    <img loading="lazy" decoding="async" src="{{ asset('uploads/' . $event->image) }}" class="img-fluid w-100" alt="{{ $event->title }}">
                                </a>
                            </div>
                            <div class="content p-4">
                                <div class="d-flex gap-3 mb-3 text-muted small">
                                    <span><i class="fa-solid fa-location-dot text-primary me-1"></i> {{ $event->event_location }}</span>
                                    <span><i class="fa-solid fa-calendar-day text-primary me-1"></i> {{ $event->event_date }}</span>
                                </div>
                                <a href="{{ route('event', $event->slug) }}" class="text-decoration-none text-dark">
                                    <h4 class="title fw-bold mb-4">
                                        {{ $event->title }}
                                    </h4>
                                </a>
                                <a href="{{ route('event', $event->slug) }}" class="primary-btns hover-icon-reverse">
                                    <span class="btn-text-content">
                                        <span class="btn-icon-wrapper">
                                            <span class="btn-icon"><i class="fa-solid fa-arrow-right"></i></span>
                                            <span class="btn-text">View Details</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
@endif



@if($page_data->blog_status == 'Show')
<section class="blogs-section px-3">
    <div class="container py-24">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 col-md-7">
                <span class="sub-title">{{ $page_data->blog_subheading }}</span>
                <h2 class="main-title">{!! nl2br($page_data->blog_heading) !!}</h2>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="blogs.html" class="primary-btns hover-icon-reverse">
                    <span class="btn-text-content">
                        <span class="btn-icon-wrapper">
                            <span class="btn-icon"><i class="fa-solid fa-arrow-right"></i></span>
                            <span class="btn-text">View all Blogs</span>
                    </span>
                </a>
            </div>
        </div>
        <!-- blogs -->
        <div class="row justify-content-center align-items-center">
            <div class="col-12">
                <section class="tmp-blog-area2 inner">
                    <div class="container">
                        <div class="row g-4">
                            @foreach($posts as $post)
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card h-100 border-0 shadow-sm blog-card-style-two rounded-3 overflow-hidden">
                                    <div class="image-section position-relative">
                                        <a href="{{ route('post',$post->slug) }}">
                                            <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$post->image) }}"  class="card-img-top img-fluid" alt="{{ $post->title }}">
                                        </a>
                                    </div>
                                    <div class="card-body p-4">
                                        <h4 class="card-title fw-bold mb-4">
                                            <a href="{{ route('post',$post->slug) }}" class="text-decoration-none text-dark hover-primary">
                                                {{ $post->title }}
                                            </a>
                                        </h4>
                                        <div class="button-area mt-auto">
                                            <a href="{{ route('post',$post->slug) }}" class="btn btn-link p-0 text-decoration-none fw-bold text-primary"> READ MORE <i class="fa-solid fa-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@endif

@endsection
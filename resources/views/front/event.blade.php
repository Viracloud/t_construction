@extends('front.layouts.master')

{{-- SEO --}}
@section('seo_title', \App\Support\Seo::title($event->seo_title, $event->title, $global_setting->site_name))
@section('seo_description', \App\Support\Seo::description($event->seo_meta_description, $event->description))
@section('og_image', asset('uploads/'.$event->image))
@include('front.layouts.schema-breadcrumb', ['items' => [['Events', route('events')], [$event->title, route('event', $event->slug)]]])
@include('front.layouts.schema-faq', ['faqs' => $all_faqs])

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $event->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('events') }}" class="text-white text-decoration-none opacity-75">{{ $page_data->page_title }}</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $event->title }}
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-shape">
        <img loading="lazy" decoding="async" src="{{ asset('uploads/shape-01.png') }}" class="shape-1" alt="">
        <img loading="lazy" decoding="async" src="{{ asset('uploads/shape-02.png') }}" class="shape-2" alt="">
    </div>
</section>
@endsection

@section('content')
<section class="event-details pb-5 py-24">
    <div class="container py-24 pt-0 border rounded">
        <div class="row">
            <div class="col-12 position-relative">
                <div class="ratio ratio-21x9 rounded-top overflow-hidden">
                    <img fetchpriority="high" src="{{ asset('uploads/'.$event->image) }}" class="img-fluid object-fit-cover" alt="{{ $event->title }}">

                    @if($event->youtube_id != '')
                    <div class="overlay d-flex align-items-center justify-content-center h-100 position-absolute top-0 start-0 w-100">
                        <a href="https://www.youtube.com/watch?v={{ $event->youtube_id }}"
                            class="glightbox video-play-btn worker-play-btns  mb-4 me-4 z-30 text-decoration-none">
                            <span class="play-icon shadow-lg">
                                <i class="fa-solid fa-play"></i>
                            </span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-11">
                <div class="card border-0 shadow-sm info-card p-4">
                    <div class="row align-items-center g-4">
                        <div class="col-md-3 d-flex align-items-start">
                            <div class="icon-box me-3"><i class="far fa-clock"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Date and time</h6>
                                <p class="text-muted small mb-0">{{ $event->event_date }}<br>{{ $event->event_time }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-start border-start-md">
                            <div class="icon-box me-3"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Location</h6>
                                <p class="text-muted small mb-0">{!! nl2br($event->event_location_detail) !!}</p>
                            </div>
                        </div>

                        @if($event->ticket_price != '')
                        <div class="col-md-3 d-flex align-items-start border-start-md">
                            <div class="icon-box me-3"><i class="fas fa-sack-dollar"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Price</h6>
                                <p class="mb-0"><span class="fw-bold fs-5">{{ $event->ticket_price }}</span></p>
                            </div>
                        </div>
                        @endif

                        @if($event->button_text != '' || $event->button_link != '')
                        <div class="col-md-3 text-md-end">
                            <a href="{{ $event->button_link }}" class="primary-btns hover-icon-reverse">
                                <span class="btn-text-content">
                                    <span class="btn-icon-wrapper">
                                        <span class="btn-icon"><i class="fa-solid fa-phone"></i></span>
                                        <span class="btn-text">{{ $event->button_text }}</span>
                                    </span>
                                </span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 justify-content-center">
            <div class="col-11">
                <div class="events-description-area bg-box-shadow">
                    <h2 class="main-title">Event Description</h2>
                    <div class="description">
                        {!! $event->description !!}
                    </div>
                </div>
            </div>
        </div>


        @if(count($all_faqs) > 0)
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-11">
                <div class="events-faqs-area bg-box-shadow">
                    <h3 class="main-title">Event FAQ'S</h3>
                    <div class="accordion custom-accordion" id="accordionExample">

                        @foreach($all_faqs as $item)
                        <div class="accordion-item mb-3 border-0 bg-light rounded-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} fw-bold bg-transparent shadow-none"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}">
                                    {{ $item->question }}
                                </button>
                            </h2>
                            <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-muted pt-0">
                                    {!! nl2br($item->answer) !!}
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        @endif



    </div>
</section>
@endsection
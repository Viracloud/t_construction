@extends('front.layouts.master')

{{-- SEO --}}
@include('front.layouts.schema-faq', ['faqs' => $faqs])

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $page_data->page_title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}"
                                    class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $page_data->page_title }}
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
<section class="event-details py-24 pt-5">
    <div class="container">
        <div class="row">
            <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="events-faqs-area bg-box-shadow">
                    <div class="accordion custom-accordion" id="accordionExample">

                        @foreach($faqs as $faq)
                        <div class="accordion-item mb-3 border-0 bg-light rounded-3">
                            <h2 class="accordion-header">
                                
                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} fw-bold bg-transparent shadow-none"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <img loading="lazy" decoding="async" class="size-35" src="{{ asset('uploads/faq.svg') }}" alt="">
                                        {{ $faq->question }}
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-muted pt-0">
                                    {!! nl2br($faq->answer) !!}
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        </div>

        

        
    </div>
</section>
@endsection
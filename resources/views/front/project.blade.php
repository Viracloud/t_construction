@extends('front.layouts.master')

{{-- SEO --}}
@section('seo_title', \App\Support\Seo::title($project->seo_title, $project->title, $global_setting->site_name))
@section('seo_description', \App\Support\Seo::description($project->seo_meta_description, $project->short_description, $project->description))
@section('og_image', asset('uploads/'.$project->image))
@include('front.layouts.schema-breadcrumb', ['items' => [['Projects', route('projects')], [$project->title, route('project', $project->slug)]]])
@include('front.layouts.schema-faq', ['faqs' => $all_faqs])

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $project->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('projects') }}" class="text-white text-decoration-none opacity-75">{{ $page_data->page_title }}</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $project->title }}
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
<section class="project-details-area py-24 pt-5">
    <div class="container">
        <div class="section-inner">
            <!-- Project Banner -->
            <div class="project-banner mb--50">
                <img fetchpriority="high" src="{{ asset('uploads/'.$project->image) }}" alt="{{ $project->title }}"
                    class="img-fluid w-100 rounded-3">
            </div>

            <div class="row g-5">
                <!-- Main Content Area -->
                <div class="col-lg-8">
                    <div class="content-area pt-4">

                        <div class="description mt-4">
                            {!! $project->description !!}
                        </div>

                        @if(count($all_faqs) > 0)
                        <div class="faq-content-area with-box-shadow inner mt-5">
                            <div class="accordion" id="accordionExample">
                                @foreach($all_faqs as $item)
                                <div class="accordion-item mb-3 border-0 bg-light rounded-3">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed fw-bold bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}">
                                            <div class="d-flex justify-content-center align-items-center gap-1">
                                                <img loading="lazy" decoding="async" class="size-35" src="{{ asset('uploads/faq.svg') }}" alt="">
                                                {{ $item->question }}
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body text-muted pt-0">
                                            {!! nl2br($item->answer) !!}
                                        </div>
                                    </div>
                                </div>
                                @endforeach 
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Sticky Sidebar -->
                <div class="col-lg-4 pt-5">
                    <aside class="left-sidebar sticky-top sticky-offset-100">
                        <div class="single-wrapper p-5 rounded-3">
                            <h3 class="title-project-sticky mb--25">About My Project</h3>
                            <ul class="project-info-list p-0">
                                <li><strong>Start Date :</strong> <span>{{ $project->start_date }}</span></li>
                                <li><strong>End Date :</strong> <span>{{ $project->end_date }}</span></li>
                                <li><strong>Location :</strong> <span>{{ $project->location }}</span></li>
                                <li><strong>Manager :</strong> <span>{{ $project->manager }}</span></li>
                                <li><strong>Budget :</strong> <span>{{ $project->budget }}</span></li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@extends('front.layouts.master')

{{-- SEO --}}
@section('seo_title', \App\Support\Seo::title($member->seo_title, $member->name.($member->designation ? ' - '.$member->designation : ''), $global_setting->site_name))
@section('seo_description', \App\Support\Seo::description($member->seo_meta_description, $member->short_description, $member->description))
@section('og_image', asset('uploads/'.$member->image))
@include('front.layouts.schema-breadcrumb', ['items' => [['Team', route('members')], [$member->name, route('member', $member->slug)]]])

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $member->name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('members') }}" class="text-white text-decoration-none opacity-75">{{ $page_data->page_title }}</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $member->name }}
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
<section class="tmp-team-details-area py-5">
    <div class="container py-24 pt-0">
        <div class="section-inner">
            <div class="row g-5 align-items-center mb-5">
                <div class="col-lg-5">
                    <div class="image-section rounded-3 overflow-hidden shadow-sm">
                        <img fetchpriority="high" src="{{ asset('uploads/'.$member->image) }}" class="img-fluid w-100" alt="{{ $member->name }}">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="team-content-area ps-lg-4">
                        <h2 class="main-title mt-0">{{ $member->name }}</h2>
                        <h5 class="designation text-primary fw-semibold mb-4">
                            {{ $member->designation }}
                        </h5>
                        <p class="description mb-4">
                            {!! nl2br($member->short_description) !!}
                        </p>

                        @if($member->phone != '' || $member->email != '' || $member->experience != '')
                        <ul class="list-unstyled team-info-list mb-4">
                            @if($member->phone != '')
                            <li class="mb-2 d-flex align-items-center">
                                <span class="fw-bold text-dark me-2">Phone :</span>
                                <a href="tel:+{{ $member->phone }}" class="text-decoration-none description">{{ $member->phone }}</a>
                            </li>
                            @endif
                            @if($member->email != '')
                            <li class="mb-2 d-flex align-items-center">
                                <span class="fw-bold text-dark me-2">Email :</span>
                                <a href="mailto:{{ $member->email }}" class="text-decoration-none description">{{ $member->email }}</a>
                            </li>
                            @endif
                            @if($member->experience != '')
                            <li class="d-flex align-items-center">
                                <span class="fw-bold text-dark me-2">Experience :</span>
                                <span class="description">{{ $member->experience }}</span>
                            </li>
                            @endif
                        </ul>
                        @endif

                        @if($member->facebook != '' || $member->twitter != '' || $member->linkedin != '' || $member->instagram != '')
                        <div class="social-wrapper d-flex gap-2">
                            @if($member->facebook != '')
                            <a href="{{ $member->facebook }}" class="rounded-circle"><i class="fa-brands fa-facebook-f"></i></a>
                            @endif
                            @if($member->twitter != '')
                            <a href="{{ $member->twitter }}" class="rounded-circle"><i class="fa-brands fa-twitter"></i></a>
                            @endif
                            @if($member->linkedin != '')
                            <a href="{{ $member->linkedin }}" class="rounded-circle"><i class="fa-brands fa-linkedin-in"></i></a>
                            @endif
                            @if($member->instagram != '')
                            <a href="{{ $member->instagram }}" class="rounded-circle"><i class="fa-brands fa-instagram"></i></a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="team-about-area mb-5">
                <h2 class="title fw-bold border-bottom pb-3 mb-4">About Member</h2>
                <div class="description mb-4">
                    {!! $member->description !!}
                </div>
            </div>
            <div class="team-bottom-area py-5">
                <div class="row g-5">
                    @if(count($all_skills) > 0)
                    <div class="col-lg-6">
                        <div class="skill-area" id="skills-section">
                            <h2 class="title fw-bold border-bottom pb-3 mb-4">Professional skills</h2>
                            <div class="progress-bar-area">
                                @foreach($all_skills as $skill)
                                <div class="single-progress mb-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fw-bold text-dark">{{ $skill->name }}</span>
                                        <span class="fw-bold text-primary percent-value">{{ $skill->percentage }}%</span>
                                    </div>
                                    <div class="progress rounded-pill progress-track">
                                        <div class="progress-bar rounded-pill skill-bar progress-fill" role="progressbar" data-width="{{ $skill->percentage }}" style="width: {{ $skill->percentage }}%" aria-valuenow="{{ $skill->percentage }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(count($all_awards) > 0)
                    <div class="col-lg-6">
                        <div class="award-area">
                            <h2 class="title fw-bold border-bottom pb-3 mb-4">Awards & Honor</h2>
                            <div class="row list-unstyled">
                                @foreach($all_awards as $award)
                                <div class="col-4">
                                    <div
                                        class="award-item d-flex flex-column text-center align-items-center p-3 mb-3 bg-white rounded-3">
                                        <div class="award-icon">
                                            <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$award->photo) }}" alt="{{ $award->name }}" style="width:100px;">
                                        </div>
                                        <h5 class="award-title mb-0 award-title-style">{{ $award->name }}</h5>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
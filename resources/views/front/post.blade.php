@extends('front.layouts.master')

{{-- SEO --}}
@section('seo_title', \App\Support\Seo::title($post->seo_title, $post->title, $global_setting->site_name))
@section('seo_description', \App\Support\Seo::description($post->seo_meta_description, $post->description))
@section('og_image', asset('uploads/'.$post->image))
@section('og_type', 'article')
@include('front.layouts.schema-breadcrumb', ['items' => [['Blog', route('blog')], [$post->title, route('post', $post->slug)]]])
@push('schema')
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'BlogPosting', 'headline' => \App\Support\Seo::text($post->title, 110), 'description' => \App\Support\Seo::description($post->seo_meta_description, $post->description), 'image' => asset('uploads/'.$post->image), 'datePublished' => optional($post->created_at)->toAtomString(), 'dateModified' => optional($post->updated_at)->toAtomString(), 'mainEntityOfPage' => route('post', $post->slug), 'author' => ['@type' => 'Organization', 'name' => $global_setting->site_name, 'url' => url('/')], 'publisher' => ['@type' => 'Organization', 'name' => $global_setting->site_name, 'logo' => ['@type' => 'ImageObject', 'url' => asset('uploads/'.$global_setting->logo_1)]]], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $post->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('blog') }}" class="text-white text-decoration-none opacity-75">{{ $page_data->page_title }}</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $post->title }}
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
<section class="py-5 py-md-5">
    <div class="container py-lg-4">
        <div class="row g-4">

            <div class="col-lg-8">
                <div class="card border-0 rounded-4 p-3 bg-white" data-aos="fade-up">

                    <div class="rounded-4 overflow-hidden mb-4 max-h-540">
                        <img fetchpriority="high" src="{{ asset('uploads/'.$post->image) }}" alt="{{ $post->title }}"
                            class="img-fluid w-100 object-fit-cover transition-700 hover-zoom">
                    </div>

                    <div class="article-header mb-4">
                        <div class="d-flex flex-wrap gap-4 text-muted small fw-bold">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fa-regular fa-clock text-primary-kiddos"></i> {{ $post->created_at->format('F d, Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="article-body text-secondary lh-lg fs-6">
                        <p>
                            {!! $post->description !!}
                        </p>

                        <div class="tag-post">
                            <h3>Tags</h3>
                            @php
                            $tags = explode(',', $post->tags);
                            foreach($tags as $tag) {
                                $trimmed_tag = trim($tag);
                                if($trimmed_tag) {
                                    echo '<a href="'.route('tag', $trimmed_tag).'" class="btn btn-primary btn-sm">'.$trimmed_tag.'</a>';
                                }
                            }
                            @endphp
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-top border-2 d-flex flex-wrap align-items-center gap-3">
                        <span class="fw-bold text-dark">Share This:</span>
                        <div class="d-flex gap-2">
                            <a href="#" class="share-icon bg-facebook"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="share-icon bg-twitter"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#" class="share-icon bg-pinterest"><i class="fa-brands fa-pinterest-p"></i></a>
                        </div>
                    </div>
                </div>


                <div class="blog-reply-wrapper mt-5">

                    <div class="comment-list-area">
                        <h3 class="reply-title mb-5">{{ $total_approved_comments }} Comments to “{{ $post->title }}”</h3>

                        @forelse($comments as $comment)
                        <div class="single-comment-box d-flex">
                            <div class="user-avatar">
                                @php
                                $email = trim(strtolower($comment->email));
                                $hash = md5($email);
                                $gravatar_url = "https://www.gravatar.com/avatar/$hash?s=80&d=mp";
                                echo '<img loading="lazy" decoding="async" src="'.$gravatar_url.'" alt="">';
                                @endphp
                            </div>
                            <div class="comment-info ms-4">
                                <h5 class="user-name">{{ $comment->name }}, <span class="comment-date">{{ $comment->created_at->format('F d, Y') }}</span></h5>
                                <p class="comment-text">{!! nl2br($comment->comment) !!}</p>
                                <a href="#" class="reply-link" data-bs-toggle="modal" data-bs-target="#modal_reply_{{ $comment->id }}">Reply <i class="fa-solid fa-reply ms-1"></i></a>
                            </div>
                        </div>
                        <div class="comment-divider"></div>
                        <!-- Reply Modal -->
                        <div class="modal fade" id="modal_reply_{{ $comment->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Give a Reply</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('reply_store') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                            <div class="mb-3">
                                                <input type="text" class="form-control reply-input" name="name" placeholder="Your Name *" required>
                                            </div>
                                            <div class="mb-3">
                                                <input type="email" class="form-control reply-input" name="email" placeholder="Your Email *" required>
                                            </div>
                                            <div class="mb-3">
                                                <textarea class="form-control reply-input" rows="5" name="reply" placeholder="Write your Reply *"></textarea>
                                            </div>
                                            <button type="submit" class="post-comment-btn">
                                                Submit <i class="fa-solid fa-arrow-right ms-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- // Reply Modal -->

                        @foreach($comment->replies->where('status','Approved') as $reply)
                        <div class="single-comment-box d-flex ms-5 ps-4">
                            <div class="user-avatar">
                                @php
                                $email = trim(strtolower($reply->email));
                                $hash = md5($email);
                                $gravatar_url = "https://www.gravatar.com/avatar/$hash?s=80&d=mp";
                                echo '<img loading="lazy" decoding="async" src="'.$gravatar_url.'" alt="">';
                                @endphp
                            </div>
                            <div class="comment-info ms-4">
                                <h5 class="user-name">{{ $reply->name }} @if($reply->reply_by == 'Admin') (Admin) @endif, <span class="comment-date">{{ $reply->created_at->format('F d, Y') }}</span></h5>
                                <p class="comment-text">{!! nl2br($reply->reply) !!}</p>
                            </div>
                        </div>
                        <div class="comment-divider"></div>
                        @endforeach

                        @empty
                        <p class="text-danger">No comments yet.</p>
                        @endforelse
                        
                    </div>

                    <div class="leave-reply-form mt-5">
                        <h3 class="reply-title mb-2">Leave a Reply</h3>
                        <p class="subtitle mb-4">Your email address will not be published. Required fields are
                            marked *</p>

                        <form action="{{ route('comment_store') }}" method="post">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control reply-input" name="name" placeholder="Your Name *" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control reply-input" name="email" placeholder="Your Email *" required>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control reply-input" rows="5" name="comment" placeholder="Write your Comment*"></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="post-comment-btn">
                                        Post Comment <i class="fa-solid fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sticky-top sticky-offset-100">

                    <!-- Search Box -->
                    <div class="card border-0 rounded-4 shadow-sm p-4 bg-white mb-4">
                        <form action="{{ route('search') }}" class="position-relative" method="get">
                            <input type="text" class="form-control rounded-pill ps-4 pe-5 py-3" placeholder="Search blog..." name="search_text">
                            <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y me-2 p-0 border-0 bg-transparent">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </button>
                        </form>
                    </div>

                    <div class="card border-0 rounded-4 shadow-sm p-4 bg-white" data-aos="fade-left">

                        <h3 class="h5 fw-black text-dark mb-4 d-flex align-items-center gap-2">
                            Recent Blogs <span class="rounded-pill tag-indicator"></span>
                        </h3>

                        @foreach($recent_posts as $recent_post)
                        @if(!$loop->first)
                        <hr>
                        @endif
                        <div class="vstack gap-4">
                            <a href="{{ route('post', $recent_post->slug) }}" class="d-flex gap-3 text-decoration-none group-recent">
                                <div class="rounded-3 overflow-hidden border size-80">
                                    <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$recent_post->image) }}" class="w-100 h-100 object-fit-cover transition-500 hover-zoom" alt="{{ $recent_post->title }}">
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h4 class="h6 fw-bold text-dark mb-1 line-clamp-2 recent-title-hover">
                                        {{ $recent_post->title }}
                                    </h4>
                                    <p class="text-muted small fw-bold text-uppercase mb-0 fs-10">{{ $recent_post->created_at->format('M d, Y') }}</p>
                                </div>
                            </a>
                        </div>
                        @endforeach

                        <div class="mt-5">
                            <h3 class="h5 fw-black text-dark mb-4 d-flex align-items-center gap-2">
                                Categories <span class="rounded-pill tag-indicator"></span>
                            </h3>
                            <ul class="list-unstyled vstack gap-2">
                                @foreach($post_categopries as $post_category)
                                <li>
                                    <a href="{{ route('category', $post_category->slug) }}" class="d-flex justify-content-between text-decoration-none text-dark py-2 border-bottom category-link">
                                        <span>{{ $post_category->name }}</span>
                                        <span class="badge rounded-pill bg-light text-dark">
                                            {{ $post_category->posts_count }}
                                        </span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mt-5">
                            <h3 class="h5 fw-black text-dark mb-4 d-flex align-items-center gap-2">
                                Archives <span class="rounded-pill tag-indicator"></span>
                            </h3>
                            <ul class="list-unstyled vstack gap-2">
                                @php
                                // Show months from posts table, do not duplicate and sort by latest month first
                                $all_months = App\Models\Post::selectRaw('DATE_FORMAT(created_at, "%M %Y") as month, COUNT(*) as post_count')
                                    ->groupBy('month')
                                    ->orderByRaw('MIN(created_at) DESC')
                                    ->get();
                                @endphp
                                @foreach($all_months as $month)
                                <li>
                                    <a href="{{ route('archive', ['month' => $month->month]) }}" class="d-flex justify-content-between text-decoration-none text-dark py-2 border-bottom category-link">
                                        <span><i class="fa-regular fa-calendar-days me-2 text-primary-orange"></i>{{ $month->month }}</span>
                                        <span class="badge rounded-pill bg-light text-dark">{{ $month->post_count }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mt-5">
                            <h3 class="h5 fw-black text-dark mb-4 d-flex align-items-center gap-2">
                                Popular Tags <span class="rounded-pill tag-indicator"></span>
                            </h3>
                            <div class="d-flex flex-wrap gap-2">
                                @php
                                // Show tags from posts table, assuming tags are comma-separated, and do not duplicate and sort alphabetically
                                $all_tags = App\Models\Post::pluck('tags')->toArray();
                                $tags_array = [];
                                foreach($all_tags as $tags) {
                                    $tags_split = explode(',', $tags);
                                    foreach($tags_split as $tag) {
                                        $trimmed_tag = trim($tag);
                                        if($trimmed_tag && !in_array($trimmed_tag, $tags_array)) {
                                            $tags_array[] = $trimmed_tag;
                                        }
                                    }
                                }
                                @endphp
                                @foreach($tags_array as $tag)
                                <a href="{{ route('tag', $tag) }}" class="btn btn-primary btn-tag">{{ $tag }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
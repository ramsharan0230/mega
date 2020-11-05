@extends('front.layouts.app')

@section('content')

<section class="breadcrumb" style="background-image: url(/images/breadcrumb.png);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_inner text-center">
                    <div class="breadcrumb_inner_item" data-sal="fade" data-sal-duration="1000" data-sal-delay="600"
                        data-sal-easing="ease-out-bounce">
                        <h2>Blog Inner</h2>
                        <p>Home<span>/</span>Blog Inner</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="blog_area single-post-area section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 posts-list">
                <div class="single-post">
                    <div class="feature-img" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="600"
                        data-sal-easing="ease-out-bounce">
                        <img class="img-fluid" src="/images/main/{{ $detail->image }}" alt="">
                    </div>
                    <div class="blog_details">
                        <h2 data-sal="slide-up" data-sal-duration="1000" data-sal-delay="600"
                            data-sal-easing="ease-out-bounce">{{ $detail->title }}</h2>
                        <p data-sal="slide-up" data-sal-duration="1000" data-sal-delay="700"
                            data-sal-easing="ease-out-bounce">
                            <i class="fa fa-clock-o"></i>
                            {{ \Carbon\Carbon::parse($detail->created_at)->format("d M, Y") }}
                            <span class="ml-2">
                                <i class="fa fa-user"></i>
                            </span>
                            {{ $detail->author }}
                        </p>
                        <div class="excert" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="800"
                            data-sal-easing="ease-out-bounce">
                            {!! $detail->description !!}

                        </div>
                    </div>
                </div>
            </div>
            @if($relatedBlogs->count())
            <div class="col-lg-4">
                <div class="blog_right_sidebar" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="700"
                    data-sal-easing="ease-out-bounce">
                    <aside class="single_sidebar_widget popular_post_widget">
                        <h3 class="widget_title" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="600"
                            data-sal-easing="ease-out-bounce">Recent Post</h3>
                        @php($i=700)
                        @foreach($relatedBlogs as $rdetail)
                        <div class="media post_item" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="700"
                            data-sal-easing="ease-out-bounce">
                            <div class="sidebar__blog__imageWrapper">
                                <img src="/images/main/{{ $rdetail->image }}" alt="post">
                            </div>
                            <div class="media-body">
                                <a href="{{ route('blogInner', $rdetail->slug) }}">
                                    <h3>{{ $rdetail->title }}</h3>
                                </a>
                                <p> {{ \Carbon\Carbon::parse($detail->created_at)->format("d M, Y") }}</p>
                            </div>
                        </div>
                        @php($i += 100)
                        @endforeach
                    </aside>

                </div>
            </div>
            @endif
        </div>
    </div>
</section>

@endsection
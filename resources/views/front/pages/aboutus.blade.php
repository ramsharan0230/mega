@extends('front.layouts.app')

@section('content')
<section class="breadcrumb" style="background-image: url(/images/breadcrumb.png);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_inner text-center">
                    <div class="breadcrumb_inner_item" data-sal="fade" data-sal-duration="1000" data-sal-delay="600"
                        data-sal-easing="ease-out-bounce">
                        <h2>{{ $detail->title }}</h2>
                        <p>Home<span>/</span>{{ $detail->title }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="blog_area section_padding innerPageSection">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="bg-white innerPageSection__body" data-sal="slide-up" data-sal-duration="1000"
                    data-sal-delay="700" data-sal-easing="ease-out-bounce">
                    <h2 data-sal="slide-up" data-sal-duration="1000" data-sal-delay="600"
                        data-sal-easing="ease-out-bounce">{{ $detail->title }}</h2>
                    <div data-sal="slide-up" data-sal-duration="1000" data-sal-delay="700"
                        data-sal-easing="ease-out-bounce">
                        {!! $detail->description !!}
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
@extends('front.layouts.app')

@section('content')

<section class="breadcrumb" style="background-image: url(/images/breadcrumb.png);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_inner text-center">
                    <div class="breadcrumb_inner_item" data-sal="fade" data-sal-duration="1000" data-sal-delay="600"
                        data-sal-easing="ease-out-bounce">
                        <h2>Our Blog</h2>
                        <p>Home<span>/</span>Blog</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="blog_area section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="blog_left_sidebar">
                    @php($i=600)
                    @foreach($details as $key => $detail)
                    <article class="blog_item">
                        <div class="blog_item_img" data-sal="slide-up" data-sal-duration="1000"
                            data-sal-delay="{{ $i }}" data-sal-easing="ease-out-bounce">
                            <img class="card-img rounded-0" src="/images/main/{{ $detail->image }}" alt="">
                            <a href="#" class="blog_item_date">
                                <h3>{{ \Carbon\Carbon::parse($detail->created_at)->format("d") }}</h3>
                                <p>{{ \Carbon\Carbon::parse($detail->created_at)->format("M") }}</p>
                            </a>
                        </div>
                        <div class="blog_details" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="700"
                            data-sal-easing="ease-out-bounce">
                            <a class="d-inline-block" href="{{ route('blogInner', $detail->slug) }}">
                                <h2>{{ $detail->title }}</h2>
                            </a>
                            <p>{{ $detail->short_description }}</p>
                            <a href="{{ route('blogInner', $detail->slug) }}" class="btn_1">Read more</a>
                        </div>
                    </article>
                    @php($i += 100)
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>


@endsection
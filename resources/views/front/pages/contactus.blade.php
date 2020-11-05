@extends('front.layouts.app')

@section('content')
<section class="breadcrumb" style="background-image: url(/images/breadcrumb.png);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_inner text-center">
                    <div class="breadcrumb_inner_item" data-sal="fade" data-sal-duration="1000" data-sal-delay="600"
                        data-sal-easing="ease-out-bounce">
                        <h2>Contact Us</h2>
                        <p>Home<span>/</span>Contact us</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-section section_padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="contact-title" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="600"
                    data-sal-easing="ease-out-bounce">Get in Touch</h2>
            </div>
            <div class="col-lg-8">
                @if(session('message'))
                <div class="alert alert-info alert-dismissible" id="successMessage">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{session('message')}}
                </div>
                @endif
                <form class="form-contact contact_form" action="{{ route('enquirySave') }}" method="post"
                    id="contactForm">
                    @csrf
                    <div class="row">
                        <div class="col-12" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="700"
                            data-sal-easing="ease-out-bounce">
                            <div class="form-group">
                                <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9"
                                    placeholder="Enter Message" required></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="800"
                            data-sal-easing="ease-out-bounce">
                            <div class="form-group">
                                <input class="form-control" name="name" id="name" type="text"
                                    placeholder="Enter your name" required>
                            </div>
                        </div>
                        <div class="col-sm-6" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="800"
                            data-sal-easing="ease-out-bounce">
                            <div class="form-group">
                                <input class="form-control" name="email" id="email" type="email"
                                    placeholder="Enter email address" required>
                            </div>
                        </div>
                        <div class="col-12" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="900"
                            data-sal-easing="ease-out-bounce">
                            <div class="form-group">
                                <input class="form-control" name="subject" id="subject" type="text"
                                    placeholder="Enter Subject">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="900"
                        data-sal-easing="ease-out-bounce">
                        <button type="submit" class="button button-contactForm btn_1">Send Message</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-4" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="700"
                data-sal-easing="ease-out-bounce">
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-home"></i></span>
                    <div class="media-body">
                        <h3>{{ $dashboard_composer->address }}</h3>

                    </div>
                </div>
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                    <div class="media-body">
                        <h3>{{ $dashboard_composer->mobile }}</h3>
                    </div>
                </div>
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-email"></i></span>
                    <div class="media-body">
                        <h3><a href="mailto:{{ $dashboard_composer->email }}"
                                class="__cf_email__">{{ $dashboard_composer->email }}</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="map-wrapper w-100" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="600"
    data-sal-easing="ease-out-bounce">
    <iframe class="w-100" src="{{ $dashboard_composer->googlemap }}" height="450" frameborder="0" style="border:0;"
        allowfullscreen=""></iframe>
</div>


@endsection
@extends('front.exhibitor.exhibitorMaster')

@section('page_title', 'Exhibitor Detail | '.$detail->title)

@section('content')
<section class="detail-page pt-4" style="margin-top: 40px;">
   <div class="container">

      <div class="row detail-top-section">
         <div class="col-lg-5 col-md-12 col-12">
            <div class="detail-image-side">
               <img class="detail-main-image" src="/images/main/{{$detail->image}}" alt="image">
               <div class="detail-image-content">
                  <ul>
                     <li><a href="#instituton">Institution We Represent</a></li>
                     <li><a href="#courses">Courses & Fees</a></li>
                     <li><a href="#scholarship">Available Scholarships</a></li>
                  </ul>
                  <span class="stall-logo"><img src="/images/main/{{$detail->logo}}" alt="logo"></span>
               </div>
            </div>
         </div>
         <div class="col-lg-7 col-md-12 col-12">
            <div class="detail-page-content-side">
               <div class="detail-main-content">
                  <h1>Welcome to<span>{{$detail->title}}</span></h1>
                  <div>
                     {!! $detail->introduction !!}
                  </div>
               </div>
               <div class="chat-section">
                  <h2>Chat Now:</h2>
                  <p>(you can chat on any of the below platform)</p>
                  <ul class="chat-wrapper">
                     {{-- <li><a target="_blank" href="{{$detail->email_link}}"><span><img
                           src="/assets/front/img/chat-now.svg" alt="image"></span>Chat Now</a>
                     </li> --}}
                     <li><a target="_blank" href="{{$detail->viber}}"><span><img src="/assets/front/img/viber.svg"
                                 alt="image"></span>Chat on Viber</a>
                     </li>
                     <li><a target="_blank" href="{{$detail->messenger}}"><span><img
                                 src="/assets/front/img/messenger.svg" alt="image"></span>Chat on
                           Messenger</a></li>
                     <li><a target="_blank" href="{{$detail->whatsapp}}"><span><img src="/assets/front/img/whatsapp.svg"
                                 alt="image"></span>Chat on
                           Whatsapp</a></li>
                  </ul>
               </div>
               {{-- <div class="chat-section counseling-section">
                  <h2>VIDEO COUNSELING:</h2>
                  <p>(check the available time with counselor & book the appointment)</p>
                  <form action="" class="counseling-form">
                     <select class="selectpicker" name="" id="">
                        <option selected value=""><span class="date">Date</span></option>
                        <option value=""><span class="date">jan 20,2020</span></option>
                        <option value=""><span class="date">feb 16,2020</span></option>
                        <option value=""><span class="date">mar 02,2020</span></option>
                        <option value=""><span class="date">apr 18,2020</span></option>
                     </select>

                     <select class="selectpicker" name="" id="">
                        <option selected value="">Time</option>
                        <option value="">9:30</option>
                        <option value="">10:00</option>
                        <option value="">05:00</option>
                        <option value="">12:05</option>
                     </select>

                     <button class="btn confirm_btn">Confirm</button>
                  </form>
               </div> --}}
            </div>
         </div>
      </div>
   </div>
   <div class="know-more-section all-sec-padding">
      <div class="container">
         <div class="know-more-wrapper">
            <h2>KNOW MORE ABOUT US:</h2>
            <div>
               {!! $detail->about !!}
            </div>
            <div class="service-text">
               <h3>Our Services:</h3>
               {!! $detail->services !!}

            </div>
         </div>
         <div class="scholarship-wrapper" id="scholarship">
            <h3>Available Scholarships:</h3>
            <div class="row">
               @foreach($detail->scholarships as $scholarship)
               <div class="col-lg-4 col-md-6 col-12">
                  <div class="scholarship-col">
                     <h4>{{$scholarship->percent}}% SCHOLARSHIP</h4>
                     <a href="#" class="scholar-image">
                        <img src="/images/main/{{$scholarship->logo}}" alt="{{$scholarship->title}}">
                     </a>
                  </div>
               </div>
               @endforeach

            </div>
         </div>
         <div id="instituton" class="scholarship-wrapper institution-wrapper">
            <h3>Institutions We Represent</h3>
            <div class="row">
               @foreach($detail->institutions as $institution)
               <div class="col-lg-3 col-md-6 col-12">
                  <div class="scholarship-col institution-col">
                     <a href="#" class="scholar-image">
                        <img src="/images/main/{{$institution->logo}}" alt="{{$institution->title}}">
                     </a>
                  </div>
               </div>
               @endforeach
            </div>
            <div id="courses" class="service-text fee-section">
               <h3>Courses & Fees:</h3>
               <div>
                  {!! $detail->courses_fees !!}
               </div>

            </div>
            @if($detail->document)
            <a target="_blank" href="/document/{{$detail->download}}">
               <button class="download-btn">
                  DOWNLOAD OUR BROCHURE <img src="/assets/front/img/down-arrow.svg" alt="icon">
               </button>
            </a>
            @endif
         </div>
      </div>
   </div>
</section>

@endsection
@extends('front.layouts.app')

@push('styles')
<link rel="stylesheet" type="text/css" href="/assets/front/css/inner.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/assets/admin/css/inner__page.css">
<style type="text/css">
   input#datepicker,
   select.select__time {
      width: 120px;
      height: 45px;
      line-height: 45px;
      border: 1px solid #C5CFD3;
      border-radius: 10px;
      display: inline-block;
      text-align: center;
      margin-right: 15px;
   }

   .chat__now {
      width: 100%;
      height: 90vh;
      border: 0;
   }

   .exampleModal.modal-content {
      background: transparent;
      border: 0;
   }

   .message-wrapper,
   .loading__skeleton {
      max-height: 50vh;
   }

   #chat__box {
      position: fixed;
      max-width: 500px;
      width: 100%;
      bottom: 0;
      right: 0;
      /*height: 40%;*/
      transform: translateX(100%);
      transition: 0.5s all;
      background: #fff;
      border-radius: 5px;
   }

   .chat-wrapper li a {
      cursor: pointer;
   }

   #messages {
      background: #fff;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, .1), 0 4px 6px -2px rgba(0, 0, 0, .05) !important;
      position: relative;
   }

   .toggleIcon {
      width: 30px;
      height: 30px;
      /* position: absolute; */
      /* border: 2px solid; */
      text-align: center;
      line-height: 30px;
      border-radius: 50%;
      left: 16px;
      top: -6px;
      z-index: 999;
      color: #cacaca;
      font-size: 20px;
      cursor: pointer;
   }

   .transform0 {
      transform: translateX(0%) !important;
   }


   .toggler-wrapper {
      padding: 10px;
      background: #fff;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      border: 1px solid #dfdfdf;
      border-top-right-radius: 5px;
      border-top-left-radius: 5px;
      display: flex;
      justify-content: flex-end;
      border-bottom: none;
   }

   @media(min-width: 992px) {
      #chat__box {
         width: 40%;
         bottom: 0;
         top: auto;
      }
   }
</style>
@endpush

@section('content')
<section class="detail-page">
   <a href="{{route('allExhibitionHalls')}}" id="back__button">Back To Exhibitor Hall</a>
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
                     <li><a href="#branches">Available Branches</a></li>
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

               @include('admin.layouts._partials.messages.info')

               @if(session('refer'))
               <div class="alert alert-info alert-dismissible success">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  {{session('refer')}}
               </div>
               @endif


               @if (count($errors) > 0)
               <div class="alert alert-danger">
                  <ul>
                     @foreach($errors->all() as $error)
                     <li>{{$error}}</li>
                     @endforeach
                  </ul>
               </div>
               @endif

               <div class="chat-section">
                  <h2>Chat Now:</h2>
                  <p>(you can chat on any of the below platform)</p>
                  <ul class="chat-wrapper">
                     <li>
                        <a id="instantChat">
                           <span><img src="/assets/front/img/chat-now.svg" alt="image"></span>
                           Chat Now
                        </a>
                     </li>
                     <li><a target="_blank" href="https://msng.link/o/?{{$detail->viber}}=vi"><span><img
                                 src="/assets/front/img/viber.svg" alt="image"></span>Chat on Viber</a>
                     </li>
                     <li><a target="_blank" href="{{$detail->messenger}}"><span><img
                                 src="/assets/front/img/messenger.svg" alt="image"></span>Chat on
                           Messenger</a></li>
                     <li><a target="_blank" href="https://api.whatsapp.com/send?phone={{$detail->whatsapp}}"><span><img
                                 src="/assets/front/img/whatsapp.svg" alt="image"></span>Chat on
                           Whatsapp</a></li>
                  </ul>


               </div>
               <div class="chat-section counseling-section">
                  <h2>VIDEO COUNSELING:</h2>
                  <p>(check the available time with counselor & book the appointment)</p>

                  <form action="{{route('video__booking')}}" class="counseling-form" method="POST">
                     @csrf
                     <input type="hidden" value="{{$detail->id}}" name="exhibitor_id">
                     <input type="text" class="video__date" required id="datepicker" placeholder="Date" name="date"
                        autocomplete="off">
                     <div class="here">
                        <select class="select__time" name="datetime_id" id="" required>
                           <option value>Time</option>
                        </select>
                     </div>

                     <button class="btn confirm_btn">Confirm</button>
                  </form>
               </div>

               <div class="chat-section counseling-section">
                  <h2 class="mb-2">Refer a friend:</h2>
                  <p>[ Genuine referral providers will get attractive gifts. ] </p>
               </div>
                
               <form method="POST" action="{{route('addRefer')}}" class="counseling-form">
                  @csrf
                  <input type="hidden" value="{{$detail->id}}" name="exhibitor_id">
                  <input type="hidden" value="{{auth()->user()->id}}" name="student_id">
                  <input type="hidden" value="{{request()->url()}}" name="exhibitor_url">
                  <input type="hidden" value="{{$detail->title}}" name="exhibitor_name">

                  <select name="refer__option" id="refer__option" class="form-control mr-3">
                     <option value>--Please select one--</option>
                     <option value="SMS">SMS</option>
                     <option value="Email" selected>Email</option>
                  </select>
                  <input type="email" class="video__date form-control" id="refer__input" name="refer_email"
                     autocomplete="off" placeholder="Enter Email">
                  <button class="btn confirm_btn ml-3">Refer</button>
               </form>
            </div>

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
                     <span class="scholar-image">
                        <img src="/images/main/{{$scholarship->logo}}" alt="{{$scholarship->title}}">
                     </span>
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
                     <span class="scholar-image">
                        <img src="/images/main/{{$institution->logo}}" alt="{{$institution->title}}">
                     </span>
                  </div>
               </div>
               @endforeach
            </div>
            <div class="scholarship-wrapper" id="branches">
               <h3>Available Branches:</h3>
               <div class="row">
                  @foreach($detail->branches as $branch)
                  <div class="col-lg-4 col-md-6 col-12">
                     <div class="scholarship-col">
                        <h4 class="text-capitalize">{{$branch->district}}</h4>
                        <span class="scholar-image">
                           {{$branch->address}}
                        </span>
                     </div>
                  </div>
                  @endforeach

               </div>
            </div>
            <div id="courses" class="service-text fee-section">
               <h3>Courses & Fees:</h3>
               <div>
                  {!! $detail->courses_fees !!}
               </div>

            </div>
            @if($detail->download)
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

<section id="chat__box">

   <div class="toggler-wrapper">
      <div class="toggleIcon"><i class="fa fa-times" aria-hidden="true"></i></div>
   </div>

   <div id="messages">

   </div>
</section>

{{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content exampleModal">
         <div class="modal-body">
            <div id="messages">

            </div>
         </div>
      </div>
   </div>
</div> --}}
@endsection

@push('scripts')

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script>
   $( function() {
      $( "#datepicker" ).datepicker({
         minDate: new Date(),
         dateFormat: "yy-mm-dd",
      });

      $('#instantChat').click(function() {
        $('#chat__box').addClass('transform0');
      });

      $('.toggleIcon').click(function() {
         $('#chat__box').removeClass('transform0');
      });

      $('#refer__option').change(function(e) {
         if(e.target.value == 'SMS') {
            $('#refer__input').attr('placeholder', 'Enter mobile number').attr('type', 'number')
         }
         if(e.target.value == 'Email') {
            $('#refer__input').attr('placeholder', 'Enter Email').attr('type', 'email')
         }
      })

   });
</script>
<script>
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });
   const exhibitor_id = '{{$detail->id}}';

   $('document').ready(function() {
      $('.message').fadeOut(3000);
     $('.video__date').change(function(e) {
         const date = e.target.value;
         const get__time_by_date = `{{route('get__time_by_date')}}`;
         $.ajax({
            url: get__time_by_date,
            type:"get",
            data: {
               date: date,
               exhibitor_id: exhibitor_id,
            },
            success: function(result){
               $('.here').html(result.html);
            }
         });
     });
  });

</script>

<script>
   var receiver_id = "{{$detail->exhibitor_user->id}}";
   var my_id = "{{ auth()->user()->id }}";

   const loadingSkeleton = (
               `<div class="message-wrapper">
                  <ul class="messages">
                     <li class="message clearfix">
                        <div class="sent" style="height: 100px">
                           <p>Loading...</p>
                           <p class="date"></p>
                        </div>
                     </li>
                     <li class="message clearfix">
                        <div class="received" style="height: 100px">
                           <p>Loading...</p>
                           <p class="date"></p>
                        </div>
                     </li>
                  </ul>
               </div>`);

   // Enable pusher logging - don't include this in production
   $(document).ready(function() {
         Pusher.logToConsole = true;

         var pusher = new Pusher('b3f8c29bfb5472f6bf23', {
            cluster: 'ap2'
         });

         var channel = pusher.subscribe('my-channel');
         channel.bind('my-event', function (data) {
            // alert(JSON.stringify(data));
            if (my_id == data.sender_id) {
                $('#instantChat').click();
            } else if (my_id == data.receiver_id) {
                if (receiver_id == data.sender_id) {
                    // if receiver is selected, reload the selected user ...
                    $('#instantChat').click();
                } else {
                    // if receiver is not seleted, add notification for that user
                    var pending = parseInt($('#' + data.sender_id).find('.pending').html());

                    if (pending) {
                        $('#' + data.sender_id).find('.pending').html(pending + 1);
                    } else {
                        $('#' + data.sender_id).append('<span class="pending">1</span>');
                    }
                }
            }
        });

         receiver_id = "{{$detail->exhibitor_user->id}}";
         var url = "{{route('front.getMessage', ':receiver_id')}}";
         url = url.replace(':receiver_id', receiver_id);
         $.ajax({
            type: "get",
            url: url, // need to create this route
            data: "",
            cache: false,
            success: function (data) {
               $('#messages').html(data);
               scrollToBottomFunc();
            }
         });

         $('#instantChat').click(function() {
            receiver_id = "{{$detail->exhibitor_user->id}}";
            var url = "{{route('front.getMessage', ':receiver_id')}}";
            url = url.replace(':receiver_id', receiver_id);
            $.ajax({
               type: "get",
               url: url, // need to create this route
               data: "",
               cache: false,
               success: function (data) {
                  $('#messages').html(data);
                  scrollToBottomFunc();
               }
            });
         })

        $(document).on('keyup', '.input-text input', function (e) {
            var message = $(this).val();

            // check if enter key is pressed and message is not null also receiver is selected
            if (e.keyCode == 13 && message != '' && receiver_id != '') {
                $(this).val(''); // while pressed enter text box will be empty

                var datastr = "receiver_id=" + receiver_id + "&message=" + message;
                $.ajax({
                    type: "post",
                    url: "{{route('front.sendMessage')}}", // need to create this post route
                    data: datastr,
                    cache: false,
                    success: function (data) {
                    },
                    error: function (jqXHR, status, err) {
                    },
                    complete: function () {
                        scrollToBottomFunc();
                    }
                })
            }
        });


   });

   // make a function to scroll down auto
   function scrollToBottomFunc() {
      $('.message-wrapper').animate({
         scrollTop: $('.message-wrapper').get(0).scrollHeight
      }, 50);
   }

</script>

@endpush
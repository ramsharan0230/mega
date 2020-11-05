@extends('front.exhibitor.exhibitorMaster')
@section('page_title', 'All Chats')

@push('styles')
<link rel="stylesheet" href="/assets/admin/css/inner__page.css">

<style>
   .content-wrapper {
      min-height: auto;
      padding: 0 15px 10px 15px;
   }
</style>

@endpush

@section('content')
<div class="page-content fade-in-up">

   <div class="row">
      <div class="col-4 px-0">

         <div class="user-wrapper">
            <h4 class="py-3 px-3 inner__title">Chats</h4>

            <ul class="users">
               @if($allStudents->isNotEmpty())
               @foreach($allStudents as $user)
               <li class="user" id="{{ $user->student->id }}" data-user_id="{{ $user->student->id }}">
                  <div class="media">
                     <div class="media-body">
                        <p class="name">{{ $user->student->name }}</p>
                     </div>
                  </div>
               </li>
               @endforeach
               @else
               <span class="ml-2">Students not available at the moment</span>
               @endif
            </ul>
         </div>
      </div>

      <div class="col-8 px-0" id="messages">

      </div>
   </div>
</div>
@endsection

@push('scripts')

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script type="text/javascript">
   var receiver_id = '';

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

   var my_id = "{{ auth()->user()->id }}";
   // Enable pusher logging - don't include this in production

   $(document).ready(function() {
      // ajax setup form csrf token
         $.ajaxSetup({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });

         Pusher.logToConsole = true;

         var pusher = new Pusher('b3f8c29bfb5472f6bf23', {
         cluster: 'ap2'
         });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function (data) {
            // alert(JSON.stringify(data));
            if (my_id == data.sender_id) {
                $('#' + data.receiver_id).click();
            } else if (my_id == data.receiver_id) {
                if (receiver_id == data.sender_id) {
                    // if receiver is selected, reload the selected user ...
                    $('#' + data.sender_id).click();
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

        $('.user').click(function () {
            $('.user').removeClass('active');
            $(this).addClass('active');
            $(this).find('.pending').remove();

            receiver_id = $(this).attr('id');
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
        });
        $(document).ready(function() {
            $('.user:first-child').addClass('active');
               $(this).removeClass('active');
               $(this).find('.pending').remove();

               receiver_id = $('.user:first-child').attr('id');
               var url = "{{route('front.getMessage', ':receiver_id')}}";
               url = url.replace(':receiver_id', receiver_id);
               $.ajax({
                  type: "get",
                  url: url,
                  data: "",
                  cache: false,
                  success: function (data) {
                     $('#messages').html(data);
                     scrollToBottomFunc();
                  }
            });
        });

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

{{--
<ul class="users">
   @foreach($allStudents as $user)
   <li class="user" id="{{ $user->student->id }}" data-user_id="{{ $user->student->id }}">
<div class="media">
   <div class="media-body">
      <p class="name">{{ $user->student->name }}</p>
   </div>
</div>
</li>
@endforeach
</ul> --}}
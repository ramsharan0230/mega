<div class="message-wrapper">
   <ul class="messages">
      @if($messages->isNotEmpty())
      @foreach($messages as $message)
      <li class="message clearfix">
         <div class="{{ ($message->sender_id == auth()->user()->id ) ? 'sent' : 'received' }}">
            @if($message->message)<p>{{ $message->message }}</p>@endif

            @if($message->file_attachment)
            <p>
               <a target="_blank" href="/document/{{$message->file_attachment}}">
                  {{$message->file_attachment}}
               </a>
            </p>
            @endif
            <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</p>
         </div>
      </li>
      @endforeach
      @else
      <p class="text-center py-5">No Messages</p>
      @endif
   </ul>
</div>
@if(auth()->user() && auth()->user()->role == 'customer' || (auth()->user() && auth()->user()->role == 'exhibitor') &&
$messages->isNotEmpty())
<div class="input-text position-relative">
   <div class="align-items-center d-none display-flex px-3" id="message__box">
      <input type="file" name="file_attachment" id="file_attachment">
      <button class="file_save" id="file__save">Submit</button>
   </div>
   <div id="paper_click" class="align-items-center">
      <input type="text" name="message" placeholder="Type Your Text ..." class="submit ml-1">
      <i class="fa fa-paperclip px-2" aria-hidden="true" id="file__pop"></i>
      @if(auth()->user() && auth()->user()->role == 'exhibitor')
      <a href="{{route('exportPDF', $receiverId)}}" class="btn-sm btn-primary">Export Chat</a>
      @endif
   </div>

</div>
@endif

<script>
   $('#file__pop').click(function() {
      $('#message__box').toggleClass('d-none');
   })

   $('#file__save').click(function(e) {

      if($('#file_attachment')[0].files.length == 0 ) {
         return;
      }

      var files = $('#file_attachment')[0].files[0];
      var formData = new FormData();
      formData.append('file_attachment', files);
      formData.append('receiver_id', "{{$receiverId}}")
      $.ajax({
         type: "post",
         url: "{{route('front.sendMessage')}}", // need to create this post route
         dataType    : 'text',           // what to expect back from the PHP script, if anything
         cache       : false,
         contentType : false,
         processData : false,
         data        : formData,
      })
   });
</script>

{{-- <ul class="messages">
   @foreach($messages as $message)
   <li class="message clearfix">
      <div class="{{ ($message->sender_id == auth()->user()->id ) ? 'sent' : 'received' }}">
<p>{{ $message->message }}</p>
<p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</p>
</div>
</li>
@endforeach

@if(auth()->user() && auth()->user()->role == 'customer' )

</ul> --}}
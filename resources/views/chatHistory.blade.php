<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
   <title>Chat History</title>
   <style>
      @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap");

      .message-wrapper {
         font-family: "Roboto", sans-serif;
      }

      .clearfix::after {
         display: block;
         clear: both;
         content: "";
      }

      ul {
         margin: 0;
         padding: 0;
      }

      li {
         list-style: none;
      }

      .position-relative {
         position: relative;
      }

      .user {
         cursor: pointer;
         padding: 5px 15px;
         position: relative;
         transition: all 0.6s;
      }

      .user:hover {
         background: #465d74;
      }

      .user:last-child {
         margin-bottom: 0;
      }

      .pending {
         position: absolute;
         left: 13px;
         top: 9px;
         background: #b600ff;
         margin: 0;
         border-radius: 50%;
         width: 18px;
         height: 18px;
         line-height: 18px;
         padding-left: 5px;
         font-size: 12px;
      }

      .media-left {
         margin: 0 10px;
      }

      .media-left img {
         width: 64px;
         border-radius: 64px;
      }

      .media-body p {
         margin: 6px 0;
         font-size: 0.9rem;
      }

      .message-wrapper,
      .loading__skeleton {
         padding: 10px;
         height: 400px;
         max-width: 900px;
         /* text-align: revert; */
         margin: 0 auto;
      }

      .messages .message {
         margin-bottom: 15px;
      }

      .messages .message:last-child {
         margin-bottom: 0;
      }

      .received,
      .sent {
         padding: 5px 20px;
         border-radius: 5px;
         width: 200px;
      }

      .received {
         display: inline-block;
         border-top-left-radius: 0;
         position: relative;
         background: #ddd;
      }

      .sent {
         background: #d3d3d4;
         float: right;
         text-align: right;
         display: inline-block;
         color: #333;
         border-top-right-radius: 0;
         position: relative;
      }

      .received p,
      .received p a,
      .sent p,
      .sent p a {
         font-weight: 500;
         color: #333;
      }

      .message p {
         margin: 0px;
         font-size: 14px;
         font-weight: 500;
      }

      .date {
         color: #a9a9a9;
         font-size: 11px !important;
      }

      .active {
         background: #465d74;
      }

      .inner__title {
         font-size: 0.9rem;
      }

      /* media Query */

      @media (min-width: 992px) {
         .user {
            padding: 10px 20px;
         }

         .media-body p {
            font-size: 1rem;
         }

         .inner__title {
            font-size: 1.4rem;
         }

         .display-flex {
            display: flex;
         }

      }

      @media (max-width: 480px) {
         .date {
            font-size: 11px !important;
         }
      }

      .message-wrapper {
         max-width: 900px;
      }

      .mb-sm {
         margin-bottom: 12px;
      }
   </style>
</head>

<body>
   <div class="message-wrapper">
      <ul class="messages">
         <li class="received mb-sm">{{$receiver->name}}</li>
         <li class="sent">{{auth()->user()->name ?? 'Sender'}}</li>
         @if($messages->isNotEmpty())
         @foreach($messages as $message)
         <li class="message clearfix">
            <div class="{{ ($message->sender_id == auth()->user()->id ) ? 'sent' : 'received' }}">
               @if($message->message)
               <p>{{ $message->message }}</p>
               @endif
               @if($message->file_attachment)
               <p>
                  <a target="_blank" href="{{asset('document/'.$message->file_attachment)}}">
                     {{$message->file_attachment}}
                  </a>
               </p>
               @endif
               <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</p>
            </div>
         </li>
         @endforeach

         @endif
      </ul>
   </div>
</body>

</html>
@extends('pages.layout')
@section('content')
    <div id="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-left">Mesaj</h1>
                </div>
            </div>
        </div>
    </div>
    {{--Chat--}}
    @php
      if (isset($one_message->receiver_id)) {
        $qarshidaki = $one_message->receiver_id;
      }else if(isset($sender))
      {
        $qarshidaki = $sender;
      }
    @endphp
    <div id="chat" class="dsp_none">
        <div class="chat-header">
            <h5 class="chat-header-name">Loading...</h5>
        </div>
        <div class="chat-body">
            <ul class="list-group chat-body-message list-unstyled">
              @foreach ($chats as $chat)
                @if ($chat->sender_id == Auth::user()->id && $chat->receiver_id == $qarshidaki)
                  <li class="pull-right">
                    <p class="chat-message-content">{{$chat->message}}</p>
                    <img src="/image/{{$chat->avatar}}" class="chat-message-img" alt="user-image">
                  </li>
                  <div class="clearfix"></div>
                @elseif ($chat->sender_id == $qarshidaki && $chat->receiver_id == Auth::user()->id)
                  <li class="pull-left">
                    <img src="/image/{{$chat->avatar}}" class="chat-message-img" alt="user-image">
                    <p class="chat-message-content">{{$chat->message}}</p>
                  </li>
                  <div class="clearfix"></div>
                @endif
              @endforeach
            </ul>
        </div>

        <div class="chat-footer">
            <form id="notification_chat" method="post">
                <div class="col-lg-10 padding0">
                    <input type="text" class="form-control chat-footer-input" name="" placeholder="Mesajınız">
                </div>

                <div class="col-lg-2 padding0">
                    <button type="submit" name="button" class="btn chat-footer-btn"><i class="fa fa-paper-plane-o"></i></button>
                </div>
            </form>
        </div>
    </div>
    @php
        if (Auth::user()){
            $id = Auth::user()->id;
        }else{
            $id = 0;
        }
    @endphp

@endsection
@section('script')
  {{-- <script src="{{url('/js/vendor/jquery-2.2.4.min.js')}}"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.js"></script> --}}
  <script type="text/javascript">

  </script>
@endsection

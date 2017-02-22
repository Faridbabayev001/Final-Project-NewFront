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
    <div id="chat">
        <div class="chat-header">
            <h5 class="header-name">x</h5>
        </div>
        <div class="chat-body">
            <ul class="list-group body-message list-unstyled">
            </ul>
        </div>

        <div class="chat-footer">
            <form id="notification_chat" action="" method="post">
                <div class="col-lg-10 padding0">
                    <input type="text" class="form-control footer-input" name="" placeholder="Mesajınız">
                </div>

                <div class="col-lg-2 padding0">
                    <button type="submit" name="button" class="btn footer-btn"><i class="fa fa-paper-plane-o"></i></button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{url('/js/vendor/jquery-2.2.4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.js"></script>
    <script type="text/javascript">
        var socket = io(':3000');
        var date = new Date();
        var data_chat = {
            sender_id :{{Auth::user()->id}},
            receiver_id: {{$chat->receiver_id}},
            message :  "",
            seen:0,
            created_at: moment().format("YYYY-MM-DD HH:mm:ss"),
            updated_at: moment().format("YYYY-MM-DD HH:mm:ss")
        };
        socket.emit('data',data_chat);
        $('#notification_chat').submit(function () {
            data_chat.message = $('.footer-input').val();
            socket.emit('send_message', data_chat);
            $('.footer-input').val("");
//            $('.chat-body').text('');
            socket.on('all_data',function (allData) {
                $('.chat-body ul').text('');
                $.each(allData,function (key,value) {
                    if (value.sender_id == {{Auth::user()->id}}){
                        $('.body-message').append(
                            '<li class="pull-right">' +
                            '<p class="message-content">'+String(value.message).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')+'</p>'+
                            '<img src="/image/'+value.avatar+'" class="message-img" alt="user-image">'+
                            '</li>'+
                            '<div class="clearfix"></div>'
                        );
                    }else if (value.sender_id == {{$chat->receiver_id}} && value.receiver_id == {{Auth::user()->id}}){
                        $('.chat-body ul').append(
                            '<li class="pull-left">' +
                            '<img src="/image/'+value.avatar+'" class="message-img" alt="user-image">'+
                            '<p class="message-content">'+String(value.message).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')+'</p>'+
                            '</li>'+
                            '<div class="clearfix"></div>'
                        );
                    }
                });
            })
            return false;
        });
        socket.on('all_data',function (allData) {
            $('.chat-body ul').text('');
            if (Object.keys(allData).length === 0) {
             $("#chat").css("display","none");
            }
            $.each(allData,function (key,value) {
                $('.header-name').text(value.username);
                if (value.sender_id == {{Auth::user()->id}}){
                    $('.chat-body ul').append(
                        '<li class="pull-right">' +
                        '<p class="message-content">'+String(value.message).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')+'</p>'+
                        '<img src="/image/'+value.avatar+'" class="message-img" alt="user-image">'+
                        '</li>'+
                        '<div class="clearfix"></div>'
                    );
                }else if (value.sender_id == {{$chat->receiver_id}} && value.receiver_id == {{Auth::user()->id}}){
                    $('.chat-body ul').append(
                        '<li class="pull-left">' +
                        '<img src="/image/'+value.avatar+'" class="message-img" alt="user-image">'+
                        '<p class="message-content">'+String(value.message).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')+'</p>'+
                        '</li>'+
                        '<div class="clearfix"></div>'
                    );
                    $('.chat-body').animate({scrollTop: $('.chat-body').prop("scrollHeight")}, 0.001);
                }
            });
        });

        //CHAT scroll
        $('.chat-body').animate({scrollTop: $('.chat-body').prop("scrollHeight")}, 0.001);
    </script>
@endsection

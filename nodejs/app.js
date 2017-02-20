var express = require('express');
var app = express();
var mysql = require('mysql');
var server = require('http').createServer(app);
var io = require('socket.io').listen(server);
var PORT = process.env.PORT || 3000;
var connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'final_project'
});
connection.connect(function (err) {
    if (err){
        console.error("error connecting " + err.stack);
    }
});


server.listen(PORT, function() {
    console.log("Server port: 3000");
});

// Connection
io.on('connection', function(socket){
    socket.on('send_message', function(data){
        if (data.message != '') {
            // console.log(data);
            connection.query('INSERT INTO chats SET?',[data],function (err) {
                if (err) throw err;
                io.emit('only_one_data',data);
            });

        }else {
            console.log('Mesaj boş ola bilməz');
        }
        connection.query(
            "SELECT " +
            "chats.message, chats.sender_id, chats.receiver_id, users.name, users.username, users.avatar " +
            "FROM " +
            "`chats` " +
            "INNER JOIN " +
            "`users` " +
            "ON " +
            "chats.sender_id = users.id",
            function (err,data) {
                if (err) throw err;
                io.emit('all_data',data);
            });
    });
    socket.on('data', function(result) {
        connection.query(
            "SELECT " +
            "chats.message, chats.sender_id, chats.receiver_id, users.name, users.avatar ,users.username " +
            "FROM " +
            "`chats` " +
            "INNER JOIN " +
            "`users` " +
            "ON chats.sender_id = users.id",
            function (err,data) {
                if (err) throw err;
                io.emit('all_data',data);
            });
    });

    socket.on('message_notifications', function(result) {
        if(result.id !=0) {
            connection.query(
                "SELECT " +
                "chats.sender_id, chats.receiver_id,chats.id, chats.message, users.name,users.avatar, chats.seen " +
                "FROM " +
                "chats " +
                "INNER JOIN " +
                "users " +
                "ON " +
                "chats.sender_id = users.id " +
                "WHERE " +
                "chats.receiver_id = " + connection.escape(result.id)+
                " ORDER BY " +
                "chats.id DESC",
                function (err, message_notification_data) {
                    if (err) throw err;
                    io.emit('notifications',message_notification_data);
                });
        }else{
            io.emit('notifications', result);
        }
    });
});

// For notificaton connect
io.on('connect',function (socket) {
        socket.on('live_update',function(result){
            connection.query(
                "SELECT "+
                "type_id,title,status "+
                "FROM "+
                "els "+
                "WHERE status=1 " +
                "AND updated_at=NOW()",
                function(error,live_update_rows){
                    if (error) throw error;
                    io.emit('live_update_data',live_update_rows);
                });
        });
});

  //  notificaton
  io.on('connection',function(socket){
    socket.on('live_notification',function(result) {
       connection.query(
         "SELECT "+
         "els.type_id,els.user_id,users.name,qarsiliqs.status,qarsiliqs.notificaton "+
         "FROM "+
         "els "+
         "INNER JOIN qarsiliqs ON "+
         "qarsiliqs.elan_id=els.id "+
         "WHERE els.user_id = "+ connection.escape(result.id) +
         " AND qarsiliqs.status = " + 1,
         function (err, live_notification_data) {
             if (err) throw err;
             io.emit('live_noti',live_notification_data);
         });
         $noti_qars_table_user=Elan::join('users', 'users.id', '=', 'els.user_id')
                 ->join('qarsiliqs', 'qarsiliqs.elan_id', '=', 'els.id')
                 ->select('els.type_id','users.name','users.avatar','qarsiliqs.notification','qarsiliqs.user_id','qarsiliqs.id','qarsiliqs.status','qarsiliqs.data')
                  ->where([
                        ['qarsiliqs.data', '=', 1],
                        ['qarsiliqs.user_id', '=', Auth::user()->id],
                        ['qarsiliqs.data_status', '=', 1]
                    ])
         connection.query(
           "SELECT "+
           "els.type_id,qarsiliqs.user_id,users.avatar,users.name,qarsiliqs.status,qarsiliqs.notificaton "+
           "qarsiliqs.id,qarsiliqs.status,qarsiliqs.data"
           "FROM "+
           "qarsiliqs "+
           "INNER JOIN els ON "+
           "els.id=qarsiliqs.elan_id "+
           "WHERE qarsiliqs.data = " + 1 +
           "AND qarsiliqs.data_status = " + 1 +
           " AND qarsiliqs.user_id = "+ connection.escape(result.id),
           function (err, live_notification_data) {
               if (err) throw err;
               io.emit('live_noti',live_notification_data);
           });
       );
    })
  });

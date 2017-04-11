var mysql = require('mysql');
var PORT = process.env.PORT || 3000;
var server = require('http').createServer().listen(PORT, function() {
    console.log("Server port: "+PORT);
});
var io = require('socket.io').listen(server);
var connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'final_project',
    multipleStatements: true
});
connection.connect(function (err) {
    if (err){
        console.error("error connecting " + err.stack);
    }
});

// Connection
io.on('connection', function(socket){

    socket.on('send_message', function(data){
        if (data.message != '') {
            connection.query('INSERT INTO chats SET?',[data],function (err) {
                if (err) throw err;
                connection.query(
                    "SELECT " +
                    "chats.message, chats.sender_id, chats.receiver_id, chats.created_at, users.name, users.avatar ,users.username " +
                    "FROM " +
                    "`chats` " +
                    "INNER JOIN " +
                    "`users` " +
                    "ON chats.sender_id = users.id " +
                    "WHERE sender_id ="+data.sender_id+" AND receiver_id="+data.receiver_id +" AND elan_id="+data.elan_id+
                    " OR sender_id="+data.receiver_id+" AND receiver_id="+data.sender_id +" AND elan_id="+data.elan_id+
                    " ORDER BY chats.id DESC LIMIT 1",
                    function (err,one_message) {
                        if (err) throw err;
                        // console.log(one_message);
                        io.emit('only_one_data',one_message);
                    });
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
                " WHERE chats.id in"+
                " (SELECT MAX(id) FROM chats WHERE receiver_id="+result.id+
                " GROUP BY GREATEST(receiver_id,sender_id),LEAST(receiver_id,sender_id))"+
                " ORDER BY chats.id DESC",
                function (err, message_notification_data) {
                    if (err) throw err;
                    io.emit('notifications',message_notification_data);
                });
        }else{
            io.emit('notifications', result);
        }
    });

    // functiom for All Count
    // io.on('connection',function (socket){
        socket.on('count',function (allcount)
        {
            connection.query(
                "SELECT " +
                " * FROM chats WHERE id IN "+
                "(SELECT MAX(id) FROM chats"+
                " WHERE seen=0 GROUP BY GREATEST(receiver_id,sender_id),LEAST(receiver_id,sender_id))"+
                " ORDER BY id DESC",
                function (err,datacount)
                {
                  if (err) throw  err;
                  io.emit('allcount',datacount);
                }
            );
            // connection.query(
              // "SELECT * FROM "+
              // " chats"+
              // " WHERE seen=0",
              // function(err,data) {
              //   io.emit('allcount',data);
              //   console.log(data.length);
              // }
            // )
        })
      // });

    // functiom for Count Zero
    socket.on('CountZero',function (count) {
        connection.query(
            "UPDATE " +
            "chats " +
            "SET " +
            "seen=1 " +
            "WHERE seen=0 AND receiver_id="+count.id,
            function (err,data) {
                if (err) throw  err;
            }
        );
    })

                  // DRING :)
// io.on('connection',function (socket) {
        socket.on('live_update',function(result){
            connection.query(
                "SELECT "+
                "type_id,title,status,id,slug "+
                "FROM "+
                "els "+
                "WHERE status=1 ",
                function(error,live_update_rows){
                    if (error) throw error;
                    io.emit('live_update_data',live_update_rows);
                });
        });
// });

  //  notificaton
  // io.on('connection',function(socket){
    socket.on('live_notification',function(result) {
        var noti_data = [];
            connection.query(
                "SELECT " +
                    "els.type_id, els.user_id as els_user_id,qarsiliqs.user_id as qarsiliqs_user_id,users.avatar,users.name as qarsiliqs_user_name,qarsiliqs.status,qarsiliqs.notification,qarsiliqs.id as qarsiliqs_id " +
                    "FROM " +
                    "qarsiliqs " +
                    "INNER JOIN els ON " +
                    "els.id=qarsiliqs.elan_id " +
                    "INNER JOIN users ON " +
                    "users.id=qarsiliqs.user_id " +
                    // "WHERE els.user_id =" + connection.escape(result.id) +
                    " WHERE qarsiliqs.notification = 1 ;" +
                "SELECT " +
                    "els.type_id,qarsiliqs.user_id as qarsiliqs_user_id,users.avatar,users.name as els_user_name,qarsiliqs.notification,qarsiliqs.id as qarsiliqs_id,qarsiliqs.data_status,qarsiliqs.data " +
                    "FROM " +
                    "qarsiliqs " +
                    "INNER JOIN els ON " +
                    "els.id = qarsiliqs.elan_id " +
                    "INNER JOIN users ON " +
                    "users.id = els.user_id " +
                    "WHERE qarsiliqs.data = 1 " ,
                    // "AND qarsiliqs.user_id = " + connection.escape(result.id),
                    function (error, results) {
                        if (error) throw error;
                        for ( var i=0; i<results.length; i++ ) {
                            for(var j=0; j<results.length; j++) {
                                if(results[i][j]){
                                    noti_data.push( results[i][j]);
                                }
                            }
                        };
                        io.emit('live_noti',noti_data);
                    }
            );
    })
    });

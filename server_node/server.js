// ===================Test Server================================
var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis(1000);
var users = [];

http.listen(6001, function() {
    console.log('Listening to port 6001');
});


redis.subscribe('private-chat-channel', function() {
    console.log('subscribed to private channel');
});

redis.subscribe('group-chat-channel', function() {
    console.log('subscribed to group channel');
});


io.on('connection', function(socket) {
    socket.on("user_connected", function(user_id) {
        users[user_id] = socket.id;
        io.emit('updateUserStatus', users);
        console.log("user connected " + user_id);
    });
    socket.on('disconnect', function() {
        // var i = users.indexOf(socket.id);
        // users.splice(i, 1, null);
        // io.emit('updateUserStatus', users);
        // console.log('disconnect', users);
        var i = users.indexOf(socket.id);
        users.splice(i, 1, 0);
        io.emit('updateUserStatus', users);
        console.log(users);
    });

});


redis.psubscribe('*', (error, count) => {
    //
})

redis.on('pmessage', function(parrter, chanel, message) {
    console.log(parrter);
    console.log(chanel);
    console.log(message);
    message = JSON.parse(message)
        // 
    if (chanel == 'private-channel') {
        io.to(`${users[ message.data.message.receider_id]}`).emit('sendMessage', message.data);
        // io.emit('sendMessage', message.data);
    }
    io.emit('sendMessage', message.data);
})
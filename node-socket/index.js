var app = require('http').createServer(handler);
var io = require('socket.io')(app);
var socketioJwt = require('socketio-jwt');

require('dotenv').config({path: '../.env'});
var Redis = require('ioredis');
var redis = new Redis(process.env.REDIS_PORT);

app.listen(process.env.SOCKETIO_PORT, function () {
    console.log('Server starting on port : ' + process.env.SOCKETIO_PORT);
});

function handler(req, res) {
    res.writeHead(200);
    res.end('');
}

io.on('connection', socketioJwt.authorize({
    secret: process.env.JWT_SECRET,
    timeout: 10000 // 10 seconds to send the authentication message
})).on('authenticated', function (socket) {
    //this socket is authenticated, we are good to handle more events from it.
    console.log('user ' + socket.decoded_token.sub + ' connected');

    socket.on('disconnect', function () {
        console.log('user ' + socket.decoded_token.sub + ' disconnected');
        redis.removeListener('pmessage', redis_handler);
        //redis.quit()
        socket.disconnect();
    });

    var redis_handler = function(subscribed, channel, message) {
        console.log('channel', channel)
        console.log('subscribed', subscribed)
        console.log('message', message)
        //if (channel == 'user.' + socket.decoded_token.sub) {
            message = JSON.parse(message);
            console.log('write to ' + channel + ' channel');
            io.emit(channel, message.data);
        //}
    };

    redis.on("pmessage", redis_handler);
});

redis.psubscribe('*', function (err, count) {
    console.log('psubscribe');
});

//io.to(channel).emit(message.event, message.data);
//io.sockets.in(channel).emit(eventNameListen[i], obj);
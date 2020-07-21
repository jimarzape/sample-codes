var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

/* required all the available channel you need - please see root_foler/app/Events/NotifEvent.php for reference */
redis.subscribe(
    [
        'ordering-notif', 
    ], 
    function(err, count) {
        console.log(err);
    }
);


redis.on('message', function(channel, message) {
    console.log(channel + ': ' + message);
    try {
        message = JSON.parse(message);
    }
    catch (e) { }
    
    io.emit(channel, message);
});

io.on('connection', (socket) => {

}); 

/* port can be change base on what is available port for your ufw/firewall */
http.listen(3000, function(){
    console.log('Listening on Port 3000');
});
 

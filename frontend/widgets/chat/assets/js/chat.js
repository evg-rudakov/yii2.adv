let chat = new WebSocket('ws://yii2.adv:8080');
let username = $('meta[name="chat-widget-username"]').attr('content');
let task_id = $('meta[name="chat-widget-task-id"]').attr('content');
let project_id = $('meta[name="chat-widget-project-id"]').attr('content');
let SHOW_HISTORY = 1;
let SEND_MESSAGE = 2;

chat.onmessage = function (e) {
    $('#response').text('');
    console.log(e);
    let response = JSON.parse(e.data);
    $('.js-messages-content').append('<div>'+response.created_at+' <b>' + response.username + '</b>: ' + response.message + '</div>');
};

chat.onopen = function (e) {
    console.log("Connection established!");
    //отправить сообщение с task_id и project_id - в какой набор пользователя подключить + user_id
    chat.send(JSON.stringify({
            'username': username,
            'type': SHOW_HISTORY,
            'task_id':task_id,
            'project_id': project_id
        })
    );
};


$('#send').click(function () {
    chat.send(JSON.stringify({
            'username': username,
            'message': $('#message').val(),
            'type': SEND_MESSAGE,
            'task_id':task_id,
            'project_id': project_id
        })
    );
    $('#message').val('');
});


$(document).on('click', '.js-hide', function () {
    $('.js-chat-content').hide();
    $('.js-show').show();
});
$(document).on('click', '.js-show', function() {
    $('.js-chat-content').show();
    $('.js-show').hide();

});




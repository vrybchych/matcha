$('#send').click(function () {
    var text = {
        message_text: $('#message').val(),
        id: $('#message').data('text')
    }

    $.post('/addmessage', text, function (data) {
        if (data) {
            $( ".append_message" ).prepend(data);
            $('#message').val("");
        }
    })
});

setInterval(function(){
    var text1 = {
        check: 1,
        id: $('#message').data('text')
    }
    $.post('/checkupdate', text1, function (data) {
        if (data) {
            $( ".append_message" ).prepend(data);
            $('#message').val("");
        }
    })
}, 4000);
$('#notifications_count').hide();
setInterval(function(){
    var text2 = {
        check: 1
    }
    $.post('/notcount', text2, function (data) {
        if (data != 0) {
            $('#notifications_count').show();
            $('#notifications_count').html(data);
            console.log(data);
        } else {
            $('#notifications_count').hide();
        }
    })
}, 1000);

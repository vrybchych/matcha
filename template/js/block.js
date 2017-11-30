$("#block").click(function(e) {
    $('#block_span').hide();
    $('#unblock_span').show();
    $.ajax({
        type: "POST",
        url: "/block",
        data: {
            block: 'OK',
        }
    });
});

$("#unblock").click(function(e) {
    $('#unblock_span').hide();
    $('#block_span').show();
    $.ajax({
        type: "POST",
        url: "/unblock",
        data: {
            unblock: 'OK',
        }
    });
});
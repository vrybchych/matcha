$("#like").click(function(e) {
    $('#like_span').hide();
    $('#unlike_span').show();
    $.ajax({
        type: "POST",
        url: "/like",
        data: {
            like: 'OK',
        }
    });
});

$("#unlike").click(function(e) {
    $('#unlike_span').hide();
    $('#like_span').show();
    $.ajax({
        type: "POST",
        url: "/unlike",
        data: {
            unlike: 'OK',
        }
    });
});
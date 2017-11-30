navigator.geolocation.getCurrentPosition(initMap, initMap(null), {timeout:10000});

var geocoder;
var map;
var marker;

function initMap(position) {
    geocoder = new google.maps.Geocoder();

    if (!position) {
        var lat = 50.464208899999996;
        var lng = 30.466489;
    } else {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
    }
    var myLatLng = {lat: lat, lng: lng};

    $.ajax({
        url: "/setlocation",
        type: "POST",
        data: ({
            lat: lat,
            lng: lng
        }),
        dataType: "html",
        success: function (data) {
            var result = $.parseJSON( data );
            lat = Number(result['lat']);
            lng = Number(result['lng']);
            myLatLng = {lat: lat, lng: lng};
            showMap(myLatLng);
        }
    });

    showMap(myLatLng);
}

function codeAddress() {
    var address = document.getElementById('address').value;
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == 'OK') {

            var lat = results[0].geometry.location.lat();
            var lng = results[0].geometry.location.lng();
            var myLatLng = {lat: lat, lng: lng};

            $.ajax({
                url: "/setlocation",
                type: "POST",
                data: ({
                    change_loc: true,
                    lat: lat,
                    lng: lng
                }),
                dataType: "html",
                success: function (data) {
                    var result = $.parseJSON( data );
                    lat = Number(result['lat']);
                    lng = Number(result['lng']);
                    myLatLng = {lat: lat, lng: lng};
                    showMap(myLatLng);
                }
            });
            showMap(myLatLng);
        }
    });
}

function showMap(myLatLng) {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: myLatLng
    });

    marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'I am here ;)'
    });
}
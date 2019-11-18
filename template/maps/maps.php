<script>

    var lat = document.getElementById("lat"); // this will select the input with id = lat
    var lng = document.getElementById("lng"); // this will select the input with id = lng
    var info = document.getElementById("info"); // this will select the current div  with id = info
    var ServiceId = document.getElementById("ServiceId"); // this will select the input with id = ServiceId
    var prov = document.getElementById("ProviderId"); // this will select the input with id = ProviderId
    var locations = [];
    var km = 30; // this kilometers used to specify circle wide when use drawcircle function
    var Crcl ; // circle variable
    var map; // map variable
    var mapOptions = {
        zoom: 11,
        center: {lat:24.774265, lng:46.738586}
    }; // map options
    var markers = []; // markers array ,we will fill it dynamically
    var infoWindow = new google.maps.InfoWindow(); // information window ,we will use for our location and for markers
    // this will initiate when load the page and have all
    function initialize() {
        // set the map to the div with id = map and set the mapOptions as defualt
        map = new google.maps.Map(document.getElementById('map'),
            mapOptions);

        var infoWindow = new google.maps.InfoWindow({map: map});

        // get current location with HTML5 geolocation API.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                lat.value  =  position.coords.latitude ;
                lng.value  =  position.coords.longitude;
                info.nodeValue =  position.coords.longitude;
                // set the current posation to the map and create info window with (Here Is Your Location) sentense
                infoWindow.setPosition(pos);
                infoWindow.setContent('Lokasi Anda Saat Ini..');
                // set this info window in the center of the map
                map.setCenter(pos);
                // draw circle on the map with parameters
                DrowCircle(mapOptions, map, pos, km);

            }, function() {
                // if user block the geolocatoon API and denied detect his location
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());

        }
    }
    // to handle user denied
    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: User Has Denied Location Detection.' :
            'Error: Your browser doesn\'t support geolocation.');
    }

    // to draw circle around 30 kilometers to current location
    function DrowCircle(mapOptions, map, pos, km ) {
        var populationOptions = {
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 1,
            fillColor: '#FF0000',
            fillOpacity: 0,
            map: map,
            center: pos,
            radius: Math.sqrt(km*500) * 100
        };
        // Add the circle for this city to the map.
        this.Crcl = new google.maps.Circle(populationOptions);
    }
    // this function to get providers with ajax request
    function RelatedLocationAjax() {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>services/closest_locations",
            dataType: "json",
            data:"data="+ '{ "latitude":"'+ lat.value+'", "longitude": "'+lng.value+'", "ServiceId": "'+ServiceId.value+'" }',
            success:function(data) {
                // when request is successed add markers with results
                add_markers(data);
            }
        });
    }
    // this function to will draw markers with data returned from the ajax request
    function add_markers(data){
        var marker, i;
        var bounds = new google.maps.LatLngBounds();
        var infowindow = new google.maps.InfoWindow();
        // display how many closest providers avialable
        document.getElementById('info').innerHTML = " Available:" + data.length + " Providers<br>";

        for (i = 0; i < data.length; i++) {
            var coordStr = data[i][2];
            var coords = coordStr.split(",");
            var pt = new google.maps.LatLng(parseFloat(coords[0]), parseFloat(coords[1]));
            bounds.extend(pt);
            marker = new google.maps.Marker({
                position: pt,
                map: map,
                icon: data[i][3],
                address: data[i][1],
                title: data[i][0],
                html: data[i][0] + "<br>" + data[i][1]
            });
            markers.push(marker);
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(marker.html);
                    prov.value = data[i][5];
                    infowindow.open(map, marker);
                }
            })
            (marker, i));

        }
        // this is important part , because we tell the map to put all markers inside the circle,
        // so all results will display and centered
        map.fitBounds(this.Crcl.getBounds());
    }

    google.maps.event.addDomListener(window, 'load', initialize);

</script>


<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNyLsAhFt4hIZKeNJYC244jPPayM0GhrY&callback=initialize">
</script>
var map;
var marker = null;

var mapOptions = {
  zoom: 14,
  disableDefaultUI: true,
  styles: [{"elementType": "geometry","stylers": [{"color": "#242f3e"}]},{"elementType": "labels.text.fill","stylers": [{"color": "#746855"}]},{"elementType": "labels.text.stroke","stylers": [{"color": "#242f3e"}]},{"featureType": "administrative.land_parcel","elementType": "labels","stylers": [{"visibility": "off"}]},{"featureType": "administrative.locality","elementType": "labels.text.fill","stylers": [{"color": "#d59563"}]},{"featureType": "poi","elementType": "labels.text","stylers": [{"visibility": "off"}]},{"featureType": "poi","elementType": "labels.text.fill","stylers": [{"color": "#d59563"}]},{"featureType": "poi.park","elementType": "geometry","stylers": [{"color": "#263c3f"}]},{"featureType": "poi.park","elementType": "labels.text.fill","stylers": [{"color": "#6b9a76"}]},{"featureType": "road","elementType": "geometry","stylers": [{"color": "#38414e"}]},{"featureType": "road","elementType": "geometry.stroke","stylers": [{"color": "#212a37"}]},{"featureType": "road","elementType": "labels.text.fill","stylers": [{"color": "#9ca5b3"}]},{"featureType": "road.highway","elementType": "geometry","stylers": [{"color": "#746855"}]},{"featureType": "road.highway","elementType": "geometry.stroke","stylers": [{"color": "#1f2835"}]},{"featureType": "road.highway","elementType": "labels.text.fill","stylers": [{"color": "#f3d19c"}]},{"featureType": "road.local","elementType": "labels","stylers": [{"visibility": "off"}]},{"featureType": "transit","elementType": "geometry","stylers": [{"color": "#2f3948"}]},{"featureType": "transit.station","elementType": "labels.text.fill","stylers": [{"color": "#d59563"}]},{"featureType": "water","elementType": "geometry","stylers": [{"color": "#17263c"}]},{"featureType": "water","elementType": "labels.text.fill","stylers": [{"color": "#515c6d"}]},{"featureType": "water","elementType": "labels.text.stroke","stylers": [{"color": "#17263c"}]}]
};

function initialize(latitude, longitude) {
  mapOptions['center'] = new google.maps.LatLng(latitude,longitude)
  map = new google.maps.Map(document.getElementById('map'), mapOptions);
  
  let location_marker = new google.maps.Marker({
    position: map.center,
    map: map,
    icon: "/html/imgs/location.png"
  });

  let base_marker = new google.maps.Marker({
    position: {
      lat: 14.129544, // Latitude of Mendez Municipal Hall
      lng: 120.905203 // Longitude of Mendez Municipal Hall
    },
    map: map,
    icon: "/html/imgs/finish.png"
  });

  let base_radius = new google.maps.Circle({
    strokeColor: "#B2CAFF",
    strokeOpacity: 0.5,
    strokeWeight: 2,
    fillColor: "#B2CAFF",
    fillOpacity: 0.35,
    map,
    center: {
      lat: 14.129544, // Latitude of Mendez Municipal Hall
      lng: 120.905203 // Longitude of Mendez Municipal Hall
    },
    radius: 1000 * 10, // radius accept values in meters
  });

  // if (haversine_distance(location_marker, base_marker) <= 10) {
    
  // } else {
  //   alert("You're too far from Mendez, Cavite!");
  // }

  if (has_queue < 1) {
    google.maps.event.addListener(map, 'click', function(event) {
      if ($('input[name=complete_address]').val() != '') {
        $('input[name=address_lat]').val(event.latLng.lat());
        $('input[name=address_lng]').val(event.latLng.lng());

        $('#search_button').fadeIn('1000');

        if (marker) {
          marker.setMap(null);
        }
              
        marker = new google.maps.Marker({ position: event.latLng, map: map, icon: "/html/imgs/destination.png"});
        var km_distance = haversine_distance(location_marker, marker);

        $('#km_div').css('display', 'inline');
        $('#km_value').html(parseInt(km_distance * 5));
      } else {
        $('#white_error').show();
        $('#error_message').html('Please write your address');

        hideErr();
      }
    });

    google.maps.event.addListener(base_radius, 'click', function(event) {
      if ($('input[name=complete_address]').val() != '') {
        $('input[name=address_lat]').val(event.latLng.lat());
        $('input[name=address_lng]').val(event.latLng.lng());

        $('#search_button').fadeIn('1000');

        if (marker) {
          marker.setMap(null);
        }
              
        marker = new google.maps.Marker({ position: event.latLng, map: map, icon: "/html/imgs/destination.png"});
        var km_distance = haversine_distance(location_marker, marker);

        $('#km_div').css('display', 'inline');
        $('#km_value').html(parseInt(km_distance * 5));
      } else {
        $('#white_error').show();
        $('#error_message').html('Please write your address');

        hideErr();
      }
    });
  }
}

navigator.geolocation.getCurrentPosition(function(position) {
  lat = position.coords.latitude;
  lng = position.coords.longitude;

  $('input[name=position_lat]').val(lat);
  $('input[name=position_lng]').val(lng);

  google.maps.event.addDomListener(window, 'load', initialize(lat, lng));
});

function haversine_distance(mk1, mk2) {
  var R = 3958.8; // Radius of the Earth in miles
  var rlat1 = mk1.position.lat() * (Math.PI/180); // Convert degrees to radians
  var rlat2 = mk2.position.lat() * (Math.PI/180); // Convert degrees to radians
  var difflat = rlat2-rlat1; // Radian difference (latitudes)
  var difflon = (mk2.position.lng()-mk1.position.lng()) * (Math.PI/180); // Radian difference (longitudes)

  var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)));
  return d * 1.6;
}
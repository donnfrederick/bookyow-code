var map;
var user_marker = null;
var rider_marker = null;
var new_user_coords = null;
var new_rider_coords = null;

var mapOptions = {
  zoom: 14,
  disableDefaultUI: true,
  styles: [{"elementType": "geometry","stylers": [{"color": "#242f3e"}]},{"elementType": "labels.text.fill","stylers": [{"color": "#746855"}]},{"elementType": "labels.text.stroke","stylers": [{"color": "#242f3e"}]},{"featureType": "administrative.land_parcel","elementType": "labels","stylers": [{"visibility": "off"}]},{"featureType": "administrative.locality","elementType": "labels.text.fill","stylers": [{"color": "#d59563"}]},{"featureType": "poi","elementType": "labels.text","stylers": [{"visibility": "off"}]},{"featureType": "poi","elementType": "labels.text.fill","stylers": [{"color": "#d59563"}]},{"featureType": "poi.park","elementType": "geometry","stylers": [{"color": "#263c3f"}]},{"featureType": "poi.park","elementType": "labels.text.fill","stylers": [{"color": "#6b9a76"}]},{"featureType": "road","elementType": "geometry","stylers": [{"color": "#38414e"}]},{"featureType": "road","elementType": "geometry.stroke","stylers": [{"color": "#212a37"}]},{"featureType": "road","elementType": "labels.text.fill","stylers": [{"color": "#9ca5b3"}]},{"featureType": "road.highway","elementType": "geometry","stylers": [{"color": "#746855"}]},{"featureType": "road.highway","elementType": "geometry.stroke","stylers": [{"color": "#1f2835"}]},{"featureType": "road.highway","elementType": "labels.text.fill","stylers": [{"color": "#f3d19c"}]},{"featureType": "road.local","elementType": "labels","stylers": [{"visibility": "off"}]},{"featureType": "transit","elementType": "geometry","stylers": [{"color": "#2f3948"}]},{"featureType": "transit.station","elementType": "labels.text.fill","stylers": [{"color": "#d59563"}]},{"featureType": "water","elementType": "geometry","stylers": [{"color": "#17263c"}]},{"featureType": "water","elementType": "labels.text.fill","stylers": [{"color": "#515c6d"}]},{"featureType": "water","elementType": "labels.text.stroke","stylers": [{"color": "#17263c"}]}]
};

var directionsService = new google.maps.DirectionsService();

function initialize(latitude, longitude, rider_lat, rider_lng) {
  directionsDisplay = new google.maps.DirectionsRenderer();
  mapOptions['center'] = new google.maps.LatLng(rider_lat,rider_lng)
  map = new google.maps.Map(document.getElementById('map'), mapOptions, calcRoute);

  rider_marker = new google.maps.Marker({
    position: map.center,
    map: map,
    icon: "/html/imgs/vespa.png"
  });

  user_marker = new google.maps.Marker({
    position: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
    map: map,
    icon: "/html/imgs/location.png"
  });

  directionsDisplay.setMap(map);
}

function calcRoute(u_lat, u_lng, r_lat, r_lng, is_init) {
  var start = new google.maps.LatLng(r_lat, r_lng);
  var end = new google.maps.LatLng(u_lat, u_lng);
  var request = {
    origin: start,
    destination: end,
    travelMode: google.maps.TravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
      directionsDisplay.setMap(map);
      directionsDisplay.setOptions( { suppressMarkers: true } );
      directionsDisplay.setOptions( {preserveViewport: is_init} );
    } else {
      alert("Directions Request from " + start.toUrlValue(6) + " to " + end.toUrlValue(6) + " failed: " + status);
    }
  });

  if (haversine_distance(user_marker, rider_marker) < 0.5) {
    $('#user_button_rider_arrived').show();
    ping_listener();
  } else {
    $('#user_button_rider_arrived').hide();
  }
}

google.maps.event.addDomListener(window, 'load', initialize(ride_points.u_lat, ride_points.u_lng, ride_points.r_lat, ride_points.r_lng));

var set_route = setInterval(function() {
  calcRoute(ride_points.u_lat, ride_points.u_lng, ride_points.r_lat, ride_points.r_lng, 0);
  clearInterval(set_route);
}, 1500);

var update_points = setInterval(function() {
  if (rider_marker) {
    rider_marker.setMap(null);
  }

  if (user_marker) {
    user_marker.setMap(null);
  }

  if (interaction_type == 0) {
    var request = 'get_points';

    $.ajax({
      url: '/api/update/points',
      method: 'post',
      data: {
        request:request,
        rider_queue_id: ride_details.rider_queue,
        customer_queue_id: ride_details.user_queue
      },
      success:function(response) {
        console.log(response);
        var data = JSON.parse(response);
        if (data.result != 'error') {
          user_lat = parseFloat(data.result.user_lat);
          user_lng = parseFloat(data.result.user_lng);
          rider_lat = parseFloat(data.result.rider_lat);
          rider_lng = parseFloat(data.result.rider_lng);

          new_user_coords = new google.maps.LatLng(user_lat, user_lng);
          new_rider_coords = new google.maps.LatLng(rider_lat, rider_lng);

          user_marker = new google.maps.Marker({ position: new_user_coords, map: map, icon: "/html/imgs/location.png"});
          rider_marker = new google.maps.Marker({ position: new_rider_coords, map: map, icon: "/html/imgs/vespa.png"});

          calcRoute(user_marker.position.lat(), user_marker.position.lng(), rider_marker.position.lat(), rider_marker.position.lng(), 1);
        } else {
          console.log(data.error);
          clearInterval(update_points);
        }
      }
    });
  } else {
    var request = 'get_points_update_customer';
    
    navigator.geolocation.getCurrentPosition(function(position) {
      var new_lat = position.coords.latitude;
      var new_lng = position.coords.longitude;

      $.ajax({
        url: '/api/update/points',
        method: 'post',
        data: {
          request: request,
          new_lat:new_lat,
          new_lng:new_lng,
          rider_queue_id: ride_details.rider_queue,
          customer_queue_id: ride_details.user_queue
        },
        success:function(response) {
          console.log(response);
          var data = JSON.parse(response);
          if (data.result != 'error') {
            user_lat = parseFloat(data.result.user_lat);
            user_lng = parseFloat(data.result.user_lng);
            rider_lat = parseFloat(data.result.rider_lat);
            rider_lng = parseFloat(data.result.rider_lng);

            new_user_coords = new google.maps.LatLng(user_lat, user_lng);
            new_rider_coords = new google.maps.LatLng(rider_lat, rider_lng);

            user_marker = new google.maps.Marker({ position: new_user_coords, map: map, icon: "/html/imgs/location.png"});
            rider_marker = new google.maps.Marker({ position: new_rider_coords, map: map, icon: "/html/imgs/vespa.png"});

            calcRoute(user_marker.position.lat(), user_marker.position.lng(), rider_marker.position.lat(), rider_marker.position.lng(), 1);

            map.setCenter(rider_marker.getPosition())
          } else {
            console.log(data.error);
            clearInterval(update_points);
          }
        }
      });
    });
  }
}, 6000);

function haversine_distance(mk1, mk2) {
  var R = 3958.8; // Radius of the Earth in miles
  var rlat1 = mk1.position.lat() * (Math.PI/180); // Convert degrees to radians
  var rlat2 = mk2.position.lat() * (Math.PI/180); // Convert degrees to radians
  var difflat = rlat2-rlat1; // Radian difference (latitudes)
  var difflon = (mk2.position.lng()-mk1.position.lng()) * (Math.PI/180); // Radian difference (longitudes)

  var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)));
  return d * 1.6;
}

function ping_listener() {
  var request = 'update_ping';
  var ride_id = ride_details.ride_id;
  setInterval(function() {
    $.ajax({
      url: '/api/update/ping',
      method: 'post',
      data: {
        request: request,
        ride_id: ride_id
      },
      success:function(response) {
        var data = JSON.parse(response);

        if (data.result == 'success') {
          window.location.reload();
        }
      }
    });
  }, 1000);
}
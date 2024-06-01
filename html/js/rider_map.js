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

  new google.maps.Marker({
    position: map.center,
    map: map,
    icon: "/html/imgs/vespa.png"
  });

  new google.maps.Marker({
    position: {
      lat: 14.129544, // Latitude of Mendez Municipal Hall
      lng: 120.905203 // Longitude of Mendez Municipal Hall
    },
    map: map,
    icon: "/html/imgs/finish.png"
  });

  new google.maps.Circle({
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
}

navigator.geolocation.getCurrentPosition(function(position) {
  lat = position.coords.latitude;
  lng = position.coords.longitude;

  google.maps.event.addDomListener(window, 'load', initialize(lat, lng));
});
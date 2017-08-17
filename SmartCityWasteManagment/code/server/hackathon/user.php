<!DOCTYPE html>
<html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      #floating-panel {
       position: absolute;
       top: 10px;
       left: 25%;
       z-index: 5;
       background-color: #fff;
       padding: 5px;
       border: 1px solid #999;
       text-align: center;
       font-family: 'Roboto','sans-serif';
       line-height: 30px;
       padding-left: 10px;
     }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
    var customLabel = {
      restaurant: {
        label: 'D'
      },
      bar: {
        label: 'B'
      }
    };
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      var map, infoWindow,directionsService,directionsDisplay;

      var l1,l2;
      function initMap() {
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var directionsService = new google.maps.DirectionsService;

        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 25.191882, lng: 75.85359}, //,
          zoom: 14
        });
        infoWindow = new google.maps.InfoWindow;
        directionsDisplay.setMap(map);
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };




            // calculateAndDisplayRoute(directionsService, directionsDisplay);
            //
            // document.getElementById('mode').addEventListener('change', function() {
            //
            //   calculateAndDisplayRoute(directionsService, directionsDisplay);
            // });

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }




        downloadUrl('http://mithramedia.co.in/hackathon/markers2.xml', function(data) {
          var xml = data.responseXML;
          var markers = xml.documentElement.getElementsByTagName('marker');
          Array.prototype.forEach.call(markers, function(markerElem) {
            var id = markerElem.getAttribute('id');
            var name = markerElem.getAttribute('name');
            var address = markerElem.getAttribute('address');
            var type = markerElem.getAttribute('type');
            var capacity = markerElem.getAttribute('capacity');
            var point = new google.maps.LatLng(
                parseFloat(markerElem.getAttribute('lat')),
                parseFloat(markerElem.getAttribute('lng')));

            var infowincontent = document.createElement('div');
            var strong = document.createElement('strong');



            strong.textContent = name
            infowincontent.appendChild(strong);
            infowincontent.appendChild(document.createElement('br'));

            var text = document.createElement('text');
            text.textContent = address
            infowincontent.appendChild(text);
            var icon = customLabel[type] || {};
            var marker = new google.maps.Marker({
              map: map,
              position: point,
              label: icon.label
            });
            marker.addListener('click', function() {
              infoWindow.setContent(infowincontent);
              infoWindow.open(map, marker);
            });
          });
        });
      }



      function calculateAndDisplayRoute(directionsService, directionsDisplay,pos) {
       var selectedMode = document.getElementById('mode').value;

       directionsService.route({
         origin: {lat: l1, lng: l2},  // Haight.

         destination: {lat: 25.199853, lng: 75.857377},  // Ocean Beach.
         // Note that Javascript allows us to access the constant
         // using square brackets and a string value as its
         // "property."
         travelMode: google.maps.TravelMode[selectedMode]
       }, function(response, status) {
         if (status == 'OK') {
           directionsDisplay.setDirections(response);
         } else {
           window.alert('Directions request failed due to ' + status);
         }
       });
     }


      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }

      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }
      function doNothing() {}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxV-NA-xettptwTPuPICwiW__COOR6f0w&callback=initMap">
    </script>
    <select id="mode">
     <option value="DRIVING">Driving</option>
     <option value="WALKING">Walking</option>
     <option value="BICYCLING">Bicycling</option>
     <option value="TRANSIT">Transit</option>
   </select>
   </div>
  </body>
</html>

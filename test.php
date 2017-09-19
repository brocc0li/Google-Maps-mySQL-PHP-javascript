<?php 
include "dbconnect.php";
$sql = "SELECT id, lat, lng, info, address FROM maps";
	if ($result = $conn->query($sql)) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
            $lat = $row['lat'];
            $lng = $row['lng'];                              
            $info = $row['info'];
            $address = $row['address'];
            /* Each row is added as a new array */
            $locations[]=array( 'lat'=>$lat, 'lng'=>$lng, 'info'=>$info, 'address'=>$address );
        }
	} else {
		echo "failed contact an administrator to solve this issue.";
	}
?>
<head>
<style>
html,
body,
#map {
  height: 100%;
  width: 100%;
  margin: 0px;
  padding: 0px
}
</style>
</head>



<body>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1BLziJhXfubOBlcpYRET_ujyIza5wf8A"></script>
<div id="map"></div>
<script>

function initMap() {

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 5,
    center: {
      lat: 64.2868021,
      lng: 8.7824582
    }
  });
  var infoWin = new google.maps.InfoWindow();
  // Add some markers to the map.
  // Note: The code uses the JavaScript Array.prototype.map() method to
  // create an array of markers based on a given "locations" array.
  // The map() method here has nothing to do with the Google Maps API.
  var markers = locations.map(function(location, i) {
    var marker = new google.maps.Marker({
      position: location
    });
    google.maps.event.addListener(marker, 'click', function(evt) {
      infoWin.setContent(location.info);
      infoWin.open(map, marker);
    })
    return marker;
  });

  // markerCluster.setMarkers(markers);
  // Add a marker clusterer to manage the markers.
  var markerCluster = new MarkerClusterer(map, markers, {
    imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
  });

}
    var locations = [
        <?php for($i=0;$i<sizeof($locations);$i++){ $j=$i+1;?>
		{
            lat: <?php echo $locations[$i]["lat"];?>,
            lng: <?php echo $locations[$i]["lng"];?>,
			info: '<div class="info_content"><h3><?php echo $locations[0]['address'];?></h3><p><?php echo $locations[0]['info'];?>"></p></div><hr>',
        }<?php if($j!=sizeof($locations))echo ","; };?>
		];


google.maps.event.addDomListener(window, "load", initMap);
</script>
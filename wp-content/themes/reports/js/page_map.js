jQuery(document).ready(function(){

if(typeof google=="undefined"){
	return;
}	
var loc; //this will store information about the current base location selected by the user
var markers_array = []; //this will store an array of the markers that were created
var directionsDisplay;
var directionsService;
var directionsService = new google.maps.DirectionsService();
var autocomplete;
var map;
var homeLatlng;
var homeMarker;

var appDomain=jQuery('input.appDomain').val();
var image = new google.maps.MarkerImage(appDomain+"/images/place_marker.png",new google.maps.Size(40,35),new google.maps.Point(0,0),new google.maps.Point(20,35));

var shadow = null;
 var infowindow = new google.maps.InfoWindow();
var shape = null;
var mc;

function initialize(){
	

	directionsDisplay = new google.maps.DirectionsRenderer();
	//set the map options
	var map_options = {
		center: new google.maps.LatLng(-33.905553,151.2065067),
		zoom: 10, //set zoom level to 17 
		mapTypeId: google.maps.MapTypeId.ROADMAP //set map type to road map
	};

	//layout the map in the page
	
	if(jQuery('.map-canvas').length<1){
			
		return;
	}
	
	map = new google.maps.Map(jQuery(".map-canvas")[0], map_options);
	
		directionsDisplay.setMap(map);
		var cities = new Array(
			
		);
		var content = new Array(
			
		);
		var link = new Array(
			
		);
		var mcOptions = {gridSize: 20, maxZoom: 28};
			var gmarkers = [];
			mc = new MarkerClusterer(map, [], mcOptions);
		
		jQuery('div.one_place').each(function(whole_index){			
		
				classes=jQuery(this).attr('class').split(" ");		
				index=classes[1];
				label=jQuery('input.label.'+index).val();					
				geolocation=jQuery('input.geolocation.'+index).val();
				console.log(geolocation);
				parts=geolocation.split(',');
				
				var latlng = new google.maps.LatLng(parseFloat(parts[0]),parseFloat(parts[1]));
								marker=createMarker(latlng,label);
				gmarkers.push(marker);					
				var bounds = new google.maps.LatLngBounds();
				for(i=0;i<gmarkers.length;i++) {
					
					bounds.extend(gmarkers[i].getPosition());
				}
				map.setCenter(bounds.getCenter());
				map.fitBounds(bounds);
			});
			
		}	

function createMarker(latlng,text) {
	
	var infowindow = new google.maps.InfoWindow();
	
  var marker = new google.maps.Marker({
	draggable: false,
	raiseOnDrag: false,
	position: latlng,
	map: map
  });

  ///get array of markers currently in cluster
  var allMarkers = mc.getMarkers();

  //check to see if any of the existing markers match the latlng of the new marker
  if (allMarkers.length != 0) {
    for (i=0; i < allMarkers.length; i++) {
      var existingMarker = allMarkers[i];
      var pos = existingMarker.getPosition();

      if (latlng.equals(pos)) {
        text = text + " & " + content[i];
      }                   
    }
  }

	infowindow.setContent(text);
   infowindow.open(map,marker);
	
  mc.addMarker(marker);
  return marker;  
}
	//console.log(google);
	google.maps.event.addDomListener(window, 'load', initialize);

});

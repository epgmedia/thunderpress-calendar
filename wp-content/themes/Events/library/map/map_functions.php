<?php
if(!function_exists('show_address_google_map'))
{
    function show_address_google_map($latitute,$longitute,$address,$width='640',$height='350')
    {
    ?>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?php echo get_option('ptthemes_api_key');?>" type="text/javascript"></script>
    <script type="text/javascript">
    var map = null;
    var geocoder = null;
    var lat = <?php echo $latitute;?>;
    var lng = <?php echo $longitute;?>;
    function initialize() {
     
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));

        map.setCenter(new GLatLng(lat, lng), 13);
      
        function createMarker(latlng, number) {
          var marker = new GMarker(latlng);
          marker.value = number;
          GEvent.addListener(marker,"click", function() {
            var myHtml =  "<?php echo $address;?>";
            map.openInfoWindowHtml(latlng, myHtml);
          });
          return marker;
        }
    
          var latlng = new GLatLng(lat,lng);
            map.addOverlay(createMarker(latlng, 1));
      }
    }
    window.onload = function () {initialize();}
    window.onunload = function () {GUnload();}
    </script>
    <div class="map" id="map_canvas" style="width:<?php echo $width;?>px; height:<?php echo $height;?>px"></div>
    <?php
    }
}

if(!function_exists('get_location_map_javascripts'))
{
	function get_location_map_javascripts()
	{
	?>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?php echo get_option('ptthemes_api_key');?>" type="text/javascript"></script>
    <script type="text/javascript">
window.onload = function () {main_function();}
window.onunload = function () {GUnload();}
var map;
var geocoder;
var address;
var CITY_MAP_CENTER_LAT = '<?php echo get_option('ptthemes_latitute');?>';
var CITY_MAP_CENTER_LNG = '<?php echo get_option('ptthemes_longitute');?>';
<?php if(get_option('ptthemes_scaling_factor')){?>
var CITY_MAP_ZOOMING_FACT=<?php echo get_option('ptthemes_scaling_factor');?>;
<?php }else{?>
var CITY_MAP_ZOOMING_FACT='';
<?php }?>

if(CITY_MAP_CENTER_LAT=='')
{
	var CITY_MAP_CENTER_LAT = 34;	
}
if(CITY_MAP_CENTER_LNG=='')
{
	var CITY_MAP_CENTER_LNG = 0;	
}
if(CITY_MAP_ZOOMING_FACT=='')
{
	var CITY_MAP_ZOOMING_FACT = 5;	
}
function initialize() {
  map = new GMap2(document.getElementById("map_canvas"));
 //map.setCenter(new GLatLng(0,34), 3);
  map.setCenter(new GLatLng(CITY_MAP_CENTER_LAT,CITY_MAP_CENTER_LNG), CITY_MAP_ZOOMING_FACT);
  map.addControl(new GLargeMapControl);
  
  
    GEvent.addListener(map, "click", getAddress);
  	geocoder = new GClientGeocoder();
    var marker = new GMarker(new GLatLng(CITY_MAP_CENTER_LAT,CITY_MAP_CENTER_LNG), {draggable: true});

    GEvent.addListener(marker, "dragstart", function() {
      map.closeInfoWindow();
    });
	
	GEvent.addListener(marker, "dragend", function() {

	var lat = marker.getLatLng().lat();
	var lng = marker.getLatLng().lng();

      marker.openInfoWindowHtml('<b><?php _e('Latitude:','templatic');?></b>' + lat + '<br><b><?php _e('Longitude:','templatic');?></b>' + lng);
	  document.getElementById('geo_latitude').value=lat;
      document.getElementById('geo_longitude').value=lng;
    });
    map.addOverlay(marker);
	
}

function dumpProps(obj, parent) {
   // Go through all the properties of the passed-in object
   for (var i in obj) {
      // if a parent (2nd parameter) was passed in, then use that to
      // build the message. Message includes i (the object's property name)
      // then the object's property value on a new line
      if (parent) { var msg = parent + "." + i + "\n" + obj[i]; } else { var msg = i + "\n" + obj[i]; }
      // Display the message. If the user clicks "OK", then continue. If they
      // click "CANCEL" then quit this level of recursion
      if (!confirm(msg)) { return; }
      // If this property (i) is an object, then recursively process the object
      if (typeof obj[i] == "object") {
         if (parent) { dumpProps(obj[i], parent + "." + i); } else { dumpProps(obj[i], i); }
      }
   }
}

function getAddress(overlay, latlng) {
  if (latlng != null) {
    address = latlng;
    geocoder.getLocations(latlng, showAddress);
  }
}

function showAddress(response) {
  map.clearOverlays();
  if (!response || response.Status.code != 200) {
    alert("<?php _e('Status Code:','templatic');?>" + response.Status.code);
  } else {
    place = response.Placemark[0];
    point = new GLatLng(place.Point.coordinates[1],
                        place.Point.coordinates[0]);
    marker = new GMarker(point, {draggable: true});
    map.addOverlay(marker);
    marker.openInfoWindowHtml(
    '<b><?php _e('latlng:','templatic');?></b>' + place.Point.coordinates[1] + "," + place.Point.coordinates[0] + '<br>' +
    '<b><?php _e('Address:','templatic');?></b>' + place.address
    );
	document.getElementById('geo_latitude').value=place.Point.coordinates[1];
	document.getElementById('geo_longitude').value=place.Point.coordinates[0];

	GEvent.addListener(marker, "dragstart", function() {
	  map.closeInfoWindow();
	});
	
	
	GEvent.addListener(marker, "dragend", function() {
		//dumpProps(marker);
	 	   
	
	 
	  var lat = marker.getLatLng().lat();
	  var lng = marker.getLatLng().lng();

	  marker.openInfoWindowHtml('<b><?php _e('Latitude:','templatic');?></b>' + lat + '<br><b><?php _e('Longitude:','templatic');?></b>' + lng + '<br>');
	  document.getElementById('geo_latitude').value=lat;
	  document.getElementById('geo_longitude').value=lng;
	 
	});   
  }
}
function findAddress(address) {
  if (geocoder) {
    geocoder.getLatLng(
      address,
      function(point) {
        if (!point) {
          alert(address + " not found");
        } else {
          map.setCenter(point, 13);
         geocoder.getLocations(point, showAddress);
        }
      }
    );
  }
}
</script>
<script type="text/javascript">
window.onload = function () {initialize();}
window.onunload = function () {GUnload();}
</script>	
	<?php
	}
}
?>
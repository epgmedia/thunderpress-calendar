var map;
var mgr;
var gdir;
var geocoder = null;
var addressMarker;
var icons = [];
var allmarkers_def = [];
var allmarkers = [];
if(CITY_MAP_CENTER_LAT=='')
{
	var CITY_MAP_CENTER_LAT = 34;	
}
if(CITY_MAP_CENTER_LNG=='')
{
	var CITY_MAP_CENTER_LNG = 0;	
}
if(CITY_MAP_CENTER_LAT!='' && CITY_MAP_CENTER_LNG!='' && CITY_MAP_ZOOMING_FACT!='')
{
	var CITY_MAP_ZOOMING_FACT = 13;
}else if(CITY_MAP_ZOOMING_FACT!='')
{
	var CITY_MAP_ZOOMING_FACT = 3;	
}
if(CITY_MAP_VIEW_TYPE=='')
{
	var CITY_MAP_CENTER_LNG = 'G_NORMAL_MAP';	
}
if(MAP_DISABLE_SCROLL_WHEEL_FLAG)
{
	var MAP_DISABLE_SCROLL_WHEEL_FLAG = 'No';	
}
function initialize() {
if (GBrowserIsCompatible()) {
var map = new GMap2(document.getElementById("map_canvas"));
gdir = new GDirections(map, document.getElementById("directions"));
GEvent.addListener(gdir, "load", onGDirectionsLoad);
GEvent.addListener(gdir, "error", handleErrors);



map.setCenter(new GLatLng(CITY_MAP_CENTER_LAT,CITY_MAP_CENTER_LNG), CITY_MAP_ZOOMING_FACT);
//map.setCenter(new GLatLng(34, 0), 1);  //world map
map.setUIToDefault(); //zooming icons

if(MAP_DISABLE_SCROLL_WHEEL_FLAG=='Yes')
{
	map.disableScrollWheelZoom();	
}
if(CITY_MAP_VIEW_TYPE!='')
{
	map.setMapType(CITY_MAP_VIEW_TYPE);	
}
mgr = new MarkerManager(map, {trackMarkers:true});
return map;
}
}
function main_function()
{
	map = initialize();	
	createMarker(map,'','');
}

// Creates a marker at the given point
function getCategoryIcon(i) {
 
  if (!ICONS[i]) {
	var icon = new GIcon();
	icon.image = IMAGES[i];
	icon.iconAnchor = new GPoint(16, 16);
	icon.infoWindowAnchor = new GPoint(16, 0);
	icon.iconSize = new GSize(20, 34);
	icon.shadow = IMAGES_SHADOW[i];
	icon.shadowSize = new GSize(59, 32);
	ICONS[i] = icon;
  }
  return ICONS[i];
}
	
function createMarkerIcon(map,latlng, cat_num,post_num) {
 var cat_image = cat_num;
 var postinfo = post_num;
  category_icon =  getCategoryIcon(cat_image);
 var marker = new GMarker(latlng,{ icon: category_icon });
  marker.value = post_num;
  GEvent.addListener(marker,"click", function() {
	var myHtml = POST_INFO[cat_num][postinfo][3];
    map.openInfoWindowHtml(latlng, myHtml);
  });
  
  return marker;
}
function createMarkerIconPop(map,latlng, cat_num,post_num) {
 var cat_image = cat_num;
 var postinfo = post_num;
  category_icon =  getCategoryIcon(cat_image);
 var marker = new GMarker(latlng,{ icon: category_icon });
  marker.value = post_num;
	var myHtml = POST_INFO[cat_num][postinfo][3];
    map.openInfoWindowHtml(latlng, myHtml);
  return marker;
}

function createMarker(map,catid,pid)
{
	if(catid=='all')
	{
		for (var c = 0; c < CAT_INFO.length; c++){
			if(catid!='' && catid==c && pid!=''){createPostMarker(map,c,pid);}else{createPostMarker(map,c,'');}
		}
	}else
	{
		if(catid!='' && pid==''){
				var map_cat_arr = document.getElementsByName("map_cat[]");
				var chklength = map_cat_arr.length;
				if(chklength>1)
				{
					for(i=0;i<chklength;i++)
					{
						if(map_cat_arr[i].checked){
							var catid = map_cat_arr[i].value;
							createPostMarker(map,catid,'');
						}
					}		
				}else
				{
					createPostMarker(map,catid,pid);
				}
			}
		else{
			for (var c = 0; c < CAT_INFO.length; c++){
				if(catid!='' && catid==c && pid!=''){createPostMarker(map,c,pid);}else{createPostMarker(map,c,'');}
			}
		}
	}
	mgr.refresh();
}
function createPostMarker(map,catid,pid)
{
	var c = catid;
	var latSpan = '';
	var lngSpan = '';
	var latlng = '';
	var created_marker = '';
	for(var p=0; p<POST_INFO[c].length; p++)
	{
		latSpan = POST_INFO[c][p][1];
		lngSpan = POST_INFO[c][p][2];	
		latlng = new GLatLng(latSpan,lngSpan);
		if(pid!='' && pid==p)
		{
			created_marker = createMarkerIconPop(map,latlng, c,p);
		}
		if(eval(map)){
		created_marker = createMarkerIcon(map,latlng, c,p);
		map.addOverlay(created_marker);
		allmarkers.push(created_marker);
		if(allmarkers_def.length<=0){allmarkers_def = allmarkers;}
		}
	}
}
function reloadMarkers(catid) { allmarkers = []; map = initialize(); 
	createMarker(map,catid,'');
}
function clearMarkers() {for(i=0; i<allmarkers.length; i++){mgr.removeMarker(allmarkers[i]);}}
function reloadSingleMarker(catid,pid) { map = initialize(); createMarker(map,catid,pid);}
function deleteMarker() {
var markerNum = parseInt(document.getElementById("markerNum").value);
mgr.removeMarker(allmarkers[markerNum]);
}


function setDirections(fromAddress, toAddress, locale) {
  gdir.load("from: " + fromAddress + " to: " + toAddress,
            { "locale": locale });
}
function handleErrors(){
 if (gdir.getStatus().code == G_GEO_UNKNOWN_ADDRESS)
   alert("No corresponding geographic location could be found for one of the specified addresses. This may be due to the fact that the address is relatively new, or it may be incorrect.\nError code: " + gdir.getStatus().code);
 else if (gdir.getStatus().code == G_GEO_SERVER_ERROR)
   alert("A geocoding or directions request could not be successfully processed, yet the exact reason for the failure is not known.\n Error code: " + gdir.getStatus().code);
 
 else if (gdir.getStatus().code == G_GEO_MISSING_QUERY)
   alert("The HTTP q parameter was either missing or had no value. For geocoder requests, this means that an empty address was specified as input. For directions requests, this means that no query was specified in the input.\n Error code: " + gdir.getStatus().code);

//   else if (gdir.getStatus().code == G_UNAVAILABLE_ADDRESS)  <--- Doc bug... this is either not defined, or Doc is wrong
//     alert("The geocode for the given address or the route for the given directions query cannot be returned due to legal or contractual reasons.\n Error code: " + gdir.getStatus().code);
   
 else if (gdir.getStatus().code == G_GEO_BAD_KEY)
   alert("The given key is either invalid or does not match the domain for which it was given. \n Error code: " + gdir.getStatus().code);

 else if (gdir.getStatus().code == G_GEO_BAD_REQUEST)
   alert("A directions request could not be successfully parsed.\n Error code: " + gdir.getStatus().code);
  
 else alert("An unknown error occurred.");
}

function onGDirectionsLoad(){
    // Use this function to access information about the latest load()
    // results.

    // e.g.
    // document.getElementById("getStatus").innerHTML = gdir.getStatus().code;
  // and yada yada yada...
}
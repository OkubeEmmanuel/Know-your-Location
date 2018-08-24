function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";}
    }
    
function showPosition(position) {
	var a = position.coords.latitude;
	var b = position.coords.longitude;
	redirect(a, b);
}

function redirect(lat, long){
	window.location.href = "Landing.php?lat="+lat+"&lon="+long;
}


<script>
var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    x.innerHTML = "" + position.coords.latitude + 
    " " + position.coords.longitude;
}
</script>
<?php
   function getAddress($lat, $lon){
   $url  = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".
            $lat.",".$lon."&sensor=false";
   $json = @file_get_contents($url);
   $data = json_decode($json);
   $status = $data->status;
   $address = '';
   if($status == "OK"){

      $data = (array)$data;
      foreach ($data["results"] as $result) {
        $result = (array)$result;
          foreach ($result["address_components"] as $address) {
            $address = (array)$address;
              if (in_array("locality", $address["types"])) {
                  $city = $address["long_name"];
              }
          }
      }
      // country
      foreach ($data["results"] as $result) {
        $result = (array)$result;
          foreach ($result["address_components"] as $address) {
            $address = (array)$address;
              if (in_array("country", $address["types"])) {
                  $country = $address["long_name"];
              }
          }
      }
      $address = $city.", ".$country;
      //$data->results[0]->formatted_address;
    }
   return $address;
  }

  # Call function
  echo getAddress(getLocation());
 ?>

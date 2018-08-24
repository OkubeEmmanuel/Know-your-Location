<?php
  $latitude = $_GET["lat"];
  $longitude = $_GET["lon"];
  $counter = 0;

  function storeCookie($name, $lnk){
    $x = 1;
    $cn = "a".$x;
    while(isset($_COOKIE[$cn])) {
      $x++;
      $cn = "a".$x;
    }
    $GLOBALS['counter'] = $x;

    if (!(isset($_COOKIE[$cn]))){
      $cv = $name.",".$lnk;
      $c = 0;
      for($i = 1; $i <= $x; $i++){
        $cn1 = "a".$i;
        if($_COOKIE[$cn1] == $cv){
          break;
        }
        else {
          $c++;
        }
      }
      if ($c == $i) {
        setcookie($cn,$cv,time()+86400);
      }
    }
  }

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
    $physicalAddress = getAddress($latitude, $longitude);
    $ll = "?lat=".$latitude."&lon=".$longitude;
    $link = "Landing.php".$ll;
    storeCookie($physicalAddress, $link);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
      <link rel="stylesheet" type="text/css" href="css/style2.css">

      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script src="js/jquery.min.js"></script>
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <script type="text/javascript" src="LangLong.js"></script>
</head>
<body>
  <div id="header">
    <div class="container text-center" style="font-family: Fredericka the Great, cursive;">
      <h1><span style="color: #DAA46D">BITSAIR</span> | <span style="color: #DAA46D"> PILOTS PLUS
      </span></h1>
    </div>

      <h3><p> Move with Location</p></h3>
  </div>


<nav id="nav">
  <div class="container-fluid">
    <div class="col-md-12">
        <div class="col-md-3" style="font-family: Architects Daughter"> PILOTS PLUS</div>
          <div class="col-md-5"></div>
            <div class="col-md-4">
              <a href="">
                  <button class="btn btn-default" onclick="getLocation()">
                      <span class="glyphicon glyphicon-screenshot"> Current Location </span>
                    </button>
              </a>
        </div>
      </div>
  </div>
</nav>

<div class="col-md-12">
  <div class="row">
    <div class="col-md-10"><iframe src="https://www.wikipedia.org/wiki/<?php echo $physicalAddress;?>" style="height: 600px; width: 100%" scrolling="auto"></iframe>
    </div>
    <div class="col-md-2">
      <h3>Location History</h3>
      <div class="col-md-12">
          <?php
            for ($i = 1; $i <= $counter; $i++) {
              $cn = "a".$i;
              $value = $_COOKIE[$cn];
               $linkAdr = explode(",", $value);
               $adress = $linkAdr[0].", ".$linkAdr[1];
               echo '<a href="'.$linkAdr[2].'"><p>'.$adress.'</p> </a><hr>';
             }
          ?>
      </div>
    </div>
  </div>
</div>
<div id="footer">

</div>

  <script>
  $(document).ready(function(){
      $('[data-toggle="popover"]').popover();
  });
  </script>


</body>
</html>

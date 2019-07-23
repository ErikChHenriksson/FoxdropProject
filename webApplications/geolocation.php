<?php
	include 'header.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
		crossorigin="anonymous">
  <script
	  src="https://code.jquery.com/jquery-3.3.1.slim.js"
	  integrity="sha256-fNXJFIlca05BIO2Y5zh1xrShK3ME+/lYZ0j+ChxX2DA="
	  crossorigin="anonymous">
  </script>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link class="img-test" rel="shortcut icon" type="image/png" href="images/firefoxLogo.png">
</head>



<body bgcolor="">
	<section class="mobile-wrapper">
		<div style="background:black" class="jumbotron mt-5 text-white border">
		  <h2 style="text-align:center; font-size:60px; padding-top: 5%">Geolocation<br></h2>
		  <p style="font-size: 14px; text-align: center">If nothing happens, click <a href="https://foxdrop.000webhostapp.com/webApplications/geolocation.php">here</a>.</p> 

		  <p style="font-size: 25px; text-align: center">
					Latitude: <span id="lat"></span>° 
				<br>
					Longitude: <span id="lon"></span>°
				<br>
					Altitude: <span id="altitude"></span>m
				<br>
					Heading: <span id="heading"></span>° (0° is north)
				<br>
					Speed: <span id="speed"></span>m/s
				<br><br>
					Start Google Maps, then Copy and Paste the following output there: <br><br><span style="color:gold" id="lat2"></span>, <span style="color:gold" id="lon2"></span>
			</p>

			 <h2 style="text-align:center; font-size:60px; padding-top: 4%">Weather Forecast<br></h2>

		  <script>
		  	let lat, lon, lat2, lon2, altitude, heading, speed, weather, air;  
		  	// Geolocation is avaliable as soon as website is deployed on a (https) hosting service.
		  	if('geolocation' in navigator) {
		  		console.log('geolocation avaliable');
		  		navigator.geolocation.getCurrentPosition(async position => {
		  			lat = position.coords.latitude;
		  			lon = position.coords.longitude;
		  			lat2 = position.coords.latitude;
		  			lon2 = position.coords.longitude;
		  			altitude = position.coords.altitude;
		  			heading = position.coords.heading;
		  			speed = position.coords.speed;
		  			altitude == undefined ? altitude='Mobile Only - ' : '';
		  			heading == undefined ? heading='Bugged - ' : '';
		  			speed == undefined ? speed='Bugged - ' : '';
		  			document.getElementById('lat').textContent = lat;
		  			document.getElementById('lon').textContent = lon;
		  			document.getElementById('lat2').textContent = lat2;
		  			document.getElementById('lon2').textContent = lon2;

		  			document.getElementById('altitude').textContent = altitude;
		  			document.getElementById('heading').textContent = heading;
		  			document.getElementById('speed').textContent = speed;
		  			
		  		});
		  	}
		  	else {
		  		console.log('geolocation IS NOT avaliable');
		  	}
		  </script>

		  <?php
		  	require '../vendor/autoload.php';
			$dotenv = Dotenv\Dotenv::create(dirname(__DIR__));
			$dotenv->load();
			$API_KEY = $_ENV['RAPID_API_KEY'];

		  	$response = Unirest\Request::get("https://community-open-weather-map.p.rapidapi.com/forecast?q=stockholm",
			  array(
			    "X-RapidAPI-Host" => "community-open-weather-map.p.rapidapi.com",
			    "X-RapidAPI-Key" => $API_KEY
			  )
			);
			echo '<p style="text-align: center"><span style="text-align:center;font-size:20px">Weather forecasts in Stockholm are:<br><br></span></p>';
			$responseBody = $response->body;

			$responseBodyRes1 = $responseBody->{'list'};
			$responseBodyRes2 = $responseBody->{'list'};
			$responseBodyRes3 = $responseBody->{'list'};

			$responseBodyRes1 = $responseBodyRes1[0];
			$responseBodyRes1 = $responseBodyRes1->{'weather'};
			$responseBodyRes1 = $responseBodyRes1[0];
			$responseBodyRes1 = $responseBodyRes1->{'description'};
			echo '<p style="text-align: center"><span style="text-align:center;font-size:30px">Tomorrow: </span></p><p style="text-align: center"><span style="color:gold;text-align:center;font-size:30px">' . $responseBodyRes1 . '</p><br><br></span></p>';

			$responseBodyRes2 = $responseBodyRes2[1];
			$responseBodyRes2 = $responseBodyRes2->{'weather'};
			$responseBodyRes2 = $responseBodyRes2[0];
			$responseBodyRes2 = $responseBodyRes2->{'description'};
			echo '<p style="text-align: center"><span style="text-align:center;font-size:30px">The day after tomorrow: </span></p><p style="text-align: center"><span style="color:gold;text-align:center;font-size:30px">' . $responseBodyRes2 . '</p><br><br></span></p>';

			$responseBodyRes3 = $responseBodyRes3[2];
			$responseBodyRes3 = $responseBodyRes3->{'weather'};
			$responseBodyRes3 = $responseBodyRes3[0];
			$responseBodyRes3 = $responseBodyRes3->{'description'};
			echo '<p style="text-align: center"><span style="text-align:center;font-size:30px">In three days: </span></p><p style="text-align: center"><span style="color:gold;text-align:center;font-size:30px">' . $responseBodyRes3 . '</p><br><br></span></p>';

		  ?>
			
		</div>
	</section>
</body>

</html>
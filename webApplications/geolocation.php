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
  

	<link
	  rel="stylesheet"
	  href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
	  integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
	  crossorigin=""
	/>
	<script
	  src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
	  integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
	  crossorigin=""
	></script>
	<style>
	  #issMap {
	    height: 400px;
	    width: 400px;
	    position: relative;
	    margin: auto;
	  }
	</style>
</head>



<body bgcolor="">
	<section class="mobile-wrapper">
		<div style="background:black" class="jumbotron mt-5 text-white border">
		  <h2 style="text-align:center; font-size:40px;">Geolocation<br></h2>
		  <h6 style="font-size: 16px; text-align: center"><span style="color:red">If nothing happens,<span> <a href="https://foxdropweb.000webhostapp.com/webApplications/geolocation.php">click here.</a><br></h6> 

		    <p style="font-size: 25px; text-align: center">
					<span id="lat"></span>° (latitude)
				<br>
					<span id="lon"></span>° (longitude)
				<br>
					<span id="altitude"></span>m (altitude)
	  				<!--
				<br>
					Heading: <span id="heading"></span>° (0° is north) 
				<br>
					Speed: <span id="speed"></span>m/s -->
			</p>
		</div>
	</section>

	<section class="mobile-wrapper">
		<div style="background:black" class="jumbotron mt-5 text-white border">
			<h2 style="text-align:center; font-size:40px;">Weather Forecast</h2>
			<div class="row mt-5 ">
				<div class="col">
					<form style="text-align:center" action="geolocationParams.php" method="GET">
						<input type="text" name="city" id="city" placeholder="Search for city..." style="width:11em; height: 2.7em; font-size: 20px">	
						<div class="w-100 mt-2"></div>
						<label style="color:red">Required: </label> <label style="color:grey"> e.g. Stockholm</label>
						<div class="w-100 mt-3"></div>
						
						<input type="text" name="lat" id="latInput" placeholder="Input latitude..." style="width:11em; height: 2.7em; font-size: 20px">
						<div class="w-100 mt-2"></div>
						<label style="color:grey;">Optional: e.g. 57.21</label>
						<div class="w-100 mt-2"></div>
						
						<input type="text" name="lon" id="lonInput" placeholder="Input longitude..." style="width:11em; height: 2.7em; font-size: 20px">
						<div class="w-100 mt-2"></div>
						<label style="color:grey;">Optional: e.g. 20.17</label>
						<div class="w-100 mt-4"></div>

						<button class="btn btn-lg btn-primary" type="submit" onClick="geolocationParams" style="width:11em; height: 3em"><span class="glyphicon glyphicon-search"></span> Search..</button>
					</form>
				</div>
			</div>
		</div>
	</section>


	<script> // JS
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
				document.getElementById('lat').textContent = lat.toFixed(2);
				document.getElementById('lon').textContent = lon.toFixed(2);

				document.getElementById('latInput').value = lat2.toFixed(2);
				document.getElementById('lonInput').value = lon2.toFixed(2);

				document.getElementById('altitude').textContent = altitude.toFixed(2);
				//document.getElementById('heading').textContent = heading;
				//document.getElementById('speed').textContent = speed;
			});
		}
		else {
			console.log('geolocation IS NOT avaliable');
		}
	</script>

	<!--
		<section class="mobile-wrapper">
			<div style="background:black" class="jumbotron mt-5 text-white border">
				<h2 style="text-align:center; font-size:35px; padding-bottom: 15%">Weather forecast in Stockholm are:<br></h2>
			  <?php
			  	/*
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
				*/
			  ?>
			</div>	
		</section>
	-->

	<h2 style="text-align:center; color:white; font-size:40px;">You are here</h2>
		<div id="issMap"></div>

		<script type="text/javascript">
			// Making a map and tiles
			const mymap = L.map('issMap');
			const attribution =
			'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
			const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
		  	const tiles = L.tileLayer(tileUrl, { attribution });
		  	tiles.addTo(mymap);

		  	// Making a marker with a custom icon
		    const issIcon = L.icon({
		        iconUrl: '../images/personIcon.png',
		        iconSize: [32, 32],
		        iconAnchor: [25, 16]
		    });
		    const marker = L.marker([0, 0], { icon: issIcon }).addTo(mymap);
		    let firstTime = true;

			async function getISS() {
				const latitude = lat;
				const longitude = lon;

				marker.setLatLng([latitude, longitude]);
		        if (firstTime) {
		          mymap.setView([latitude, longitude], 13); 
		          firstTime = false;
		        }
			}
			getISS();
			setInterval(getISS, 1000);
		</script>
		<h2 style="text-align:center; color:white; font-size:20px;">This information is used to give you accurate weather forecasts</h2>
		<br><br>
</body>

</html>
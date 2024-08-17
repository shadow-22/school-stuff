<?php
require_once 'core/init.php';
           $user = new User();
	$conn = mysqli_connect(Config::get('mysql/host'), Config::get('mysql/username'), Config::get('mysql/password'))
					or die("Error connecting to database: ".mysqli_error($conn));

	$db_name = Config::get('mysql/db');

	$db = mysqli_select_db($conn, $db_name)
					or die(mysqli_error($conn));
?>
		<div class='container'>
			<div class='page-header' style="text-align: center;">
				<h1>Αποτελέσματα Αναζήτησης</h1>
			</div>
			<br>

			<div id="map" style="height: 400px;
			width: 100%;"></div>
			<br><br>

			<div class='table-responsive'>
				<?php
					$query = $_POST['query'];
					$queryStringArray = explode(" ", $query);

					echo "<table class='table table-hover'>
							<tr>
								<th>Name</th>
								<th>Price</th>
            					<th>Stock</th>
            					<th>Latitube</th>
           						<th>Longitube</th>
            					<th>Description</th>
        				   		<th>Long Description</th>
     				        	<th>Type</th>
      				        	<th>Age group</th>
          				    	<th>Schedule</th>
           				    	<th>Προβολή</th>
							</tr>";

					# stores field 'id' of rows already printed
					# so that they're not repeated for multiply successful
					# keyword searches
					$temp_arr = array();

					# stores data for markers
					$places = array();

					function calculateDistance($lon2, $lat2, $lon1, $lat1, $unit = 'km', $decimals = 2) {
						$degrees = rad2deg(acos((sin(deg2rad($lat1))*sin(deg2rad($lat2)))
									 + (cos(deg2rad($lat1))*cos(deg2rad($lat2))*cos(deg2rad($lon1-$lon2)))));
						switch($unit) {
							case 'km':
								$distance = $degrees * 111.13384;
								break;
							case 'mi':
								$distance = $degrees * 69.05482;
								break;
							case 'nmi':
								$distance = $degrees * 59.97662;
						}
						return round($distance, $decimals);
					}


					$j = 0;
					for ($i = 0; $i < sizeof($queryStringArray); $i++) {
						$current_keyword = $queryStringArray[$i];
						$current_keyword = htmlspecialchars($current_keyword);
						$current_keyword = mysqli_real_escape_string($conn, $current_keyword);

						if ($current_keyword == "" || $current_keyword == " ")
							continue;

						// ##############################################################
						// parameters as given by the parent, assumed known
						if (isset( $_POST['age_low'])) $param_age_low = $_POST['age_low'];
						else $param_age_low = 1;

						if (isset($_POST['age_high'])) $param_age_high = $_POST['age_high'];
						else $param_age_high = 18;

						if (isset($_POST['price_low'])) $param_price_low = $_POST['price_low'];
					  else $param_price_low = 1;

						if (isset($_POST['price_high'])) $param_price_high = $_POST['price_high'];
						else $param_price_high = 100;

						// palio faliro
						// 37.926668, 23.697671
						//	$param_home_xcord = $_POST[''];
						$param_home_lat = 37.926668;
						//	$param_home_ycord = $_POST[''];
						$param_home_lon = 23.697671;

						// in km
						//  $param_radius = $_POST['radius'];
						$param_radius = 5000000000;

						if (isset( $_POST['type']))$param_type = $_POST['type'];
						else $param_type = "sports";

						// ################################################################
						// parameters end

						$sql_query = "SELECT * FROM `activity` WHERE (`eventname` LIKE '%".$current_keyword."%')
                      				  					    OR (`description` LIKE '%".$current_keyword."%')
                      				  				   		OR (`long_description` LIKE '%".$current_keyword."%')";

        				$raw_result = mysqli_query($conn, $sql_query)
                				      or die(mysqli_error($conn));

						if (mysqli_num_rows($raw_result) > 0) {
          					while ($result = mysqli_fetch_array($raw_result)) {
								$distance = calculateDistance($result['lng'], $result['lat'], $param_home_lon, $param_home_lat);

								if (!isset(	$temp_arr[$result['activity_id']]) /* &&
								  	$result['age_low'] >= $param_age_low &&
          	   	  					$result['age_high'] <= $param_age_high &&
            	    				$result['ticket_stock'] > 0 &&
              	  					$result['price'] >= $param_price_low &&
    	            				$result['price'] <= $param_price_high *//*&&
								  	$result['type'] == $param_type */&&
								  	$distance <= $param_radius) {
										$idarr[$j] = $result['activity_id'];
										$temp_arr[$result['activity_id']] = TRUE;

										echo "<tr>
												<td>".$result['eventname']."</td>
												<td>".$result['price']."</td>
                  		  	  					<td>".$result['ticket_stock']."</td>
 	                  	      					<td>".$result['lat']."</td>
  	                  	    					<td>".$result['lng']."</td>
    	                  	  					<td>".$result['description']."</td>
      	                  						<td>".$result['long_description']."</td>
         	 	                				<td>".$result['type']."</td>
          		              					<td>".$result['age_low']."-".$result['age_high']."</td>
            		            				<td>".$result['start_time']."-".$result['end_time']."</td>
																		<td><a class='btn btn-sm btn-warning' href='index.php?page=event&id=" . $result['activity_id'] . "'>Προβολή</a>
							  			 	 </tr>";

							  			$places[$j][0] = $result['lat'];
							  			$places[$j][1] = $result['lng'];
							  			$places[$j][2] = $result['eventname'];
							  			$places[$j][3] = $result['price'];
							  			$places[$j][4] = $result['ticket_stock'];
							  			$places[$j][5] = $result['type'];
							  			$places[$j][6] = $result['age_low'];
							  			$places[$j][7] = $result['age_high'];
							  			$places[$j][8] = $result['start_time'];
							  			$places[$j][9] = $result['end_time'];

							  			$places[$j][10] = $result['description'];
							  			$places[$j][11] = $result['long_description'];
							  			$j = $j + 1;
								}
							}
						}
						/*
						else {
							echo "No results for $current_keyword.";
						}
				 		*/
					}
					echo "</table>";

					if ($j == 0) {
						echo "<p style='text-align: center; font-size: 36px;'><b>No results.</b></p>";
					}

					mysqli_close($conn);
				?>
			</div>

			<script type="text/javascript">
				function initialize() {
					var idarr = <?php echo json_encode($idarr); ?>;
					var places = <?php echo json_encode($places); ?>;

					var MapCanvas = document.getElementById('map');
					var athens = {lat: 37.983810, lng: 23.727539};
					var options = {
						zoom: 5,
						center: athens
					};

					var map = new google.maps.Map(MapCanvas, options);

					for (i = 0; i < places.length; i++) {
						var new_marker = new google.maps.Marker({
							position: {lat: parseFloat(places[i][0]), lng: parseFloat(places[i][1])},
							map: map,
							title: places[i][2]
						});

						var infowindow = new google.maps.InfoWindow({
							content: contentString
						});
            var url = 'index.php?page=event&id=' + idarr[i];
						var contentString = "<div id='content'>" +
												"<div id='name'>" +
													"<p>Name: " + places[i][2] + "</p><br>" +
												"</div>" +
												"<div id='price'>" +
													"<p>Price: " + places[i][3] + "</p><br>" +
												"</div>" +
												"<div id='more_at'>" +
													"<a href=" + url + ">Click me for more</a>" +
											"</div></div>";

						new_marker.addListener('click', getInfoCallback(map, contentString));
					}
				}

				function getInfoCallback(map, content) {
					var infowindow = new google.maps.InfoWindow({content: content});
					return function() {
						infowindow.setContent(content);
						infowindow.open(map, this);
					};
				}
			</script>
			<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7_dawS4TKQmQS_s2pE88XhxRHKSSidc4&callback=initialize"></script>
		</div>

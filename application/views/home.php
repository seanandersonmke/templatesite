<table class="table table-hover">
	<tr>
		<td>Film Title</td>
		<td>Year</td>
		<td>Critic Rating</td>
		<td>Critic Score</td>
		<td>Audience Rating</td>
		<td>Audience Score</td>
		<td>Body Count</td>
	</tr>
<?php
foreach($data as $key => $value){
	$q = $value['film_id'];
	$apikey = 'w96gmegw6ezzwcuf64cgkcyw';
	// construct the query with apikey and query
	$endpoint = 'http://api.rottentomatoes.com/api/public/v1.0/movies/'.$q.'.json?apikey=' . $apikey;
	// setup curl to make a call to the endpoint
	$session = curl_init($endpoint);
	// indicates that we want the response back
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	// exec curl and get the data back
	$data = curl_exec($session);
	// close curl session once finished retrieveing data
	curl_close($session);
	// decode json
	$search_results = json_decode($data);
	//print_r($search_results);
	if ($search_results === NULL) die('Error parsing json');
	// the data
	//print_r($search_results);
	$ratings = $search_results->ratings;
	print_r($ratings);
	echo '<tr>';
	echo '<td><a href="'.base_url().'index.php/main_template/page/'.$value['film_id'].'">'.$search_results->title.'</a></td>';
	echo '<td>'.$search_results->year.'</td>';
	echo '<td>'.$ratings->critics_rating.'</td>';
	echo '<td>'.$ratings->critics_score.'</td>';
	echo '<td>'.$ratings->audience_rating.'</td>';
	echo '<td>'.$ratings->audience_score.'</td>';
	echo'<td>'.$value['film_total'].'</td>';
	echo '</tr>';
}
//print_r($film_title_text);
?>
</table>
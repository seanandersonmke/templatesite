<?php
$title      =  array(
               'name'        => 'heading',
               'placeholder' => 'Title',
               'class'		 =>	'form-control edit_heading'
            	);
$article   =  array(
               'name'        => 'article',
               'placeholder' => 'Text',
               'class'		 => 'form-control edit_body'
            	);            	 
$update_id = 'id="edit_form"';
?>

<div class="col-md-4">
	<ul>
<?php
foreach ($titles as $key => $value) { 
	$q = $value['film_id'];
	//print_r($titles);
	//$q = '10008'; 
	//$q = urlencode($term); //url encode query parameters
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
	//print_r($search_results->title);
	?>
	<li><span><?=$search_results->title?></span> - <a href="#" onclick="get_author_edit(<?=$value['item_id'];?>)"><?=$value['heading'];?></a></li>
	
	<?php }	?>
	</ul>
</div>
<div class="col-md-8">
<?=form_open('/update/save_entry', $update_id);?>

	<div class="form-group">
    	<label for="heading">Edit Title</label>
    	<?=form_input($title, '');?>
    </div>
    <div class="form-group">
    	<label for="heading">Article Title</label>
    	<?=form_textarea($article, '');?>
    </div>
<?=form_close();?>
</div>
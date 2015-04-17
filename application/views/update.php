<?php
//get the film info
if(isset($_POST['movie_select'])){
	$q = $_POST['movie_select'];
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
	// the data
	//$newmovies = $search_results->movies;
	$film_title_text = $search_results->title;
	$this_actors = $search_results->abridged_cast;
	//	$term = $_POST['movie_select'];

	$endpoint = 'http://api.rottentomatoes.com/api/public/v1.0/movies/'.$q.'/cast.json?apikey=' . $apikey;
	// setup curl to make a call to the endpoint
	$session = curl_init($endpoint);
	// indicates that we want the response back
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	// exec curl and get the data back
	$data = curl_exec($session);
	// close curl session once finished retrieveing data
	curl_close($session);
	// decode json
	$search_results_unabridged = json_decode($data);
	if ($search_results_unabridged === NULL) die('Error parsing json');
	// the data
	//$newmovies = $search_results->movies;
	$unabridged_actors = $search_results_unabridged->cast;
	//print_r($unabridged_actors);
}
//end get film info

foreach ($get_cat as $key => $the_value) {
	$cat_value = $the_value['cat_title'];
	$cat_id = $the_value['cat_id'];
	$cats = array($cat_id => $cat_value);
	foreach ($cats as $key => $value) {
		$cat[$key] = $value;
	}
	
}
//set form attributes
//$attributes =  array('class' => 'pure-form pure-form-stacked');
$title      =  array(
               'name'        => 'heading',
               'placeholder' => 'Title',
               'class'		 =>	'form-control'
            	); 
$cust_body_cnt =  array(
               'name'        => 'body_count',
               'class'		 =>	'form-control'
            	);
$article   =  array(
               'name'        => 'article',
               'placeholder' => 'Text'
            	);
$cat_title  =  array(
               'name'        => 'cat_title',
               'placeholder' => 'Text',
               'class'		 =>	'form-control'
            	);
$cat_name   =  array(
               'name'        => 'cat_id',
               'placeholder' => 'Text',
            	);
$cat_id     =  'id="cat_options" class="form-control"' ;
$option_class = 'class="form-control"';
$update_id = 'id="update_form"';
?>
<!-- left column-->

<legend class="text-center">Film title: <?=$film_title_text?></legend>
<!--
<div class="col-md-12">
<?=form_open('update/add_category');?>
	<label for="category">Category Title</label>
    <?=form_input($cat_title, '');?>
    <button type="submit" id="add_cat" class="btn btn-primary">Add Category</button> 
<?=form_close();?>
</div>
-->
<div id="event_form" class="col-md-12">
<?=form_open('/update/save_entry', $update_id);?>
<div class="col-md-4">
	<input type="hidden" name="film_id" value="<?=$q?>">
	 <div class="form-group">
		<label for="add_category">Add Category</label>
		<?=form_dropdown('cat_id', $cat, '', $cat_id );?>
	</div>
	<div class="form-group">
    	<label for="heading">Article Title</label>
    	<?=form_input($title, '');?>
    </div>
    <?=form_textarea($article, '');?>
</div>
<div class="col-md-4">
    <div class="well">
		<div class="form-group">
			<label for="heading">Add Custom Body Count Field</label>
			<input type="text" class="form-control" name="body_count">
			<button class="btn btn-primary" id="custom_body_cnt">Add Custom Body Count Field</button>
		</div>		
    </div>

    
    	<div class="panel panel-primary">
    	<div class="panel-heading">Abridged Cast</div>
        	<div class="panel-body abridged-hide">
        <?php 
       //print_r($search_results);
        foreach ($this_actors as $this_actor['name']) {
        	if(isset($this_actor['name']->characters[0])){
        		$characters = $this_actor['name']->characters[0];
        	}else{
        		$characters = '';
        	}
        	
			echo "<span class='btn btn-primary draggable'><input type='hidden' class='actor_field' name='actor_id[]' value='".$this_actor['name']->id."'><span class='glyphicon glyphicon-resize-vertical' aria-hidden='true'></span> ".$this_actor['name']->name." - ".$characters."</span>";}?>
			</div>
		</div>
		
		
		<button id="slide-abridged" class="btn wide-button"><span class='glyphicon glyphicon-resize-vertical' aria-hidden='true'></span></button>
		
		<div class="panel panel-primary">
		<div class="panel-heading">Unabridged Cast</div>
		<button class="slide-unabridged btn wide-button"><span class='glyphicon glyphicon-resize-vertical' aria-hidden='true'></span></button>
			<div class="panel-body unabridged-hide">
        <?php 
        foreach ($unabridged_actors as $this_actor['name']) {
        	
        	//print_r($characters_b);
        	if(isset($this_actor['name']->characters[0])){
        		$characters = $this_actor['name']->characters[0];
        	}else{
        		$characters = '';
        	}
			echo "<span class='btn btn-primary draggable'><span class='glyphicon glyphicon-resize-vertical' aria-hidden='true'><input type='hidden' name='actor_id[]' value='".$this_actor['name']->id."'></span> ".$this_actor['name']->name." - ".$characters."</span>";
		}?>
			</div>
		</div>
		<button class="slide-unabridged btn wide-button"><span class='glyphicon glyphicon-resize-vertical' aria-hidden='true'></span></button>
		</div>
		<div class="col-md-4">

			<span class="label label-default">Body Count Inventory</span>
			<div class="well drop-container clearfix">
				<table class="table">				
					<tr>
						<td class="btn btn-primary">Total</td>
						<td class="badge"><input placeholder="Number of Kills" name="film_total" class="film_total" disabled type="number"></td>
					</tr>
				</table>
			</div>
        <button type="submit" id="entry_submit" class="btn btn-primary">Update Page</button>
	</div>
	<?=form_close()?>

</div>

<!-- right column-->



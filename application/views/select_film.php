<?php
$search_form =  array('id' => 'movie-search' );
$select_film =  array('id' => 'film_select_form');
$movie_term  =  array(
               'name'        => 'movie_term',
               'placeholder' => 'Search',
               'class'     => 'form-control'
               );?>
<div class="search-body clearfix">
  <div class="search-container">
    <?=form_open('update/add_category', $search_form);?>
    <div class="form-group">
    <label for="add_category">Find a film</label>
      <?=form_input($movie_term, '');?>
    </div>
      <button type="submit" class="btn btn-primary">Find Film</button>
    <?=form_close()?>
  </div>

  <?=form_open('/update/add_entry', $select_film);?>
      <div id="film_data"></div>
      <button type="submit" id="film_select_button" class="btn btn-primary">Select this Film</button>
  <?=form_close()?>

</div>
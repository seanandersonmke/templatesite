</div><!-- close #layout from header-->
 <script src="<?=base_url()?>ckeditor/ckeditor.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?=base_url()?>/js/jquery-ui.min.js"></script>
 <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'article' );
            </script>        
<script>

//*************************************
// Sortable function for CMS
//*************************************
var sort = $("#sortable").sortable();
function saveDisplayChanges(){
	var itemid = $("#sortable").sortable("serialize");
	$.post("update_drag",itemid,function(theResponse){
		$('.verify').html('Your order has been saved');
	});
}
$(".verify_delete").submit(function(event) {
   var answer = confirm( "Are you sure you would like to delete this page? This action cannot be undone." );
   if(!answer){
        event.preventDefault();
    }
});

//*************************************
// Draggable function for CMS Update page 
//*************************************
$( ".draggable" ).draggable({
  addClasses: false,
  snap: true,
  snapTolerance: 40,
  });

$( ".drop-container" ).droppable({
  accept: ".draggable",
  addClasses: false,
  drop: function(event, ui) {
    var drag_name = ui.draggable.html();
    console.log(drag_name);
    ui.draggable.hide();
    var test = $('.table'); 
    var new_body_count = '<tr><td class="btn btn-primary">'+drag_name+'</td><td class="badge"><input placeholder="Number of Kills" name="body_count[]" class="number-count" type="number"></td></tr>'
    $(test).prepend(new_body_count);
   //console.log(drag_id);
  }
});

$('#event_form').on('submit', 'form', function(){
    //event.preventDefault();
    $('.abridged-hide input').attr('disabled', true);
    $('.unabridged-hide input').attr('disabled', true);
    $('.film_total').attr('disabled', false);
    });
 
function delItem(item_id){
    var answer = confirm ("Are you sure you want delete this entry?");
    if (answer){
        $.ajax({
            url: "order/",
            type: "POST",
            data: { "item_id" : item_id },
            success:function(){
                $('#itemid_'+item_id).remove();
            } 
        });
    }
}
function get_author_edit(item_id){
        $.ajax({
            url: "get_author_edit",
            type: "POST",
            dataType:"json",
            data: { "item_id" : item_id },
            success:function(data){
              //console.log(data);
                $('.edit_heading').val(data[0]["heading"]);
                //$('.edit_body').val(data[0]["article"]);
                CKEDITOR.instances.article.setData(data[0]["article"], function(){
                this.checkDirty();
                });
                  //  console.log(data);
                $.each(data, function(index, value){
                //  console.log(this.actor_rt_id);
                  //$.post( "http://api.rottentomatoes.com/api/public/v1.0/movies/" + this.film_id+".json?apikey=w96gmegw6ezzwcuf64cgkcyw", function( data ) {
                   //console.log(data);
                  //});
                $.ajax({
            type:"GET",
            
            beforeSend: function (request)
            {
                request.setRequestHeader("X-Originating-Ip", "184.58.222.61");
            },
            url: "http://api.rottentomatoes.com/api/public/v1.0/movies/" + this.film_id+".json?apikey=w96gmegw6ezzwcuf64cgkcyw&callback=mycallbackfn",
            success: function(msg) {
                console.log(msg);
            }
    });
                });    
        }
        });
    }
$( "#custom_body_cnt" ).on("click", function( event ) {
    event.preventDefault();
    //var $form = $( this );
    var term = $( "input[name='body_count']" ).val();
    var custom_body_count = '<tr><td class="btn btn-primary"><input type="hidden" name="field_title[]" value="'+term+'">'+term+'</td><td class="badge"><input placeholder="Number of Kills" name="custom_count[]" type="number" class="number-count"></td></tr>'
    $('.table').prepend(custom_body_count);
    $( "input[name='body_count']" ).val('');
});

//*************************************
// Sum of Form Values
//  - Additions of values and return to Total input
//*************************************
$( ".table").on("change", "input", function(){
        calculateSum();
        });

function calculateSum(){
    var sum=0;$(".number-count").each(function(){
        if(!isNaN(this.value)&&this.value.length!=0){
            sum+=parseFloat(this.value);
        }
    });
    $('.film_total').val(sum);
    //$(".film_total").html(sum.toFixed(2));
}

/*
$( "#add_actor" ).submit(function( event ) {
  event.preventDefault();
  var $form = $( this ),
    term = $form.find( "input[name='actor_name']" ).val(),
    final_term = '<option value="'+term+'">'+term+'</option>',
    url = $form.attr( "action" );
     $.ajax({
            url: url,
            type: "POST",
            data: { "actor_name" : term },
            success:function(){
                $('#actor_tag').append(final_term);
            } 
        });   
});
*/
$( "#add_cat" ).on("click",function( event ) {
  event.preventDefault();
  var $form = $( this ),
    //id = $form.find( "input[name='cat_title']" ).val(),
    value = $form.find( "#cat_options option:selected" ).text(),
    final_term = '<option value="'+value+'">'+value+'</option>',
    url = $form.attr( "action" );
    console.log($form);
     $.ajax({
            url: url,
            type: "POST",
            data: { "cat_id" : id },
            success:function(){
                $('#cat_options').append(final_term);
            } 
        });   
});


$( "#cat_options" ).submit(function( event ) {
  event.preventDefault();
  var $form = $( this ),
    term = $form.find( "input[name='cat_name']" ).val(),
    final_term = '<option value="'+term+'">'+term+'</option>',
    url = $form.attr( "action" );
     $.ajax({
            url: url,
            type: "POST",
            data: { "actor_name" : term },
            success:function(){
                $('#actor_tag').append(final_term);
            } 
        });   
});
//*************************************
// Toggle Slide Buttons
//  - Toggle slides Actor containers in CMS
//*************************************
$("#slide-abridged").on("click", function( event ){
    event.preventDefault();
    $(".abridged-hide").slideToggle(500);
});
$(".slide-unabridged").on("click", function( event ){
    event.preventDefault();
    $(".unabridged-hide").slideToggle(500);
});

//*************************************
// Movie Search
//  - Retrieves films for movie search in CMS
//*************************************
$( "#movie-search" ).submit(function( event ) {
    event.preventDefault();
    var $form = $( this );
    var term = $form.find( "input[name='movie_term']" ).val();
    $('#film_data').empty(); 
    term = encodeURI(term);    
    $.ajax({
            url: "http://api.rottentomatoes.com/api/public/v1.0/movies.json?q="+term+"&page_limit=10&apikey=w96gmegw6ezzwcuf64cgkcyw",
            type: "GET",
            dataType: "jsonp",
            success:function(data){
                var outer = data['movies'];
                console.log(outer);
                $.each(outer, function(index, value){
                  var film_poster = value['posters']['thumbnail'];
                  var film_title = value['title'];
                  var film_year = value['year'];
                  var film_id = value['id'];
                  $('#film_data').hide().append("<div class='col-md-2 movie-item'><input type='radio' value='"+film_id+"' name='movie_select'><img src='"+film_poster+"'><h3>"+film_title+" - "+film_year+"</h3></div>").slideDown(500, function(){
                    $('#film_select_button').slideDown(500);
                  });
                  //var cast = value['abridged_cast'];
                  //console.log(cast);
                 // $.each(cast, function(index, value){
                    //var cast_group = value['name'];
                   // $('.pure-u-1-4').append("<p>"+cast_group+"</p>");
                 //})  
                })
            } 
        });
});

</script>
    </body>
</html>
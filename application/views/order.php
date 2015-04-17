

<div class="pure-u-1 pure-u-md-1 order">
<p>Drag and drop, then click Save Order to edit order. Click the X button to delete an entry.</p>
<table class="pure-table pure-table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Heading</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody id="sortable">
<?php

foreach($data as $item){
	$id = $item["item_id"];
	echo '<tr id="itemid_'.$item['item_id'].'">';
	echo '<td><button class="opac_button" onclick="delItem('.$id.')" href=""><i class="fa fa-close"></i>Delete</button</td>';
	echo '<td>'.$item['heading'].'</td>';
	echo '<td>'.$item['descript'].'</td>';
	echo '</tr>';
}
?>
	</tbody>
</table>
<button class="pure-button pure-button-primary" onclick="saveDisplayChanges()">Save Order</button>
<h3 class="verify"></h3>
</div>
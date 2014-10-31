<?php
/*
 * this file showing existing meta group
* in admin
*/

global $nmpersonalizedproduct;
echo '<hr/>';
echo '<h3>'.__('Existing Product Meta', 'nm-personalizedproduct').'</h3>';
?>


<table border="0" class="wp-list-table widefat plugins">
	<thead>
		<tr>
			<th style="width: 300px;"><?php _e('Name.', 'nm-personalizedproduct')?></th>
			<th style="width: 500px;"><?php _e('Meta.', 'nm-personalizedproduct')?></th>
			<th style="width: 300px;"><?php _e('productmeta.', 'nm-personalizedproduct')?></th>
			<th><?php _e('Delete.', 'nm-personalizedproduct')?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th><?php _e('Name.', 'nm-personalizedproduct')?></th>
			<th><?php _e('Meta.', 'nm-personalizedproduct')?></th>
			<th><?php _e('Shortcode.', 'nm-personalizedproduct')?></th>
			<th><?php _e('Delete.', 'nm-personalizedproduct')?></th>
		</tr>
	</tfoot>
	
	<?php 
	$all_forms = $nmpersonalizedproduct -> get_product_meta_all();
	
	foreach ($all_forms as $productmeta):
	
	$url_edit = $nmpersonalizedproduct -> nm_plugin_fix_request_uri(array('productmeta_id'=> $productmeta ->productmeta_id, 'do_meta'=>'edit'));
	$url_clone = $nmpersonalizedproduct -> nm_plugin_fix_request_uri(array('productmeta_id'=> $productmeta ->productmeta_id, 'do_meta'=>'clone'));	
	?>
	<tr>
		<td><a href="<?php echo $url_edit?>"><?php echo stripcslashes($productmeta -> productmeta_name)?></a><br>
		<a href="<?php echo $url_edit?>"><?php _e('Edit', 'nm-personalizedproduct')?></a> |
		<a href="<?php echo $url_clone?>"><?php _e('Clone', 'nm-personalizedproduct')?></a><br> 
		<?php echo $form_detail?>
		</td>
		<td><?php echo $nmpersonalizedproduct -> simplify_meta($productmeta -> the_meta)?></td>
		<td><em>[nm-wp-contact productmeta_id="<?php echo $productmeta -> productmeta_id?>"]</em></td>
		<td><a href="javascript:are_sure(<?php echo $productmeta -> productmeta_id?>)"><img id="del-file-<?php echo $productmeta -> productmeta_id?>" src="<?php echo $nmpersonalizedproduct -> plugin_meta['url'].'/images/delete_16.png'?>" border="0" /></a></td>
	</tr>
	<?php 
	endforeach;
	?>
</table>

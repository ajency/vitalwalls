<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     99.99
 */
?>

<?php do_action('woocommerce_share'); // Sharing plugins can hook into here 
global $pmc_data;?>
	
	<div class="socialProduct" >
			<div class="socialSP"><?php  vital_socialLinkSingle()  ?></div>
	</div>
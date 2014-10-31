<?php 
/*
 Plugin Name: N-Media WooCommerce Personalized Product Meta Manager
Plugin URI: http://www.najeebmedia.com
Description: This plugin allow WooCommerce Store Admin to create unlimited input fields and files to attach with Product Page
Version: 3.5
Author: Najeeb Ahmad
Text Domain: nm-personalizedproduct
Author URI: http://www.najeebmedia.com/

Changelog:
3.5	- BUG Fixed: un-necessary meta values are removed from cart/checkout pages
	- Dynamic price handling optimized
3.4
	- Add product_id before uploaded file when order is confirmed
	- '_product_attached_files' is removed from Cart page
	- BUG: fixed when more then one file is uploaded these are moved to confirmed dir
	- BUG: fixed error while duplicating Woo Products.
3.3
	- show edited photo in cart page thumb
	- allow bulk meta group to applied on product list 
	- autoupload on file select
	- BUG: do not show editing tools if disabled
3.2
	- User new input framework (classes based)
	- Pre uploaded images field
	- use color picker field
	- croping option
	- new uploader
	- Mask input 
	- Max characters restriction
	- dynamic prices
	- Better price/options control
	- remove unpaid order images after one day (check pending) : CP
	- move paid orders into another direcotory
	- rename uploaded images with order number prefix.
	- Clone existing meta with one click
	- i18n localized ready (Not yet)
	- Download link in email
	- New date format: dd/mm/yy (with digist year)
	- Ok Thank you. Also, is it possible to re-arrange the date from \day\ 7 \of\ January \in the year\ 2014 to  \month\ January \day\ 7\in the year\ 2014
	- Now Html can be used in title and description

3.1
 	- conditional logic for select, radio and checkbox
 	- BUG Fixe: validation issue with radio type is fixed
3.0
New plugin admin interface
	- drag & drop input fields
	- radio button
	- set max/min checkbox selection
Photo Editing with Aviary
Unlimited file upload instances
CSS/Styling editor
Sections		
Add customized error message
Add class name against each input wrapper
Define width of each field
2.0.8 -
HTML5 Fallback for IE
Now Simple product meta data can be shown on cart/checkout/email
Thumbs will be shown on cart/checkout/email
2.0.7 -
* Fixed: multiple pricing when using Select input type
2.0.6 -
* Added Datepicker input type
* Data labels are more readable
2.0.5 -
now the product meta will be shown in cart page.
2.0.4 -
remove JS bug when uploading and delete file, it won't show old file then
*/


/*
 * Lets start from here
*/

/*
 * loading plugin config file
 */
$_config = dirname(__FILE__).'/config.php';
if( file_exists($_config))
	include_once($_config);
else
	die('Reen, Reen, BUMP! not found '.$_config);


/* ======= the plugin main class =========== */
$_plugin = dirname(__FILE__).'/classes/plugin.class.php';
if( file_exists($_plugin))
	include_once($_plugin);
else
	die('Reen, Reen, BUMP! not found '.$_plugin);

/*
 * [1]
 */

$nmpersonalizedproduct = NM_PersonalizedProduct::get_instance();
NM_PersonalizedProduct::init();
//nm_personalizedproduct_pa($nmpersonalizedproduct);

if( is_admin() ){

	$_admin = dirname(__FILE__).'/classes/admin.class.php';
	if( file_exists($_admin))
		include_once($_admin );
	else
		die('file not found! '.$_admin);

	$nmpersonalizedproduct_admin = new NM_PersonalizedProduct_Admin();
}


/*
 * activation/install the plugin data
*/
register_activation_hook( __FILE__, array('NM_PersonalizedProduct', 'activate_plugin'));
register_deactivation_hook( __FILE__, array('NM_PersonalizedProduct', 'deactivate_plugin'));



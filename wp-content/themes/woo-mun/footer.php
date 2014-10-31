<?php
global $pmc_data, $sitepress;
?>

<!-- footer-->
<div class="totop"><div class="gototop"><div class="arrowgototop"></div></div></div>
<?php if(isset($pmc_data['show_support'])){ ?>
	<div class="bottom-support-tab">
		<?php dynamic_sidebar( 'bottom_support_tab' ); ?>
	</div>
<?php } ?>
<footer>
	<div id="footer">
		<!-- main footer part-->
		<div id="footerinside">
			<div class="footer_widget">
				<!-- footer widget 1-->
				<div class="footer_widget1">
					<?php dynamic_sidebar( 'footer1' ); ?>				
				</div>	
				<!-- footer widget 2-->
				<div class="footer_widget2">	
					<?php dynamic_sidebar( 'footer2' ); ?>
				</div>	
				<!-- footer widget 3-->
				<div class="footer_widget3">	
					<?php dynamic_sidebar( 'footer3' ); ?>
				</div>
				<!-- footer widget 4-->
				<div class="footer_widget4 last">	
					<?php dynamic_sidebar( 'footer4' ); ?>
				</div>				
			</div>
		</div>
		<!-- footer bar at the bootom-->
		<div id="footerbwrap">
			<div id="footerb">
				<div class="lowerfooter">
				<div class="footernav">
					<?php dynamic_sidebar( 'footer_bottom' ); ?>
				</div>
				<div class="copyright">	
					<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo pmc_stripText($pmc_data['copyright']); } else {  _e('&copy; 2011 All rights reserved. ','wp-munditia'); } ?>
				</div>
				</div>
			</div>
		</div>

	</div>
</footer>	
<script type="text/javascript" > jQuery(document).ready(function(){jQuery("a[rel^='lightbox']").prettyPhoto({theme:'light_rounded',show_title: false, deeplinking:false,callback:function(){scroll_menu()}});  });</script>
<input type="hidden" id="root" value="<?php echo get_template_directory_uri() ?>" >
<?php wp_footer();  ?>
</body>
</html>


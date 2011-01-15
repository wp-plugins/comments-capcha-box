<?php
/*
Plugin Name: Zoom Capcha
Plugin URI: http://digitalzoomstudio.net/
Description: Creates a capcha box in the comments to prevent unwanted spam.
Version: 1.0
Author: Digital Zoom Studio
Author URI: http://digitalzoomstudio.net/
*/

//Plugin Path
	$WPZpath = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

add_action('admin_menu', 'wpz_admin_menu');
add_action('init', 'wpz_init');
add_action('wp_footer','wpz_footer');

add_action('wp_ajax_capcha_ajax', 'wpz_capcha_ajax');

  $capchaId = get_option("wpz_capchaid");
  if($capchaId=='')
  $capchaId="submit";
  
function wpz_capcha_ajax() {
	global $wpdb; // this is how you get access to the database

	$capchaId = $_POST['capchaId'];
      update_option("wpz_capchaid",$capchaId);
        echo $capchaId;

	die();
}

function wpz_init(){
wp_enqueue_script( 'jquery' );
}
function wpz_footer(){
?>
<style type="text/css">
.capcha-text{
	position:relative;
	width:200px;!important
	}
	
#respond .form-submit input {
	width:200px;!important
}
</style>
<script>
var submitId = "#<?php global $capchaId; echo $capchaId; ?>";
var capchaValues = ['','45723','1764','9407','8906'];
var randomNr = parseInt(Math.random()*4+1);
var capchaDiv = '<div class="capcha-div"><img src="<?php global $WPZpath; echo $WPZpath; ?>img/'+randomNr+'.jpg"/><br><input type="text" class="capcha-text" onChange="wpz_checkText();"></input></div>';
jQuery(document).ready(function(){
	jQuery(submitId).parent().prepend(capchaDiv);
	//console.log(jQuery('.capcha-text'));
	//jQuery('.capcha-text').bind('change', wpz_checkText);
	jQuery('.capcha-text').change(wpz_checkText);
	jQuery('.capcha-text').mouseleave(wpz_checkText);
	jQuery(submitId).attr('disabled', 'disabled');
	})
function wpz_checkText(){
	if(jQuery('.capcha-text').val()==capchaValues[randomNr])
	jQuery(submitId).removeAttr('disabled');
	else
	jQuery(submitId).attr('disabled', 'disabled');
}
</script>
<?php
}
function wpz_admin_menu(){
    $page = add_options_page('WP Zoom Capcha', 'Zoom Capcha', 'administrator', 'wpz_menu', 'wpz_menu_function');
    
}
class wpz_test{

function __construct(){
	//echo 'dadaaa';
}
function test(){
	//echo 'ceva';
}
}
wpz_test::test();

$ceva = new wpz_test();
$ceva->test();

function wpz_menu_function(){
?>
<style type="text/css">

.settings{
width:555px;
background: #f1f1f1;
-moz-border-radius: 10px;
border-radius: 10px;

border: 1px solid #e3e3e3;

padding:10px 10px 10px 10px;
margin-top: 10px;
}

.settings h3{
margin-top:0px;
margin-bottom:0px;
}

.settings_cont{
margin-top:10px;
}
#ajax-loading{
	position:relative;
	top:3px;
	}

</style>
<div class="wrap">
<h2>Options</h2>
<div class="settings">enter submit button id: <input type="text" id="capcha-id" value="submit"/>   <button id="capcha-submit" class="button-secondary action">submit</button>
<img alt="" style="visibility: hidden;" id="ajax-loading" src="http://localhost/wordpress/wp-admin/images/wpspin_light.gif">
</div>

</div>
<script>
jQuery(document).ready(function(){
   jQuery("#capcha-submit").click(sendcapchaId);
   
})

function sendcapchaId(){
	jQuery("#ajax-loading").css({
		'visibility':'visible'
				})
	var data = {
		action: 'my_special_action',
		capchaId: jQuery("#capcha-id").val()
	};

	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	jQuery.post(ajaxurl, data, function(response) {
		jQuery("#ajax-loading").css({
		'visibility':'hidden'
				})
	});
}
</script>
<?php
}

?>
<?php
/*
Plugin Name: I Like This
Plugin URI: http://www.benoitburgener.com/blog/plugin-wordpress-i-like-this
Description: This plugin allows your visitors to simply like your posts instead of commment it.
Version: 1.4b
Author: Benoit "LeBen" Burgener
Author URI: http://benoitburgener.com

Copyright 2009  BENOIT LEBEN BURGENER  (email : CONTACT@BENOITBURGENER.COM)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

#### LOAD TRANSLATIONS ####

load_plugin_textdomain('i-like-this', 'wp-content/plugins/i-like-this/lang/', 'i-like-this/lang/');

####


#### INSTALL PROCESS ####

function setOptionsILT() {
	add_option('ilt_jquery', '1', '', 'yes');
	add_option('ilt_onPage', '1', '', 'yes');
	add_option('ilt_textOrImage', 'image', '', 'yes');
	add_option('ilt_text', 'I like This', '', 'yes');
}

register_activation_hook(__FILE__, 'setOptionsILT');

function unsetOptionsILT() {
	delete_option('ilt_jquery');
	delete_option('ilt_onPage');
	delete_option('ilt_textOrImage');
	delete_option('ilt_text');
}

register_deactivation_hook(__FILE__, 'unsetOptionsILT');

####


#### ADMIN OPTIONS ####

function ILikeThisAdminMenu() {
	add_options_page('I Like This', 'I Like This', '3', 'ILikeThisAdminMenu', 'ILikeThisAdminContent');
}
add_action('admin_menu', 'ILikeThisAdminMenu');

function ILikeThisAdminRegisterSettings() { // whitelist options
	register_setting( 'ilt_options', 'ilt_jquery' );
	register_setting( 'ilt_options', 'ilt_onPage' );
	register_setting( 'ilt_options', 'ilt_textOrImage' );
	register_setting( 'ilt_options', 'ilt_text' );
}
add_action('admin_init', 'ILikeThisAdminRegisterSettings');

function ILikeThisAdminContent() {
?>
<div class="wrap">
<h2>"I Like This" Options</h2>
<form method="post" action="options.php">
<?php settings_fields('ilt_options'); ?>
<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="ilt_jquery"><?php _e('jQuery framework', 'i-like-this'); ?></label></th>
		<td>
			<select name="ilt_jquery" id="ilt_jquery">
				<?php echo get_option('ilt_jquery') == '1' ? '<option value="1" selected="selected">'.__('Enabled', 'i-like-this').'</option><option value="0">'.__('Disabled', 'i-like-this').'</option>' : '<option value="1">'.__('Enabled', 'i-like-this').'</option><option value="0" selected="selected">'.__('Disabled', 'i-like-this').'</option>'; ?>
			</select>
			<span class="description"><?php _e('Disable it if you already have the jQuery framework enabled in your theme.', 'i-like-this'); ?></span>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><legend><?php _e('Image or text?', 'i-like-this'); ?></legend></th>
		<td>
			<label for="ilt_textOrImage" style="padding:3px 20px 3px 0; margin-right:20px; background: url(<?php echo WP_PLUGIN_URL.'/i-like-this/css/add.png'; ?>) no-repeat right center;">
			<?php echo get_option('ilt_textOrImage') == 'image' ? '<input type="radio" name="ilt_textOrImage" id="ilt_textOrImage" value="image" checked="checked">' : '<input type="radio" name="ilt_textOrImage" id="ilt_textOrImage" value="image">'; ?>
			</label>
			<label for="ilt_text">
			<?php echo get_option('ilt_textOrImage') == 'text' ? '<input type="radio" name="ilt_textOrImage" id="ilt_textOrImage" value="text" checked="checked">' : '<input type="radio" name="ilt_textOrImage" id="ilt_textOrImage" value="text">'; ?>
			<input type="text" name="ilt_text" id="ilt_text" value="<?php echo get_option('ilt_text'); ?>" />
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><legend><?php _e('Automatic display', 'i-like-this'); ?></legend></th>
		<td>
			<label for="ilt_onPage">
			<?php echo get_option('ilt_onPage') == '1' ? '<input type="checkbox" name="ilt_onPage" id="ilt_onPage" value="1" checked="checked">' : '<input type="checkbox" name="ilt_onPage" id="ilt_onPage" value="1">'; ?>
			<?php _e('<strong>On all posts</strong> (home, archives, search) at the bottom of the post', 'i-like-this'); ?>
			</label>
			<p class="description"><?php _e('If you disable this option, you have to put manually the code', 'i-like-this'); ?><code>&lt;?php if(function_exists(getILikeThis)) getILikeThis('get'); ?&gt;</code> <?php _e('wherever you want in your template.', 'i-like-this'); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><input class="button-primary" type="submit" name="Save" value="<?php _e('Save Options', 'i-like-this'); ?>" /></th>
		<td></td>
	</tr>
</table>
</form>

<div style="padding-top:20px; padding-left:10px;"> <!-- los que más gustan -->

	<h2 style="padding-bottom:20px;">Los que más gustan</h2>

	<?php 
		global $wpdb;
			$resultados = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key  = '_liked' ORDER BY CAST(meta_value AS UNSIGNED) DESC LIMIT 20");
			foreach ($resultados as $resultado) {
				$titulo = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID = ".$resultado->post_id."");				
				echo '<div style="float:left; width:620px; padding-left:"><a href="'.$titulo->guid.'" target="_new">'.$titulo->post_title.'</a></div><div style="float:left;">Le gusta a '.$resultado->meta_value.' personas</div><br />';
			}
	?>



</div><!-- //los que más gustan -->




</div>
<?php
}

####


#### PLUGIN CORE ####

function getILikeThis($arg,$pag) {
	$post_ID = get_the_ID();
	
    $liked = get_post_meta($post_ID, '_liked', true) != '' ? get_post_meta($post_ID, '_liked', true) : '<span style="color:#CE7940;">0</span>';
	
	//$counter = !isset($_COOKIE['liked-'.$post_ID]) ? '<a onclick="likeThis('.$post_ID.');">'.$liked.'</a>' : $liked;
    
    if (!isset($_COOKIE['liked-'.$post_ID])) {
    	if (get_option('ilt_textOrImage') == 'image') {
    		$counter = 'a <a onclick="likeThis('.$post_ID.');" class="image">'.$liked.'</a> personas les gusta';
    	}
    	else {
    		if($liked == 1)
    			$counter = 'A <span style="color:#CE7940;">'.$liked.'</span> persona le gusta. ';
    		else
    		{
    			if($liked == 0)
    				$counter = '';
    			else
    				$counter = 'A <span style="color:#CE7940;">'.$liked.'</span> personas les gusta. ';
    		}
    		
    		$counter .= '<span><a onclick="likeThis('.$post_ID.');" style="color:#CE7940;">'.get_option('ilt_text').'</a></span>';
    	}
    }
    else {
    	if($liked == 1)
    		$counter = '<span>A <span style="color:#CE7940;">'.$liked.'</span> persona le gusta</span>';
    	else
    		$counter = '<span>A <span style="color:#CE7940;">'.$liked.'</span> personas les gusta</span>';
    }
    
    $iLikeThis = '<div id="iLikeThis-'.$post_ID.'" class="iLikeThis">';
    if($pag == 'single')
    	$iLikeThis .= '<p class="gusta">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="counter">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$counter.'</span></p>';
    else
    	$iLikeThis .= '<p class="gustar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="counter">&nbsp;&nbsp;&nbsp;&nbsp;'.$counter.'</span></p>';
    $iLikeThis .= '</div>';
    
    if ($arg == 'put') {
	    return $iLikeThis;
    }
    else {
    	echo $iLikeThis;
    }
}

if (get_option('ilt_onPage') == '1') {
	function putILikeThis($content) {
		if(!is_feed() && !is_page()) {
			$content.= getILikeThis('put');
		}
	    return $content;
	}

	add_filter('the_content', putILikeThis);
}

function enqueueScripts() {
	if (get_option('ilt_jquery') == '1') {
	    wp_enqueue_script('iLikeThis', WP_PLUGIN_URL.'/i-like-this/js/i-like-this.js', array('jquery'));	
	}
	else {
	    wp_enqueue_script('iLikeThis', WP_PLUGIN_URL.'/i-like-this/js/i-like-this.js');	
	}
}

function addHeaderLinks() {
	echo '<link rel="stylesheet" type="text/css" href="'.WP_PLUGIN_URL.'/i-like-this/css/i-like-this.css" media="screen" />'."\n";
	echo '<script type="text/javascript">var blogUrl = \''.get_bloginfo('wpurl').'\'</script>'."\n";
}

add_action('init', enqueueScripts);
add_action('wp_head', addHeaderLinks);



?>

<?php
/*
Plugin Name: Google Recommend Widget
Plugin URI: http://glauserconsulting.com/en/other/
Description: Widget that displays a Google Recommend Button for your site.
Version: 1.1
Author: Ivan Glauser
Author URI: http://glauserconsulting.com/en/other/
License: GPL3
*/


/*  Copyright 2011  Ivan Glauser  (email : ivan.glauser@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 3, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// Define static variables
define( "PORT_SLDPLUGINPATH", "/" . plugin_basename( dirname(__FILE__) ) . "/" );
define( "PORT_SLDPLUGINFULLURL", WP_PLUGIN_URL . PORT_SLDPLUGINPATH );

// Set locale
$currentLocale = get_locale();
if( $currentLocale ) {
	load_plugin_textdomain( 'grecwidget', PORT_SLDPLUGINFULLURL . 'lang', PORT_SLDPLUGINPATH . 'lang' );
}





add_action( 'admin_init', 'register_google_recommend_settings' );

function register_google_recommend_settings() {
	register_setting('google-recommend-settings-group', 'language');
}





/**
 * Google_Recommend_Widget Class
 */
class Google_Recommend_Widget extends WP_Widget {
    /** constructor */
    function Google_Recommend_Widget() {
        parent::WP_Widget(false, $name = 'Google Recommend', array('description' => __('Widget that displays a Google Recommend (+1) Button.','grecwidget'), 'class' => 'google-recommend'));	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
		extract( $args );
        $show_numbers = empty($instance['show_numbers']) ? 'false' : 'true';
        $button_size = $instance['button_size'];
		$urltoplusone = $instance['urltoplusone'];
        ?>
            <?php echo $before_widget; ?>
				<li class="widget google-recommend"><div class="textwidget">
					<g:plusone count="<?php echo $show_numbers; ?>" size="<?php echo $button_size; ?>" href="<?php echo $urltoplusone; ?>"></g:plusone>
				</div></li>
            <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['button_size'] = $new_instance['button_size'];
		$instance['show_numbers'] = $new_instance['show_numbers'];
		$instance['language'] = $new_instance['language'];
		$instance['urltoplusone'] = strip_tags($new_instance['urltoplusone']);
		update_option('language', $new_instance['language']);
        return $instance;
    }
	
	    /** @see WP_Widget::form */
    function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'button_size' => 'standard', 'show_numbers' => true, 'language' => 'en-US', 'urltoplusone' => $_SERVER['SERVER_NAME'] ) );
		
		$button_size = $instance['button_size'];
		$show_numbers = $instance['show_numbers'];
		$language = $instance['language'];
		$urltoplusone = esc_attr($instance['urltoplusone']);
		
        ?>
            <p>
				<label for="<?php echo $this->get_field_id('button_size'); ?>"><?php _e('Button Size','grecwidget'); ?>:
				<select class="widefat" id="<?php echo $this->get_field_id('button_size'); ?>" name="<?php echo $this->get_field_name('button_size'); ?>">
					<option value="standard" <?php echo ($button_size=='standard')?'selected':''; ?>>Standard (24px)</option>
					<option value="small" <?php echo ($button_size=='small')?'selected':''; ?>>Small (15px)</option>
					<option value="medium" <?php echo ($button_size=='medium')?'selected':''; ?>>Medium (20px)</option>
					<option value="tall" <?php echo ($button_size=='tall')?'selected':''; ?>>Tall (60px)</option>
				</select>
				</label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('show_numbers'); ?>"><?php _e('Show Numbers', 'grecwidget'); ?>: <label title="Button Size Tall always show numbers.">(?)</label><input type="checkbox" id="<?php echo $this->get_field_id('show_numbers'); ?>" name="<?php echo $this->get_field_name('show_numbers') ?>" <?php echo ($show_numbers=='on')?'checked="checked"':''; ?>/></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('language'); ?>"><?php _e('Language', 'grecwidget'); ?>: <select class="widefat" id="<?php echo $this->get_field_id('language'); ?>" name="<?php echo $this->get_field_name('language'); ?>">
			<option value="ar" <?php echo ($language=='ar')?'selected':''; ?>>Arabic</option>
			<option value="bg" <?php echo ($language=='bg')?'selected':''; ?>>Bulgarian</option>
			<option value="ca" <?php echo ($language=='ca')?'selected':''; ?>>Catalan</option>
			<option value="zh-CN" <?php echo ($language=='zh-CN')?'selected':''; ?>>Chinese (Simplified)</option>
			<option value="zh-TW" <?php echo ($language=='zh-TW')?'selected':''; ?>>Chinese (Traditional)</option>
			<option value="hr" <?php echo ($language=='hr')?'selected':''; ?>>Croatian</option>
			<option value="cs" <?php echo ($language=='cs')?'selected':''; ?>>Czech</option>
			<option value="da" <?php echo ($language=='da')?'selected':''; ?>>Danish</option>
			<option value="nl" <?php echo ($language=='nl')?'selected':''; ?>>Dutch</option>
			<option value="en-GB" <?php echo ($language=='en-GB')?'selected':''; ?>>English (UK)</option>
			<option value="en-US" <?php echo ($language=='en-US')?'selected':''; ?>>English (US)</option>
			<option value="et" <?php echo ($language=='et')?'selected':''; ?>>Estonian</option>
			<option value="fil" <?php echo ($language=='fil')?'selected':''; ?>>Filipino</option>
			<option value="fi" <?php echo ($language=='fi')?'selected':''; ?>>Finnish</option>
			<option value="fr" <?php echo ($language=='fr')?'selected':''; ?>>French</option>
			<option value="de" <?php echo ($language=='de')?'selected':''; ?>>German</option>
			<option value="el" <?php echo ($language=='el')?'selected':''; ?>>Greek</option>
			<option value="iw" <?php echo ($language=='iw')?'selected':''; ?>>Hebrew</option>
			<option value="hi" <?php echo ($language=='hi')?'selected':''; ?>>Hindi</option>
			<option value="hu" <?php echo ($language=='hu')?'selected':''; ?>>Hungarian</option>
			<option value="id" <?php echo ($language=='id')?'selected':''; ?>>Indonesian</option>
			<option value="it" <?php echo ($language=='it')?'selected':''; ?>>Italian</option>
			<option value="ja" <?php echo ($language=='ja')?'selected':''; ?>>Japanese</option>
			<option value="ko" <?php echo ($language=='ko')?'selected':''; ?>>Korean</option>
			<option value="lv" <?php echo ($language=='lv')?'selected':''; ?>>Latvian</option>
			<option value="lt" <?php echo ($language=='lt')?'selected':''; ?>>Lithuanian</option>
			<option value="ms" <?php echo ($language=='ms')?'selected':''; ?>>Malay</option>
			<option value="no" <?php echo ($language=='no')?'selected':''; ?>>Norwegian</option>
			<option value="fa" <?php echo ($language=='fa')?'selected':''; ?>>Persian</option>
			<option value="pl" <?php echo ($language=='pl')?'selected':''; ?>>Polish</option>
			<option value="pt-BR" <?php echo ($language=='pt-BR')?'selected':''; ?>>Portuguese (Brazil)</option>
			<option value="pt-PT" <?php echo ($language=='pt-PT')?'selected':''; ?>>Portuguese (Portugal)</option>
			<option value="ro" <?php echo ($language=='ro')?'selected':''; ?>>Romanian</option>
			<option value="ru" <?php echo ($language=='ru')?'selected':''; ?>>Russian</option>
			<option value="sr" <?php echo ($language=='sr')?'selected':''; ?>>Serbian</option>
			<option value="sk" <?php echo ($language=='sk')?'selected':''; ?>>Slovak</option>
			<option value="sl" <?php echo ($language=='sl')?'selected':''; ?>>Slovenian</option>
			<option value="es" <?php echo ($language=='es')?'selected':''; ?>>Spanish</option>
			<option value="es-419" <?php echo ($language=='es-419')?'selected':''; ?>>Spanish (Latin America)</option>
			<option value="sv" <?php echo ($language=='sv')?'selected':''; ?>>Swedish</option>
			<option value="th" <?php echo ($language=='th')?'selected':''; ?>>Thai</option>
			<option value="tr" <?php echo ($language=='tr')?'selected':''; ?>>Turkish</option>
			<option value="uk" <?php echo ($language=='uk')?'selected':''; ?>>Ukrainian</option>
			<option value="vi" <?php echo ($language=='vi')?'selected':''; ?>>Vietnamese</option>
		</select></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('urltoplusone'); ?>"><?php _e('URL to +1','grecwidget'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('urltoplusone'); ?>" name="<?php echo $this->get_field_name('urltoplusone'); ?>" type="text" value="<?php echo $urltoplusone; ?>" /></label>
			</p>
        <?php 
    }

} // class Google_Recommend_Widget


function add_google_recommend_header($head = ''){
	echo '<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: \''.get_option('language').'\'}
</script>';
}

add_action('wp_print_scripts', 'add_google_recommend_header');

// register Google_Recommend_Widget widget
add_action('widgets_init', create_function('', 'return register_widget("Google_Recommend_Widget");'));

?>
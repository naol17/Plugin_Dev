<?php
/* Plugin Name:       MyPglugin 
 * Plugin URI:        https://socialmedia.com
 * Description:       This is a social media adding plugin to wordpress website helps to add and delete your social media icons .
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Naol Dame
 * Author URI:        https://authnaoldame.wordpress.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       Plugin_Dev
 * Domain Path:       /languages
 */
if(! defined('ABSPATH')){
    exit;
}

//  <!-- to get list of social profile that are being used  -->

function mypg_socialprofiles(){
    //  <!-- return the social profile --> 
    return apply_filters(
        'mypg_profiles',
        array()
    );
}
// <!-- default profiles when first installed  -->
// <!-- __ is the wordpress translation function  -->
function mypg_default_profiles($profiles){
    $profiles['facebook'] = array(
        'id' => 'mypg_facebook',
        'label'             => __( 'Facebook profile', 'https://facebook.com' ),
		'class'             => 'facebook',
		'description'       => __( 'Enter your Facebook profile URL', 'https://facebook.com' ),
		'priority'          => 10,
		'type'              => 'icon',
		'default'           => '',
        // <!-- the text we entered is not cause any harm and sanitized     -->
		'sanitize_callback' => 'sanitize_text_field',
    );

    // <!-- returning the modified profile -->
    return $profiles;
}
add_filter('mypg_profiles', 'mypg_default_profiles');


// <!-- function that is added to the customiser to add fields to the customiser   -->
function mypg_profile_setting($wp_customize){
    $social_pro = mypg_socialprofiles();
    
    if(! empty($social_pro)){

        // <!-- registeing the section for social profile -->
        $wp_customize -> add_section(
            // <!-- this is the section added to the customizer as a reference id -->
            'mypg_social',
            array(
                'title' => __('My Connection'),
                'description' => __( 'Add social Connections here.' ),
				'priority' => 160,
				'capability' => 'edit_theme_options',
            )
        );
        // <!-- looping through each profile -->
        foreach($social_pro as $soc_pro){
            $wp_customize -> add_setting(
                $soc_pro['id'],
                array(
                    'default'=>'',
                    'sanitize_callback'=>$soc_pro['sanitize_callback']
                )

            );
            // <!-- controller for the profile -->
            $wp_customize->add_control(
                $soc_pro['id'],
                array(
                    'type'        => $soc_pro['type'],
					'priority'    => $soc_pro['priority'],
					'section'     => 'mypg_social',
					'label'       => $soc_pro['label'],
					'description' => $soc_pro['description'],
                )
            );
        }

    }
}
add_action( 'customize_register', 'mypg_profile_setting' )

// class for the socials 
     
class icons extends WP_Widget{

    public function __buildfunction(){
        $widgetOps = array(
            'classname' => 'My contact medias',
            'description' => 'Display social medias','PluginDev' 
        );

        $controlOps = array(
            'id_base' => 'My contact medias',
        );

        parent:: __buildfunction('My contact medias', 'Social Contacts', $widgetOps,$controlOps);
    }

    // to print to the actual front end of the website 
    public function frontPageWidget($args, $instance){
        echo wp_kses_post( $args['before_widget']);

        // action that out put the widget
        do_action('icons_output', $args, $instance);

        // after widget
        echo wp_kses_post( $args['after_widget'] );

    }
}





function register_widget(){
    register_widget('icons');
}

add_action( 'widget_init', 'register_widget')
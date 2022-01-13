<?php
/* Plugin Name:       MyPg
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

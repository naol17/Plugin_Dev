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
        'label'             => __( 'Facebook ', 'https://facebook.com' ),
		'class'             => 'facebook',
		'description'       => __( 'Enter your Facebook profile URL', 'https://facebook.com' ),
		'priority'          => 10,
		'type'              => 'icon',
		'default'           => '',
        // <!-- the text we entered is not cause any harm and sanitized     -->
		'sanitize_callback' => 'sanitize_text_field',
    );
    $profiles['instagram'] = array(
        'id' => 'mypg_instagram',
        'label'             => __( 'Instagram ', 'https://instagram.com' ),
		'class'             => 'Instagram',
		'description'       => __( 'Enter your Instagram profile URL', 'https://instagram.com' ),
		'priority'          => 10,
		'type'              => 'icon',
		'default'           => '',
        // <!-- the text we entered is not cause any harm and sanitized     -->
		'sanitize_callback' => 'sanitize_text_field',
    );
    $profiles['twiter'] = array(
        'id' => 'mypg_twiter',
        'label'             => __( 'Twiter ', 'https://Twiter.com' ),
		'class'             => 'Twiter',
		'description'       => __( 'Enter your Twiter profile URL', 'https://Twiter.com' ),
		'priority'          => 10,
		'type'              => 'icon',
		'default'           => '',
        // <!-- the text we entered is not cause any harm and sanitized     -->
		'sanitize_callback' => 'sanitize_text_field',
    );
    $profiles['linkedin'] = array(
        'id' => 'mypg_linkedin',
        'label'             =>__( "Limked In", 'https://linkedin.com' ),
		'class'             => 'linkedin',
		'description'       => __( 'Enter your linkedin profile URL', 'https://linkedin.com' ),
		'priority'          => 10,
		'type'              => 'icon',
		'default'           => '',
        // <!-- the text we entered is not cause any harm and sanitized     -->
		'sanitize_callback' => 'sanitize_text_field',
    );
    $profiles['telegram'] = array(
        'id' => 'mypg_Telegram',
        'label'             => __( 'Telegram ', 'https://Telegram.com' ),
		'class'             => 'v',
		'description'       => __( 'Enter your Telegram profile URL', 'https://Telegram.com' ),
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
add_action( 'customize_register', 'mypg_profile_setting' );





function registerIcons() {
	register_widget( 'icons' );
}

add_action( 'widgets_init', 'registerIcons' );


class icons extends WP_Widget {

	
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
			'classname'   => 'my_social_icons',
			'description' => __( 'To display social icons', 'PluginDev' ),
		);

		/* Widget control settings. */
		$control_ops = array(
			'id_base' => 'socialIcons',
		);

		/* Create the widget. */
		parent::__construct( 'socialIcons', 'MySocial', $widget_ops, $control_ops );
	
	}

	// Output the widget front-end.
	 
	public function widget( $args, $instance ) {

		// output the before widget content.
		echo wp_kses_post( $args['before_widget'] );

		
		do_action( 'widgedOutPut', $args, $instance );

		// output the after widget content.
		echo wp_kses_post( $args['after_widget'] );

	}

	/**
	 * Output the backend widget form.
	 */
	public function form( $instance ) {

		// get the saved title.
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $disc = !empty($instance['description'])? $instance['description']:'';
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'PluginDev' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

        <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_attr_e( 'Description:', 'PluginDev' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" type="text" value="<?php echo esc_attr( $disc ); ?>">
		</p>

		

		<?php

	}

	
	public function update( $new_instance, $old_instance ) {

		// create an empty array to store new values in.
		$instance = array();

		// add the title to the array, stripping empty tags along the way.
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		// return the instance array to be saved.
		return $instance;

	}

}

// Displaying the out put on the frontend 

function mypg_widget_display( $args, $instance ) {
    
    // if we have before widget content.
    if ( ! empty( $instance['title'] ) ) {

          // if we have before title content.
        if ( ! empty( $args['before_title'] ) ) {

              // output the before title content.
              echo wp_kses_post( $args['before_title'] );
  
        }
  
        // output the before widget content.
        echo esc_html( $instance['title'] );
  
        // if we have after title content.
        if ( ! empty( $args['after_title'] ) ) {
  
            // output the after title content.
            echo wp_kses_post( $args['after_title'] );
  
        }
    }
  
}
  

add_action( 'widgedOutPut','mypg_widget_display',5,2 );

// function to display the saved url

function desplaycontent($args,  $instance){

    $social_lists = mypg_socialprofiles();

    if ( ! empty( $social_lists ) ) {
        ?>
		<ul class="my_social_icons">
		<?php

        foreach($social_lists as $socialL){

            $profile_url = get_theme_mod( $socialL['id'] );

            if(empty($profile_url)){
                continue; //to the next profile
            }

            // if no any url entered 
            if(empty($socialL['class'])){

                // using the lable to form the class 
                $socialL['class'] = strtolower(sanitize_title_with_dashes( $socialL['lable'] ));

            }

            ?>

            <li class="socialicon__item socialicon__item--<?php echo esc_attr( $socialL['class'] ); ?>">
			    <a target="_blank" class="socialicon__itemlink" href="<?php echo esc_url( $profile_url ); ?>">
					<i class="icon-<?php echo esc_attr( $socialL['class'] ); ?>"></i> <span><?php echo esc_html( $socialL['label'] ); ?></span>
				</a>
			</li>

			<?php

        }
        ?>
        </ul>
        <?php
    }
}

add_action( 'widgedOutPut','desplaycontent',20,2 );
<?php

/*

Plugin Name: Goodbye
Plugin URI: http://thefold.no
Description: A plugin to add goodbye message to Wordpress sites when user leaves. Replace the pages title with a goodbye message.
Version: 1
Author: The Fold / Christoffer Jacobsen
Author URI: http://thefold.no

*/

defined('ABSPATH') or die( 'No script kiddies please!' );   # No direct access

class goodbye {


    /*
    *       Goodbye Message setup
    *       1. Add settings (customizer)
    *       2. Customizer style
    *       3. Adds title effect
    */
    function __construct() {

        add_action('customize_register', array($this, 'add_settings'));                     # 1
        add_action('customize_controls_print_styles', array($this, 'custimizer_style'));    # 2
        add_action('wp_footer', array($this, 'add_message_script'));                        # 3

    }


    /*
    *       Adds customizer
    *       - Adds Section: Goodbye Message
    *       - Adds settings: toggle and messge
    *       - Adds controls: checkbox and text
    */
    function add_settings($wp_customize) {


        # Add Section
        $wp_customize->add_section('goodbye_section', array(
            'title' => 'Goodbye message',
            'description' => 'Add a goodbye message in the title field shown in the browsers tab when the current user navigate away from your site',
        ));

        # Default
        $wp_customize->add_setting('goodbye_setting_toggle', array(
            'default' => 1,
        ));
        $wp_customize->add_setting('goodbye_setting_message', array(
            'default' => 'Goodbye',
        ));

        # Controls
        $wp_customize->add_control('goodbye_setting_toggle', array(
            'label' => 'Add message?',
            'section' => 'goodbye_section',
            'type' => 'checkbox',
        ));
        $wp_customize->add_control('goodbye_setting_message', array(
            'section' => 'goodbye_section',
            'type' => 'text',
            'description' => 'Goodbye message:',
        ));

    }


    /*
    *       Adds style to custimizer
    *       - Turns the checkbox into a toggle designed btn
    */
    function custimizer_style() {
        ?>
        <style type="text/css">#customize-control-goodbye_setting_toggle input{width:36px;border-radius:10px;position:relative}#customize-control-goodbye_setting_toggle input::before{content:'';margin:0;position:absolute;left:19px;top:0;bottom:0;background:#555;border-radius:8px;width:15px}#customize-control-goodbye_setting_toggle input:checked:before{background:#1e8cbe;left:0}</style>
        <?php
    }

    /*
    *       Adds script to wp footer
    *       - Pure JS script for detecting window focus and blur
    */
    function add_message_script() {
        ?>
        <script type="text/javascript">var old_title=document.title,goodbye_message="<?php print get_theme_mod('goodbye_setting_message', 1); ?>";window.addEventListener("focus",function(){document.title=old_title}),window.addEventListener("blur",function(){console.log("blur"),document.title!=goodbye_message&&(old_title=document.title),document.title=goodbye_message});</script>
        <?php
    }


}

$goodbye = new goodbye;

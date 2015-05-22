<?php
require_once 'includes/controls/textarea_custom_control.php';

//-- Theme Setup ------------------------------------------------------------
require_once 'includes/theme_setup.php';
require_once 'includes/theme/image_settings.php';
require_once 'includes/theme/selective_menu_walker.php';
require_once 'includes/theme/menus.php';

//-- Utilities --------------------------------------------------------------
require_once 'includes/renderer.php';
require_once 'includes/helpers/tedx_helpers.php';

//-- Advanced Custom Fields -------------------------------------------------
require_once 'includes/advanced_custom_fields/template_home.php';

//-- Admin Inclues ----------------------------------------------------------
require_once 'includes/admin/plugin_dependencies.php';

//-- Theme Query Helpers ----------------------------------------------------
require_once 'includes/tedx_query.php';

//-- Custom Post Types ------------------------------------------------------
require_once 'includes/custom_post_types/partner.php';
$PartnerPostType = new PartnerPostType();

require_once 'includes/custom_post_types/team.php';
$TeamPostType = new TeamPostType();

require_once 'includes/custom_post_types/talk.php';
$TalkPostType = new TalkPostType();

require_once 'includes/custom_post_types/speaker.php';
$SpeakerPostType = new SpeakerPostType();

require_once 'includes/custom_post_types/schedule_items.php';
$ScheduleItemsPostType = new ScheduleItemsPostType();

/**  Enqueue necessary Javascript **/
function txt_enqueue_scripts_and_css() {
    //--  Register Scripts
    wp_register_script('txt-google-maps', '//maps.google.com/maps/api/js?sensor=false');
    wp_register_script('txt-jquery-migrate', '//code.jquery.com/jquery-migrate-1.2.1.min.js');
    wp_register_script('txt-vendor-js', get_template_directory_uri() . '/dist/js/vendor.js', false, false, true);
    wp_register_script('txt-application-js', get_template_directory_uri() . '/dist/js/application.js', false, false, true);

    //--  Register Scripts
    wp_register_style('txt-vendor', get_template_directory_uri() . '/dist/css/vendor.min.css');
    wp_register_style('txt-application', get_template_directory_uri() . '/dist/css/application.min.css');


    //--  Enqueue scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('txt-jquery-migrate');
    wp_enqueue_script('txt-vendor-js');
    wp_enqueue_script('txt-application-js');
    wp_enqueue_script('txt-google-maps');

    //--  Enqueue CSS
    wp_enqueue_style('txt-vendor');
    wp_enqueue_style('txt-application');
}

//add_action('init', 'txt_enqueue_scripts_and_css');
add_action('wp_enqueue_scripts', 'txt_enqueue_scripts_and_css');

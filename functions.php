<?php
require_once 'includes/controls/wp_customize_textarea_control.php';

//-- Theme Setup ------------------------------------------------------------
require_once 'includes/theme_setup.php';
require_once 'includes/theme/image_settings.php';

//-- Utilities --------------------------------------------------------------
require_once 'includes/renderer.php';

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

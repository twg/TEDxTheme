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


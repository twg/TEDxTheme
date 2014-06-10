<?php
add_theme_support('post-thumbnails');
register_nav_menu('header', 'Main Header Menu');
register_sidebar([
  'name'          => 'Primary Sidebar',
  'class'         => 'sidebar',
  'before_title'  => '<h4 class="widgettitle">',
  'after_title'   => "</h2>\n",
]);

require_once 'includes/renderer.php';

// Advanced Custom Fields
require_once 'includes/advanced_custom_fields/template_home.php';

// Admin Includes
require_once 'includes/admin/plugin_dependencies.php';
require_once 'includes/admin/option_tree.php';

// Query Helpers
require_once 'includes/tedx_query.php';

// Custom Post Types
require_once 'includes/custom_post_types/partner.php';
$PartnerPostType = new PartnerPostType();

require_once 'includes/custom_post_types/team.php';
$TeamPostType = new TeamPostType();

require_once 'includes/custom_post_types/talk.php';
$TalkPostType = new TalkPostType();

require_once 'includes/custom_post_types/speaker.php';
$SpeakerPostType = new SpeakerPostType();

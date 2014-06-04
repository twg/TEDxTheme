<?php
add_theme_support('post-thumbnails');

require_once 'includes/renderer.php';

// Advanced Custom Fields
require_once 'includes/advanced_custom_fields/template_home.php';

// Admin Includes
require_once 'includes/admin/option_tree.php';

// Custom Post Types
require_once 'includes/custom_post_types/partner.php';
$PartnerPostType = new PartnerPostType();

require_once 'includes/custom_post_types/team.php';
$TeamPostType = new TeamPostType();

require_once 'includes/custom_post_types/talk.php';
$TalkPostType = new TalkPostType();

require_once 'includes/custom_post_types/speaker.php';
$SpeakerPostType = new SpeakerPostType();

<?php
require_once 'includes/renderer.php';

// Admin Includes
require_once 'includes/admin/option_tree.php';

// Custom Post Types
require_once 'includes/custom_post_types/partner.php';
$PartnerPostType = new PartnerPostType();

require_once 'includes/custom_post_types/team.php';
$TeamPostType = new TeamPostType();


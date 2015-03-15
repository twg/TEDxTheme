<?php
class TEDxImageSettings {

  function __construct() {
    add_theme_support('post-thumbnails');
    add_image_size('tedx-feature', 780, 500, true);
    add_filter('image_size_names_choose', array($this, 'custom_sizes'));
  }

  function custom_sizes($sizes) {
    return array_merge($sizes, ['tedx-feature' => 'Featured Image']);
  }

}

$TEDxImageSettings = new TEDxImageSettings();
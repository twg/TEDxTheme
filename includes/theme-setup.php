<?php 

add_theme_support('post-thumbnails');

register_nav_menu('header', 'Main Header Menu');

register_sidebar([
  'name'          => 'Primary Sidebar',
  'class'         => 'sidebar',
  'before_title'  => '<h4 class="widgettitle">',
  'after_title'   => "</h2>\n",
]);


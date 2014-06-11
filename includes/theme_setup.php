<?php 

//-- Sidebar Settings -------------------------------------------------------
$sidebar_settings = [
  'class'         => 'sidebar',
  'before_title'  => '<h4 class="widgettitle">',
  'after_title'   => "</h4>\n"
];
register_sidebar(array_merge($sidebar_settings, ['name' => 'Blog Sidebar', 'id' => 'blog-sidebar']));
register_sidebar(array_merge($sidebar_settings, ['name' => 'Page Sidebar', 'id' => 'page-sidebar']));

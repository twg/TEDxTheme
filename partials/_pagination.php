<?php 
//-- Default Arguments
$offset = (isset($offset) ? $offset : 0);

//-- Consider Post Offsets (for stickies)
$page_offset = 0;
if($offset > 0) {
  $page_offset = ceil($offset / get_option('posts_per_page'));
}

// Lifted from: http://codex.wordpress.org/Function_Reference/paginate_links
global $wp_query;
$big = 999999999;

$pagination_settings = [
  'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
  'format'  => '?paged=%#%',
  'current' => max( 1, get_query_var('paged') ),
  'total'   => ($wp_query->max_num_pages - $page_offset),
  'type'    => 'list'
];

echo paginate_links($pagination_settings);
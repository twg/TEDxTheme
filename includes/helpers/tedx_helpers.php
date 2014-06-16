<?php
class TEDxHelpers {

  public static function index_title($default = 'Blog Posts') {
    if(is_category()) {
      $category = get_the_category();
      $category = isset($category[0]) ? $category[0]->cat_name : '';
      $default = "Category: {$category}";
    }elseif (is_tag()) {
      $default = "Tag: " . single_tag_title("", false);
    }elseif (is_tax()) {
      global $wp_query;
      $term = $wp_query->get_queried_object();
      $default = "Showing: " . $term->name;
    }elseif (is_search()) {
      $default = "Searching: " . get_search_query();
    }elseif (is_date()) {
      $default = "Archive For: " . single_month_title(' ', false);
    }
    return $default;
  }

}
<?php

class TalkPostType {

  var $custom_fields = array(
    '_talk_speaker_id',
    '_talk_video_id',
    '_talk_speaker_name',
    '_talk_speaker_role'
  );

  function __construct () {
    add_action('init', array($this, 'add_talk_years_taxonomy'));
    add_action('init', array($this, 'add_talk_types_taxonomy'));
    add_action('init', array($this, 'add_talk_categories_taxonomy'));
    add_action('init', array($this, 'add_post_type'));
    add_filter('init', array($this, 'add_permalink_structure'));
    add_action('save_post', array($this, 'save_custom_fields'));
    add_filter('enter_title_here', array($this, 'custom_title_text'));
    add_shortcode('talk', array($this, 'talk_shortcode'));
  }

  function talk_shortcode ($atts) {
    $a = shortcode_atts(array(
      'year'     => '',
      'title'    => '',
      'location' => 'archive',
      'limit'    => ''
    ), $atts);

    $limit        = $a['limit'];
    $for_homepage = ($a['location'] == 'homepage');

    if (empty($limit)) {
      if ($for_homepage) {
        $limit = 6;
      } else {
        $limit = 1000;
      }
    } else {
      $limit = intval($limit);
    }


    $year  = $a['year'];
    $title = $a['title'];


    $talks = $this->get_talks_from_year($year, $limit);
    ob_start();
    require(get_template_directory() . '/shortcode_templates/talk_shortcode.php');
    $output = ob_get_clean();

    return $output;
  }


  function get_talks_for ($year, $options = array()) {
    $arguments = array(
      'post_type' => 'talk',
      'tax_query' => array(
        array(
          'taxonomy' => 'talk_years',
          'field'    => 'slug',
          'terms'    => strval($year)
        )
      )
    );
    if (!empty($options['limit'])) {
      $arguments['posts_per_page'] = $options['limit'];
    } else {
      $arguments['posts_per_page'] = 100;
    }
    if (!empty($options['exclude']) && $options['exclude'] === true) {
      global $post;
      $arguments['post__not_in'] = array($post->ID);
    }
    if (!empty($options['exclude']) && is_array($options['exclude'])) {
      $arguments['post__not_in'] = $options['exclude'];
    }
    $query = new WP_Query($arguments);

    return $query;
  }

  function add_post_type () {
    // Labels
    $labels = array(
      'name'          => __('Talks'),
      'singular_name' => __('Talk'),
      'add_new'       => __('Add New'),
      'all_items'     => __('All Talks'),
      'add_new_item'  => __('Add New Talk'),
      'edit_item'     => __('Edit Talk'),
      'new_item'      => __('New Talk'),
      'view_item'     => __('View Talk'),
      'search_items'  => __('Search Talks'),
      'not_found'     => __('No Talks Found')
    );
    // Settings
    $settings = array(
      'labels'               => $labels,
      'public'               => true,
      'publicly_queryable'   => true,
      'show_ui'              => true,
      'menu_icon'            => get_stylesheet_directory_uri() . '/images/custom_post_types/talk.png',
      'show_in_menu'         => true,
      'query_var'            => true,
      'rewrite'              => array('slug' => 'talks', 'with_front' => false),
      'capability_type'      => 'post',
      'has_archive'          => true,
      'hierarchical'         => false,
      'menu_position'        => 102,
      'taxonomies'           => array('talk_years', 'talk_types', 'talk_categories'),
      'register_meta_box_cb' => array($this, 'add_meta_boxes')
    );
    // Register the actual type
    register_post_type('talk', $settings);
  }

  function add_talk_years_taxonomy () {
    register_taxonomy(
      'talk_years',
      'talk',
      array(
        'label'             => __('Talk Years'),
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'hierarchical'      => true,
        'rewrite'           => array('slug' => 'talks/year'),
        'query_var'         => 'talk_year'
      ));
  }

  function add_talk_categories_taxonomy () {
    register_taxonomy(
      'talk_categories',
      'talk',
      array(
        'label'             => __('Talk Categories'),
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'hierarchical'      => true,
        'rewrite'           => array('slug' => 'talks/category'),
        'query_var'         => 'talk_category'
      ));
  }

  function add_talk_types_taxonomy () {
    register_taxonomy(
      'talk_types',
      'talk',
      array(
        'label'             => __('Talk Types'),
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'hierarchical'      => true,
        'rewrite'           => array('slug' => 'talks/type'),
        'query_var'         => 'talk_type'
      ));
  }

  function add_meta_boxes () {
    add_meta_box('talk_speaker_id', 'Speaker', array($this, 'render_speaker_id_meta_boxes'), 'talk', 'side', 'high');
    add_meta_box('talk_video_id', 'Video ID', array($this, 'render_video_meta_boxes'), 'talk', 'normal', 'high');
    add_meta_box('_talk_speaker_name', 'Speaker Name', array($this, 'render_speaker_name_meta_boxes'), 'talk', 'side', 'high');
    add_meta_box('_talk_speaker_role', 'Speaker Role', array($this, 'render_speaker_role_meta_boxes'), 'talk', 'normal', 'high');
  }

  function add_permalink_structure () {
    // Add a new query tag
    // add_rewrite_rule('speakers/previous/(alphabetical|yearly)/?',
    //                  'index.php?post_type=speaker&sort_type=$matches[1]&previous=1',
    //                  'top');
    // add_rewrite_rule('speakers/previous/(alphabetical|yearly)/([0-9]{4})/?',
    //                  'index.php?post_type=speaker&sort_type=$matches[1]&event_year=$matches[2]&previous=1',
    //                  'top');
    // add_rewrite_rule('speakers/previous/?',
    //                  'index.php?post_type=speaker&sort_type=yearly&previous=1',
    //                  'top');


    // add_rewrite_rule('talks/(year|category|type)/[^/]+/(year|category|type)/[^/]/(year|category|type)/[^/]',
    //                  'index.php?post_type=talk&$matches[1]=$matches[2]&$matches[2]'
    //                  'top');
  }

  function save_custom_fields ($post_id) {
    foreach ($this->custom_fields as $field) {
      if (!empty($_POST[$field])) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
          return;
        }
        $nonce = $_POST[$field . '_nonce'];
        if (!wp_verify_nonce($nonce, 'tedx' . $field . '_nonce')) {
          exit('There was a permission error');
        }
        if ($_POST['post_type'] == 'talk') {
          if (!current_user_can('edit_post', $post_id)) {
            return;
          } else {
            update_post_meta($post_id, $field, $_POST[$field]);
          }
        }
      }
    }
  }

  function custom_title_text () {
    $screen = get_current_screen();
    if ($screen->post_type == 'talk') {
      $title = 'Enter talk name...';
    } else {
      $title = '';
    }

    return $title;
  }

  function get_talk ($slug) {
    $arguments = array(
      'post_type' => 'talk',
      'name'      => $slug
    );
    $query     = new WP_Query($arguments);
    if (!empty($query->posts[0])) {
      return $query->posts[0];
    } else {
      return false;
    }
  }

  function parse_wp_query () {
    global $wp_query;
    $query_vars = $wp_query->query_vars;

    $arguments              = array();
    $arguments['tax_query'] = array();

    if (!empty($query_vars['talk_year'])) {
      $arguments['tax_query'][] = array(
        'taxonomy' => 'talk_years',
        'field'    => 'slug',
        'terms'    => $query_vars['talk_year']
      );
    }

    if (!empty($query_vars['talk_type'])) {
      $arguments['tax_query'][] = array(
        'taxonomy' => 'talk_types',
        'field'    => 'slug',
        'terms'    => $query_vars['talk_type']
      );
    }

    if (!empty($query_vars['talk_category'])) {
      $arguments['tax_query'][] = array(
        'taxonomy' => 'talk_categories',
        'field'    => 'slug',
        'terms'    => $query_vars['talk_category']
      );
    }

    if (!empty($query_vars['page'])) {
      $arguments['paged'] = $query_vars['page'];
    }

    if (empty($arguments['tax_query'])) {
      unset($arguments['tax_query']);

      return $arguments;
    } else {
      return $arguments;
    }
  }

  function get_talks () {
    $defaults = array(
      'post_type'      => 'talk',
      'posts_per_page' => 360,
      'meta_query'     => array(
        array(
          'key'     => '_talk_video_id',
          'value'   => '',
          'compare' => 'NOT IN'
        )
      )
    );
    $options  = func_get_args();
    if (!empty($options[0]) && is_array($options[0])) {
      $options = array_merge($defaults, $options[0]);
    } else {
      $options = $defaults;
    }
    $query = new WP_Query($options);

    return $query;
  }

  function get_related_videos ($slug, $limit = 2) {
    if (!$this->current_talk) {
      $this->current_talk = $this->get_talk($slug);
    }
    $year = $this->get_year($slug);
    if ($year != 'Not Available') {
      $arguments = array(
        'post__not_in'   => array($this->current_talk->ID),
        'post_type'      => 'talk',
        'posts_per_page' => $limit,
        'tax_query'      => array(
          array(
            'taxonomy' => 'talk_years',
            'field'    => 'slug',
            'terms'    => strval($year)
          )
        )
      );
      $query     = new WP_Query($arguments);

      return $query->posts;
    } else {
      return array();
    }
  }

  function get_talks_from_year ($slug, $limit = 1000) {
    $arguments = array(
      'post_type'      => 'talk',
      'posts_per_page' => $limit,
      'tax_query'      => array(
        array(
          'taxonomy' => 'talk_years',
          'field'    => 'slug',
          'terms'    => strval($slug)
        )
      )
    );
    $query     = new WP_Query($arguments);

    return $query;
  }


  function get_year ($slug) {
    if (!$this->current_talk) {
      $this->current_talk = $this->get_talk($slug);
    }
    $year = wp_get_post_terms($this->current_talk->ID, 'talk_years');
    if (!empty($year[0])) {
      $year = array_pop($year);

      return $year->name;
    } else {
      return 'Not Available';
    }
  }

  function get_speaker ($slug) {
    if (!$this->current_talk) {
      $this->current_talk = $this->get_talk($slug);
    }
    $speaker_id = get_post_meta($this->current_talk->ID, '_talk_speaker_id', true);
    $speaker    = get_post(intval($speaker_id));

    return $speaker;
  }

  function get_types ($slug) {
    if (!$this->current_talk) {
      $this->current_talk = $this->get_talk($slug);
    }
    $types = wp_get_post_terms($this->current_talk->ID, 'talk_types');

    return $types;
  }

  function get_video_id ($slug) {
    if (!$this->current_talk) {
      $this->current_talk = $this->get_talk($slug);
    }

    return get_post_meta($this->current_talk->ID, '_talk_video_id', true);
  }

  function get_speakers () {
    $arguments = array(
      'post_type'      => 'speaker',
      'posts_per_page' => 500
    );
    $query     = new WP_Query($arguments);
    $speakers  = array();
    foreach ($query->posts as $speaker) {
      $speakers[$speaker->post_title] = $speaker->ID;
    }

    return $speakers;
  }

  function is_ajax_request () {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      return true;
    } else {
      return false;
    }
  }

  function get_dropdown_options_for ($taxonomy) {
    global $wp_query;
    $query_vars = $wp_query->query_vars;
    $selected   = false;
    if (!empty($query_vars['talk_year']) && $taxonomy == 'talk_years') {
      $selected = $query_vars['talk_year'];
    }
    if (!empty($query_vars['talk_type']) && $taxonomy == 'talk_types') {
      $selected = $query_vars['talk_type'];
    }
    if (!empty($query_vars['talk_category']) && $taxonomy == 'talk_categories') {
      $selected = $query_vars['talk_category'];
    }
    $options   = array();
    $options[] = "<option value='all'>ALL " . substr($taxonomy, 5) . "</option>";
    $terms     = get_terms($taxonomy);
    foreach ($terms as $term) {
      if ($selected && $selected == $term->slug) {
        $options[] = "<option selected='selected' value='{$term->slug}'>{$term->name}</option>\n";
      } else {
        $options[] = "<option value='{$term->slug}'>{$term->name}</option>\n";
      }
    }

    return $options;
  }

  function dropdown_options_for ($taxonomy) {
    echo join('\n', $this->get_dropdown_options_for($taxonomy));
  }

  function render_video_meta_boxes () {
    WP_Render::partial(
      'partials/admin/talk/_talk_video_id.php',
      [
        'talk_video_id' => get_post_meta(get_the_ID(), '_talk_video_id', true)
      ]);
  }

  function render_speaker_id_meta_boxes () {
    WP_Render::partial(
      'partials/admin/talk/_speaker_id.php',
      [
        'talk_speaker_id' => get_post_meta(get_the_ID(), '_talk_speaker_id', true),
        'speakers'        => $this->get_speakers()
      ]);
  }

  function render_speaker_name_meta_boxes () {

    WP_Render::partial(
      'partials/admin/talk/_speaker_name.php',
      [
        'talk_speaker_name' => get_post_meta(get_the_ID(), '_talk_speaker_name', true)
      ]);
  }

  function render_speaker_role_meta_boxes () {
    WP_Render::partial(
      'partials/admin/talk/_speaker_role.php',
      [
        'talk_speaker_role' => get_post_meta(get_the_ID(), '_talk_speaker_role', true),
        'speakers'          => $this->get_speakers()
      ]);
  }

}

<?php

class SpeakerPostType {

  public $custom_fields = array(
    '_speaker_video_id',
    '_speaker_website_url',
    '_speaker_video_description',
    '_speaker_twitter_link'
  );

  function __construct () {

    add_action('init', array($this, 'add_taxonomy'));
    add_action('init', array($this, 'add_post_type'));
    add_filter('init', array($this, 'add_permalink_structure'));
    add_filter('query_vars', array($this, 'add_query_vars'));

    add_action('manage_edit-speaker_columns', array($this, 'speaker_columns'));
    add_action('manage_speaker_posts_custom_column', array($this, 'speaker_columns_content'));
    add_image_size('speaker', 370, 370, true);

    add_image_size('speaker_thumb', 100, 57, true);
    add_filter('enter_title_here', array($this, 'custom_title_text'));
    add_action('save_post', array($this, 'save_custom_fields'));
    add_filter('excerpt_length', array($this, 'new_excerpt_length'));
    add_filter('body_class', array($this, 'add_body_class'));
    add_filter('nav_menu_css_class', array($this, 'force_active_state'), 10, 3);

    add_shortcode('speaker_card', array($this, 'speaker_card_shortcode'));
  }


  function speaker_card_shortcode ($atts) {
    $a = shortcode_atts(array(
      'slug' => '',
    ), $atts);

    $slug = $a['slug'];
    $slugs = array_filter(explode(",", $slug), "trim");

    ob_start();
    require(get_template_directory() . '/shortcode_templates/speaker_card_shortcode.php');
    $output = ob_get_clean();

    return $output;
  }

  function add_post_type () {
    // Labels
    $speaker_labels = array(
      'name'          => __('Speakers'),
      'singular_name' => __('Speaker'),
      'add_new'       => __('Add New'),
      'all_items'     => __('All Speakers'),
      'add_new_item'  => __('Add New Speaker'),
      'edit_item'     => __('Edit Speaker'),
      'new_item'      => __('New Speaker'),
      'view_item'     => __('View Speaker'),
      'search_items'  => __('Search Speakers'),
      'not_found'     => __('No Speakers Found')
    );
    // Settings
    $speaker_settings = array(
      'labels'               => $speaker_labels,
      'public'               => true,
      'publicly_queryable'   => true,
      'show_ui'              => true,
      'menu_icon'            => get_stylesheet_directory_uri() . '/images/custom_post_types/speaker.png',
      'show_in_menu'         => true,
      'query_var'            => true,
      'rewrite'              => array('slug' => 'speakers', 'with_front' => false),
      'capability_type'      => 'post',
      'has_archive'          => true,
      'hierarchical'         => false,
      'menu_position'        => 104,
      'taxonomies'           => array('event_years'),
      'supports'             => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
      'register_meta_box_cb' => array($this, 'add_meta_boxes')
    );
    // Register the actual type
    register_post_type('speaker', $speaker_settings);
  }

  function add_taxonomy () {
    register_taxonomy(
      'event_years',
      'speaker',
      array(
        'label'             => __('Event Year'),
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'hierarchical'      => true,
        'rewrite'           => array('slug' => 'speakers/year'),
        'query_var'         => 'event_year'
      ));
  }

  function add_permalink_structure () {
    // Add a new query tag
    add_rewrite_rule('speakers/previous/(alphabetical|yearly)/?',
      'index.php?post_type=speaker&sort_type=$matches[1]&previous=1',
      'top');
    add_rewrite_rule('speakers/previous/(alphabetical|yearly)/([0-9]{4})/?',
      'index.php?post_type=speaker&sort_type=$matches[1]&event_year=$matches[2]&previous=1',
      'top');
    add_rewrite_rule('speakers/previous/?',
      'index.php?post_type=speaker&sort_type=yearly&previous=1',
      'top');
  }

  function add_query_vars ($vars) {
    $vars[] = 'sort_type';
    $vars[] = 'previous';

    return $vars;
  }

  function create_custom_rewrite_rules () {
    global $wp_rewrite;

    // Define custom rewrite tokens
    $rewrite_tag = '%exampletag%';

    // Add the rewrite tokens
    $wp_rewrite->add_rewrite_tag($rewrite_tag, '(.+?)', 'car=');

    // Define the custom permalink structure
    $rewrite_keywords_structure = $wp_rewrite->root . "%pagename%/$rewrite_tag/";
    // $rewrite_keywords_structure = $wp_rewrite->root . "$slug/$rewrite_tag/";

    // Generate the rewrite rules
    $new_rule = $wp_rewrite->generate_rewrite_rules($rewrite_keywords_structure);

    // Add the new rewrite rule into the global rules array
    $wp_rewrite->rules = $new_rule + $wp_rewrite->rules;

    return $wp_rewrite->rules;

  } // End create_custom_rewrite_rules()

  function custom_title_text ($title) {
    $screen = get_current_screen();
    if ($screen->post_type == 'speaker') {
      $title = 'Enter speaker name (eg. John Smith)';
    }

    return $title;
  }

  function add_meta_boxes () {
    add_meta_box('speaker_website_url', 'Website URL', array($this, 'render_website_meta_boxes'), 'speaker', 'normal', 'high');
    add_meta_box('speaker_video_id', 'Video ID', array($this, 'render_video_meta_boxes'), 'speaker', 'normal', 'high');
    add_meta_box('speaker_video_description', 'Video Description', array($this, 'render_video_description_boxes'), 'speaker', 'normal', 'high');
    add_meta_box('speaker_speaker_twitter_link', 'Twitter Link', array($this, 'render_speaker_twitter_meta_boxes'), 'speaker', 'normal', 'high');
  }

  function force_active_state ($classes, $item, $args) {
    if ($item->title == 'Speakers' && strpos($_SERVER['REQUEST_URI'], '/speakers') !== false) {
      $classes[] = 'current-menu-item';
    }

    return $classes;
  }

  function render_video_meta_boxes () {
    WP_Render::partial(
      'partials/admin/speaker/_video_id.php',
      [
        'speaker_video_id' => get_post_meta(get_the_ID(), '_speaker_video_id', true)
      ]);
  }

  function render_speaker_twitter_meta_boxes () {
    WP_Render::partial(
      'partials/admin/speaker/_twitter_link.php',
      [
        'speaker_twitter_link' => get_post_meta(get_the_ID(), '_speaker_twitter_link', true)
      ]);
  }

  function render_website_meta_boxes () {
    WP_Render::partial(
      'partials/admin/speaker/_website_url.php',
      [
        'speaker_website_url' => get_post_meta(get_the_ID(), '_speaker_website_url', true)
      ]);
  }

  function render_video_description_boxes () {
    WP_Render::partial(
      'partials/admin/speaker/_video_description.php',
      [
        'speaker_website_url' => get_post_meta(get_the_ID(), '_speaker_video_description', true)
      ]);
  }

  function new_excerpt_length () {
    global $post;
    if ($post->post_type == 'speaker') {
      return 25;
    } else {
      return 55;
    }
  }

  function speaker_columns ($columns) {
    $columns = array(
      'cb'    => '<input type="checkbox" />',
      'thumb' => 'Thumbnail',
      'title' => __('Speaker Name'),
      'year'  => __('Year(s)')
    );

    return $columns;
  }

  function speaker_columns_content ($column) {
    global $post;
    switch ($column) {
      case 'thumb':
        echo "<a href='" . get_edit_post_link() . "'>";
        if (has_post_thumbnail()) {
          the_post_thumbnail('thumb');
        } else {
          echo "<img src='" . get_bloginfo('template_url') . "/images/defaults/speaker-thumb.jpg' width='139' height='150' />";
        }
        echo "</a>";
        break;
      case 'year':
        // $terms = get_terms('event_years');
        $terms  = wp_get_post_terms(get_the_ID(), 'event_years');
        $output = array();
        foreach ($terms as $term) {
          $output[] = $term->name;
        }
        if (empty($output)) {
          echo "None";
        } else {
          rsort($output);
          echo implode(", ", $output);
        }
        break;
    }
  }

  function add_body_class ($classes) {
    foreach ($classes as $class) {
      if ($class == 'post-type-archive-speaker') {
        $classes[] = 'speakers-page';
      }
    }

    return $classes;
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
        if ($_POST['post_type'] == 'speaker') {
          if (!current_user_can('edit_post', $post_id)) {
            return;
          } else {
            update_post_meta($post_id, $field, $_POST[$field]);
          }
        }
      }
    }
  }

  function get_speakers_for ($year, $options = array()) {
    $arguments = array(
      'post_type' => 'speaker',
      'tax_query' => array(
        array(
          'taxonomy' => 'event_years',
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

  function get_talks ($slug, $limit = false) {
    $speaker   = $this->get_speaker_by_slug($slug);
    $arguments = array(
      'post_type'  => 'talk',
      'meta_query' => array(
        array(
          'key'   => '_talk_speaker_id',
          'value' => strval($speaker->ID)
        )
      )
    );
    if ($limit) {
      $arguments['posts_per_page'] = $limit;
    }
    $query = new WP_Query($arguments);

    return $query->posts;
  }

  function get_previous_speakers () {
    $arguments = array(
      'post_type'      => 'speaker',
      'posts_per_page' => 100
    );
    $query     = new WP_Query($arguments);
    $by_year   = array();
    foreach ($query->posts as $post) {
      $terms = wp_get_object_terms($post->ID, 'event_years');
      foreach ($terms as $term) {
        $by_year[$term->slug][] = $post;
      }
    }
    krsort($by_year);
    unset($by_year[$this->current_year]);

    return $by_year;
  }

  function get_previous_speakers_alphabetical () {
    $arguments = array(
      'post_type'      => 'speaker',
      'posts_per_page' => 100,
      'tax_query'      => array(
        array(
          'taxonomy' => 'event_years',
          'field'    => 'slug',
          'terms'    => '2012',
          'operator' => 'NOT IN'
        )
      )
    );
    $query     = new WP_Query($arguments);
    if (!empty($query->posts)) {
      return $this->alphabetical($query->posts);
    } else {
      return array();
    }
  }

  function last_name_sort ($a, $b) {
    $a_last_name = end(split(' ', trim($a->post_title)));
    $b_last_name = end(split(' ', trim($b->post_title)));

    return strcasecmp($a_last_name, $b_last_name);
  }

  function alphabetical ($speakers) {
    $ordered = array();
    usort($speakers, array($this, 'last_name_sort'));

    return $speakers;
  }

  function next_speaker_for ($slug, $year) {
    // Get the current speaker
    $current_speaker = $this->get_speaker_by_slug($slug);
    // Get all the speakers from the year
    $speakers = $this->get_speakers_for($year);
    // Count the speakers and initialize some flags
    $speakers_count        = count($speakers->posts);
    $current_speaker_index = false;
    $next_speaker_index    = false;
    // Loop through and find out our current position
    foreach ($speakers->posts as $index => $speaker) {
      if ($speaker->ID == $current_speaker->ID) {
        $current_speaker_index = (int)$index;
      }
    }
    // If there is only one speaker, then return false
    if ($speakers_count == 0) {
      return false;
    }
    // If this is the last speaker, then we choose the first speaker
    if ($current_speaker_index == ($speakers_count - 1)) {
      $next_speaker_index = 0;
    } // Otherwise choose the next speaker
    else {
      $next_speaker_index = $current_speaker_index + 1;
    }
    // Grab the id of the next speaker
    $next_speaker_id = $speakers->posts[$next_speaker_index];
    $next_speaker_id = $next_speaker_id->ID;

    // Return the next speaker
    return $this->get_speaker_by_id($next_speaker_id);
  }

  function get_sort_type () {
    global $wp_query;
    if (empty($wp_query->query['sort_type'])) {
      return 'current';
    }
    if (!empty($wp_query->query['sort_type'])) {
      if ($wp_query->query['sort_type'] == 'yearly') {
        return 'year';
      }
      if ($wp_query->query['sort_type'] == 'alphabetical') {
        return 'alphabetical';
      }
    } else {
      return 'current';
    }
  }

  function get_speaker_by_slug ($slug) {
    $arguments = array(
      'post_type'      => 'speaker',
      'name'           => $slug,
      'posts_per_page' => 100
    );
    $query     = new WP_Query($arguments);
    if (!empty($query->posts[0])) {
      return $query->posts[0];
    } else {
      return false;
    }
  }

  function get_latest_year ($slug) {
    $speaker = $this->get_speaker_by_slug($slug);
    if ($speaker) {
      $event_years = wp_get_post_terms($speaker->ID, 'event_years');
      if (!empty($event_years[0])) {
        $event_year = array_pop($event_years);

        return $event_year->name;
      }
    } else {
      return 'Not Available';
    }
  }

  function get_video_id ($slug) {
    $speaker = $this->get_speaker_by_slug($slug);
    if ($speaker) {
      return get_post_meta($speaker->ID, '_speaker_video_id', true);
    } else {
      return false;
    }
  }

  function get_twitter_link ($slug) {
    $speaker = $this->get_speaker_by_slug($slug);
    if ($speaker) {
      return get_post_meta($speaker->ID, '_speaker_twitter_link', true);
    } else {
      return false;
    }
  }

  function get_speaker_by_id ($id) {
    $arguments = array(
      'post_type' => 'speaker',
      'p'         => $id
    );
    $query     = new WP_Query($arguments);
    if (!empty($query->posts[0])) {
      return $query->posts[0];
    } else {
      return false;
    }
  }

  function yearly_permalink () {
    return get_bloginfo('url') . '/speakers/previous/yearly/';
  }

  function alphabetical_permalink () {
    return get_bloginfo('url') . '/speakers/previous/alphabetical/';
  }

}
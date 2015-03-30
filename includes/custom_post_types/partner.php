<?php

class PartnerPostType {

  var $custom_fields = array(
    '_partner_url'
  );

  function __construct() {
    add_action('init', array($this, 'add_partner_types_taxonomy'));
    add_action('init', array($this, 'add_post_type'));
    add_action('save_post', array($this, 'save_custom_fields'));
    add_filter('enter_title_here', array($this, 'custom_title_text'));

    // Custom Admin Columns
    add_action('manage_edit-partner_columns', array($this, 'columns'));
    add_action('manage_partner_posts_custom_column', array($this, 'column_content'));

    add_image_size('large-partner', 570, 210, false);
    add_image_size('small-partner', 340, 125, false);

    add_shortcode('partner', array($this, 'partner_shortcode'));

  }

  function add_post_type() {
    // Labels
    $labels = array(
      'name' => __('Partners'),
      'singular_name' => __('Partner'),
      'add_new' => __('Add New'),
      'all_items' => __('All Partners'),
      'add_new_item' => __('Add New Partner'),
      'edit_item' => __('Edit Partner'),
      'new_item' => __('New Partner'),
      'view_item' => __('View Partner'),
      'search_items' => __('Search Partners'),
      'not_found' => __('No Partners Found')
    );
    // Settings
    $settings = array(
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'menu_icon' => get_stylesheet_directory_uri() . '/images/custom_post_types/partner.png',
      'show_in_menu' => true,
      'query_var' => true,
      'rewrite' => array('slug' => 'partners-archive', 'with_front' => false),
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => 100,
      'taxonomies' => array('partner_types'),
      'register_meta_box_cb' => array($this, 'add_meta_boxes'),
      'supports' => array('title', 'editor', 'thumbnail'),
      'show_in_nav_menus' => true

    );
    // Register the actual type
    register_post_type('partner', $settings);
  }

  function add_partner_types_taxonomy() {
    register_taxonomy(
      'partner_types',
      'partner',
      array(
        'label' => __('Partner Types'),
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'hierarchical' => true,
        'rewrite' => array('slug' => 'talks/year'),
        'query_var' => 'partner_type'
      ));
  }

  function add_meta_boxes() {
    add_meta_box('partner_url', 'Website URL', array($this, 'render_partner_url_meta_boxes'), 'partner', 'side', 'high');
  }

  function columns($columns) {
    $columns = array(
      'cb' => '<input type="checkbox" />',
      'partner_thumb' => 'Thumbnail',
      'title' => __('Partner Name'),
      'type' => __('Type')
    );

    return $columns;
  }

  function column_content($column) {
    switch ($column) {
      case 'partner_thumb':
        echo "<a href='" . get_edit_post_link() . "'>";
        if (has_post_thumbnail()) {
          the_post_thumbnail('thumb');
        } else {
          echo "No Thumbnail Set";
        }
        echo "</a>";
        break;
      case 'type':
        $terms = wp_get_post_terms(get_the_ID(), 'partner_types');
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

  function save_custom_fields($post_id) {
    foreach ($this->custom_fields as $field) {
      if (!empty($_POST[$field])) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
          return;
        }
        $nonce = $_POST[$field . '_nonce'];
        if (!wp_verify_nonce($nonce, 'tedx' . $field . '_nonce')) {
          exit('There was a permission error');
        }
        if ($_POST['post_type'] == 'partner') {
          if (!current_user_can('edit_post', $post_id)) {
            return;
          } else {
            update_post_meta($post_id, $field, $_POST[$field]);
          }
        }
      }
    }
  }

  function custom_title_text() {
    $screen = get_current_screen();
    if ($screen->post_type == 'partner') {
      $title = 'Enter Partner name...';
    } else {
      $title = '';
    }

    return $title;
  }

  function render_partner_url_meta_boxes() {
    WP_Render::partial(
      'partials/admin/partner/_partner_url.php',
      [
        'partner_url' => get_post_meta(get_the_ID(), '_partner_url', true)
      ]);
  }

  function get_partners() {
    $arguments = array(
      'post_type' => 'partner',
      'posts_per_page' => 100
    );
    $query = new WP_Query($arguments);

    return $query->posts;
  }

  function get_partners_for($partner_type_slug) {
    return $this->get_get_raw_partners_for($partner_type_slug)->posts;
  }

  function get_raw_partners_for($partner_type_slug) {
    $arguments = array(
      'post_type' => 'partner',
      'posts_per_page' => 100,
      'tax_query' => array(
        array(
          'taxonomy' => 'partner_types',
          'field' => 'slug',
          'terms' => $partner_type_slug
        )
      )
    );
    return new WP_Query($arguments);
  }

  function partner_shortcode($atts) {
    $a = shortcode_atts(array(
      'type' => null,
      'type_name' => 'Partner Type'
    ), $atts);
    $partner_type = $a['type'];
    if ($partner_type !== null) {
      $partners = $this->get_raw_partners_for($partner_type);
      $name = $a['type_name'];
      ob_start();
      require(get_template_directory() . '/shortcode_templates/partners_shortcode.php');
      $output = ob_get_clean();
    }
    return $output;
  }
}

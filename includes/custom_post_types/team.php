<?php

class TeamPostType {

  public $custom_fields = array(
    '_team_job_description',
    '_team_twitter_link'
  );

  function __construct () {
    add_action('init', array($this, 'add_post_type'));
    add_action('manage_edit-team_member_columns', array($this, 'team_member_columns'));
    add_action('manage_team_member_posts_custom_column', array($this, 'team_member_columns_content'));
    add_filter('enter_title_here', array($this, 'custom_title_text'));
    add_action('save_post', array($this, 'save_custom_fields'));

    add_shortcode('team_members', array($this, 'team_members_shortcode'));


    add_image_size('team', 370, 370, true);

    add_image_size('team_thumb', 100, 57, true);

  }

  function add_post_type () {
    // Labels
    $labels = array(
      'name'          => __('Team'),
      'singular_name' => __('Team Member'),
      'add_new'       => __('Add New Team Member'),
      'all_items'     => __('All Team Members'),
      'add_new_item'  => __('Add New Team Member'),
      'edit_item'     => __('Edit Team Member'),
      'new_item'      => __('New Team Member'),
      'view_item'     => __('View Team Member'),
      'search_items'  => __('Search Team Members'),
      'not_found'     => __('No Team Members Found')
    );
    // Settings
    $team_settings = array(
      'labels'               => $labels,
      'public'               => true,
      'publicly_queryable'   => true,
      'show_ui'              => true,
      'menu_icon'            => get_stylesheet_directory_uri() . '/images/custom_post_types/team.png',
      'show_in_menu'         => true,
      'query_var'            => true,
      'rewrite'              => array('slug' => 'teams', 'with_front' => false),
      'capability_type'      => 'post',
      'has_archive'          => true,
      'hierarchical'         => false,
      'menu_position'        => 101,
      'supports'             => array('title', 'editor', 'thumbnail', 'page-attributes'),
      'register_meta_box_cb' => array($this, 'add_meta_boxes')
    );
    // Register the actual type
    register_post_type('team_member', $team_settings);
  }

  function custom_title_text ($title) {
    $screen = get_current_screen();
    if ($screen->post_type == 'team_member') {
      $title = 'Enter team member name (eg. John Smith)';
    }

    return $title;
  }

  function add_meta_boxes () {
    add_meta_box('member_job_description',
      'Job Description',
      array($this, 'render_job_description_meta_boxes'),
      'team_member',
      'normal',
      'high'
    );
    add_meta_box('team_twitter_link',
      'Twitter Link',
      array($this, 'render_twitter_link_meta_boxes'),
      'team_member',
      'normal',
      'high'
    );
  }

  function render_twitter_link_meta_boxes () {
    WP_Render::partial(
      'partials/admin/team/_team_twitter_link.php',
      [
        'team_twitter_link' => get_post_meta(get_the_ID(), '_team_twitter_link', true)
      ]);
  }

  function render_job_description_meta_boxes () {
    WP_Render::partial(
      'partials/admin/team/_job_description.php',
      [
        'team_job_description' => get_post_meta(get_the_ID(), '_team_job_description', true)
      ]);
  }

  function team_member_columns ($columns) {
    $columns = array(
      'cb'              => '<input type="checkbox" />',
      'thumb'           => 'Thumbnail',
      'title'           => __('Team Member Name'),
      'job_description' => _('Job Description')
    );

    return $columns;
  }

  function team_member_columns_content ($column) {
    switch ($column) {
      case 'job_description':
        echo get_post_meta(get_the_ID(), '_team_job_description', true);
        break;
      case 'thumb':
        echo "<a href='" . get_edit_post_link() . "'>";
        if (has_post_thumbnail()) {
          the_post_thumbnail('thumb');
        } else {
          echo "<img src='" . get_bloginfo('template_url') . "/images/defaults/team-thumb.jpg' width='139' height='150' />";
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
        if ($_POST['post_type'] == 'team_member') {
          if (!current_user_can('edit_post', $post_id)) {
            return;
          } else {
            update_post_meta($post_id, $field, $_POST[$field]);
          }
        }
      }
    }
  }

  function team_members_shortcode () {
    $team_members = $this->get_raw_team_members();
    ob_start();
    require(get_template_directory() . '/shortcode_templates/team_members_shortcode.php');
    $output = ob_get_clean();

    return $output;
  }

  function get_raw_team_members () {
    $arguments = array(
      'post_type'      => 'team_member',
      'posts_per_page' => 100
    );

    return new WP_Query($arguments);
  }

}

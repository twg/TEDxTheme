<?php

class ScheduleItem {

  // General Containers
  public $post;
  public $speakers = array();

  // Raw Meta Properties
  public $type;
  public $start;
  public $end;
  public $label;
  public $description;
  public $class_name;
  public $extra_html;

  // Processed Properties
  public $rfc_start;
  public $rfc_end;
  public $valid;

  public $speaker_descriptions = ''; // description of the speaker(s) talk(s) that only appear when an event is current
  public $formatted_speakers = ''; // speaker(s) name and link to their page(s)
  public $role = ''; // The speakers role, the_excerpt or description if present

  // Internal Properties
  private $rfc_format = "j M Y H:i:s"; //j M Y H:i:s eO

  function __construct ($post) {
    $this->post = $post;
    $this->populate_meta_values();


    if ($this->start && $this->end) {
      $this->rfc_start = $this->rfc_timestamp($this->start);
      $this->rfc_end   = $this->rfc_timestamp($this->end);
    } else {
      $this->valid = false;
    }
    if ($this->type == 'speaker') {
      $this->speakers             = $this->get_speakers();
      $this->formatted_speakers   = $this->get_formatted_speakers();
      $this->speaker_descriptions = $this->get_speaker_descriptions();
      $this->role                 = $this->get_speaker_role();
    }
  }

  function populate_meta_values () {
    $this->label       = $this->post->post_title;
    $this->type        = get_post_meta($this->post->ID, '_schedule_item_type', true);
    $this->start       = get_post_meta($this->post->ID, '_schedule_item_start', true);
    $this->end         = get_post_meta($this->post->ID, '_schedule_item_end', true);
    $this->description = get_post_meta($this->post->ID, '_schedule_item_description', true);
    $this->class_name  = get_post_meta($this->post->ID, '_schedule_item_icon', true);
    $this->extra_html  = get_post_meta($this->post->ID, '_schedule_item_extra_html', true);
  }

  // Takes a HH:MM timestamp and converts it to a proper RFC timestamp
  // for todays date.
  function rfc_timestamp ($hour_minutes) {
    $now           = strtotime('now');
    $time          = explode(':', $hour_minutes);
    $hour          = (int)$time[0]; // eg. 08
    $minutes       = (int)$time[1]; // eg. 30
    $month         = (int)strftime('%m', $now); // eg. 09
    $day           = (int)strftime('%e', $now); // eg. 19
    $year          = (int)strftime('%Y', $now); // eg. 2012
    $rfc_timestamp = date($this->rfc_format, mktime((int)$hour, (int)$minutes, 0, (int)$month, (int)$day, (int)$year));

    return $rfc_timestamp . " GMT-0400";
  }

  // Fetches any speakers for this event
  function get_speakers () {
    $ids = get_post_meta($this->post->ID, '_schedule_item_speaker_ids', true);
    if (empty($ids)) {
      return false;
    }
    $arguments = array(
      'post_type' => 'speaker',
      'post__in'  => $ids
    );
    $query     = new WP_Query($arguments);
    if (empty($query->posts)) {
      return false;
    }
    $speakers = array();
    foreach ($query->posts as $speaker) {
      $speakers[] = $speaker;
    }

    return $speakers;
  }

  function get_formatted_speakers () {
    $html = array();
    if ($this->speakers) {
      foreach ($this->speakers as $index => $speaker) {
        if ($index != 0) {
          $html[] = " and ";
        }
        $html[] = '<a href="' . get_post_permalink($speaker->ID) . '">';
        $html[] = $speaker->post_title;
        $html[] = '</a>';
      }

      return implode("", $html);
    } else {
      return "";
    }
  }

  function get_speaker_descriptions () {
    if ($this->speakers) {
      $description = '';
      foreach ($this->speakers as $index => $speaker) {
        if ($index != 0) {
          $description .= "<br /><br />";
        }
        $description .= $speaker->post_content;
      }

      return $description;
    }
  }

  function get_speaker_role () {
    $role = '';
    if (!empty($this->description)) {
      $role = $this->description;
    } else {
      // Just returns the last role. Admin's will need to override
      if ($this->speakers) {
        foreach ($this->speakers as $speaker) {
          $role = $speaker->post_excerpt;
        }
      }
    }

    return $role;
  }

}


class ScheduleItemsPostType {

  var $custom_fields = array(
    'Type'        => '_schedule_item_type',
    'Start'       => '_schedule_item_start',
    'End'         => '_schedule_item_end',
    'Description' => '_schedule_item_description',
    'Icons'       => '_schedule_item_icon',
    'Extra HTML'  => '_schedule_item_extra_html',
  );

  var $icon_options = array(
    'None'        => 'none',
    'Party'       => 'party',
    'Lunch'       => 'lunch',
    'Coffee'      => 'coffee',
    'Performance' => 'performance',
    'Remarks'     => 'remarks'
  );

  function __construct () {
    add_action('init', array($this, 'add_post_type'));
    add_filter('enter_title_here', array($this, 'custom_title_text'));
    add_action('admin_enqueue_scripts', array($this, 'load_javascript'));
    add_action('save_post', array($this, 'save_custom_fields'));
    add_filter('pre_get_posts', array($this, 'admin_post_order'));
    add_action('manage_edit-schedule_item_columns', array($this, 'custom_columns'));
    add_action('manage_schedule_item_posts_custom_column', array($this, 'custom_columns_content'));

    add_shortcode('schedule', array($this, 'schedule_shortcode'));

  }


  function schedule_shortcode ($atts) {
    ob_start();
    require(get_template_directory() . '/shortcode_templates/schedule_shortcode.php');
    $output = ob_get_clean();
    return $output;
  }

  function add_post_type () {
    // Labels
    $schedule_item_labels = array(
      'name'          => __('Schedule'),
      'singular_name' => __('Schedule Item'),
      'add_new'       => __('Add New'),
      'all_items'     => __('All Schedule Items'),
      'add_new_item'  => __('Add New Schedule Item'),
      'edit_item'     => __('Edit Schedule Item'),
      'new_item'      => __('New Schedule Item'),
      'view_item'     => __('View Schedule Item'),
      'search_items'  => __('Search Schedule Items'),
      'not_found'     => __('No Schedule Items Found')
    );
    // Settings
    $schedule_item_settings = array(
      'labels'               => $schedule_item_labels,
      'public'               => true,
      'publicly_queryable'   => true,
      'show_ui'              => true,
      'menu_icon'            => get_stylesheet_directory_uri() . '/images/custom_post_types/schedule_item.png',
      'show_in_menu'         => true,
      'query_var'            => true,
      'rewrite'              => array('slug' => 'schedules', 'with_front' => false),
      'capability_type'      => 'post',
      'has_archive'          => true,
      'hierarchical'         => false,
      'menu_position'        => 105,
      'supports'             => array('title'),
      'register_meta_box_cb' => array($this, 'add_meta_boxes')
    );
    // Register the actual type
    register_post_type('schedule_item', $schedule_item_settings);
  }

  function add_meta_boxes () {
    foreach ($this->custom_fields as $label => $key) {
      add_meta_box($key, $label, array($this, "render$key"), 'schedule_item', 'normal', 'high');
    }
  }

  function admin_post_order () {
    global $wp_query;
    if (is_admin() && !empty($_GET['post_type']) && $_GET['post_type'] == 'schedule_item') {
      $wp_query->set('orderby', 'meta_value');
      $wp_query->set('order', 'asc');
      $wp_query->set('meta_key', '_schedule_item_start');
    }
  }

  function render_schedule_item_other_label () {
  }

  function render_schedule_item_speaker_ids () {
  }

  function custom_title_text () {
    $screen = get_current_screen();
    if ($screen->post_type == 'schedule_item') {
      $title = 'Enter label...';
    } else {
      $title = '';
    }

    return $title;
  }

  function render_schedule_item_type () {
    WP_Render::partial(
      'partials/admin/schedule_items/_schedule_item_type.php',
      [
        'schedule_item_type'        => get_post_meta(get_the_ID(), '_schedule_item_type', true),
        'schedule_item_speaker_ids' => get_post_meta(get_the_ID(), '_schedule_item_speaker_ids', true),
        'schedule_item_other_label' => get_post_meta(get_the_ID(), '_schedule_item_other_label', true)
      ]);


  }

  function render_schedule_item_start () {
    WP_Render::partial(
      'partials/admin/schedule_items/_schedule_item_start.php',
      [
        'schedule_item_start' => get_post_meta(get_the_ID(), '_schedule_item_start', true)
      ]);
  }

  function render_schedule_item_end () {
    WP_Render::partial(
      'partials/admin/schedule_items/_schedule_item_end.php',
      [
        'schedule_item_end' => get_post_meta(get_the_ID(), '_schedule_item_end', true)
      ]);
  }

  function render_schedule_item_description () {
    WP_Render::partial(
      'partials/admin/schedule_items/_schedule_item_description.php',
      [
        'schedule_item_description' => get_post_meta(get_the_ID(), '_schedule_item_description', true)
      ]);
  }

  function render_schedule_item_extra_html () {
    WP_Render::partial(
      'partials/admin/schedule_items/_schedule_item_extra_html.php',
      [
        'schedule_item_extra_html' => get_post_meta(get_the_ID(), '_schedule_item_extra_html', true)
      ]);
  }

  function render_schedule_item_icon () {
    WP_Render::partial(
      'partials/admin/schedule_items/_schedule_item_icon.php',
      [
        'icon_options'       => $this->icon_options,
        'schedule_item_icon' => get_post_meta(get_the_ID(), '_schedule_item_icon', true)
      ]);
  }

  function save_custom_fields ($post_id) {
    $custom_fields                     = $this->custom_fields;
    $custom_fields['Speaker IDs']      = '_schedule_item_speaker_ids';
    $custom_fields['Label for Others'] = '_schedule_item_other_label';
    $this->validate_time();
    foreach ($custom_fields as $key => $field) {
      if (isset($_POST[$field])) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
          return;
        }
        $nonce = $_POST[$field . '_nonce'];
        if (!wp_verify_nonce($nonce, 'tedx' . $field . '_nonce')) {
          exit('There was a permission error');
        }
        if ($_POST['post_type'] == 'schedule_item') {
          if (!current_user_can('edit_post', $post_id)) {
            return;
          } else {
            update_post_meta($post_id, $field, $_POST[$field]);
          }
        }
      }
    }
  }

  function validate_time () {
    // TODO: validate the times and ensure nothing overlaps
    return true;
  }

  function load_javascript ($hook) {
    if (get_post_type() === 'schedule_item') {
      $theme_url = get_bloginfo('template_url');
      wp_enqueue_style('timepickercss', "$theme_url/js/vendor/timepicker/timepicker.css");
      wp_enqueue_script('timpickerjs', "$theme_url/js/vendor/timepicker/jquery.timePicker.min.js", array('jquery'));
      wp_enqueue_style('select2css', "$theme_url/js/vendor/chosen/chosen.css");
      wp_enqueue_script('select2js', "$theme_url/js/vendor/chosen/chosen.jquery.min.js", array('jquery'));
      wp_enqueue_script('schedule-item-admin', "$theme_url/js/schedule-item-admin.js", array('jquery'));
    }
  }

  function custom_columns ($columns) {
    $columns = array(
      'cb'         => '<input type="checkbox" />',
      'title'      => 'Label',
      'speakers'   => 'Speaker(s)',
      'start_time' => 'Start Time',
      'end_time'   => 'End Time',
      'type'       => 'Type'
    );

    return $columns;
  }

  function custom_columns_content ($column) {
    global $post;
    switch ($column) {
      case 'type':
        $type = get_post_meta($post->ID, '_schedule_item_type', true);
        echo ucwords($type);
        break;
      case 'start_time':
        $type = get_post_meta($post->ID, '_schedule_item_start', true);
        echo ucwords($type);
        break;
      case 'end_time':
        $type = get_post_meta($post->ID, '_schedule_item_end', true);
        echo ucwords($type);
        break;
      case 'speakers':
        $speakers = $this->get_speakers($post->ID);
        if (!empty($speakers)) {
          foreach ($speakers as $speaker) {
            echo "<p><strong>" . $speaker->post_title . "</strong></p>";
          }
        }
        break;
    }
  }

  function get_speakers ($id) {
    $type = get_post_meta($id, '_schedule_item_type', true);
    if ($type === 'other') {
      return false;
    }
    $ids = get_post_meta($id, '_schedule_item_speaker_ids', true);
    if (empty($ids)) {
      return false;
    }
    $arguments = array(
      'post_type' => 'speaker',
      'post__in'  => $ids
    );
    $query     = new WP_Query($arguments);
    if (empty($query->posts)) {
      return false;
    }
    $speakers = array();
    foreach ($query->posts as $speaker) {
      $speakers[] = $speaker;
    }

    return $speakers;
  }

  function description_for ($id) {
    $arguments = array(
      'post_type' => 'speaker'
    );
  }

  function get_items () {
    $arguments = array(
      'posts_per_page' => 999,
      'post_type'      => 'schedule_item',
      'order'          => 'ASC',
      'orderby'        => 'meta_value',
      'meta_key'       => '_schedule_item_start',
      'meta_query'     => array(
        array('key' => '_schedule_item_start')
      )
    );
    $query     = new WP_Query($arguments);
    $items     = array();
    foreach ($query->posts as $item) {
      $items[] = new ScheduleItem($item);
    }

    return $items;
  }

}
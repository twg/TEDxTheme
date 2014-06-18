<?php

//-- Sidebar Settings -------------------------------------------------------
$sidebar_settings = [
  'class'        => 'sidebar',
  'before_title' => '<h4 class="widgettitle">',
  'after_title'  => "</h4>\n"
];
register_sidebar(array_merge($sidebar_settings, ['name' => 'Blog Sidebar', 'id' => 'blog-sidebar']));
register_sidebar(array_merge($sidebar_settings, ['name' => 'Page Sidebar', 'id' => 'page-sidebar']));
register_sidebar(array_merge($sidebar_settings, ['name' => 'Home Sidebar', 'id' => 'home-sidebar']));

add_image_size('post-sticky', 688, 350, true);
add_image_size('post-unsticky', 440, 240, true);

function tedx_customize_register ($wp_customize) {

  // Section
  $wp_customize->add_section(
    'tedx_event',
    array(
      'title'    => __('TEDx Event', 'tedx'),
      'priority' => 2147483630
    ));

  $wp_customize->add_setting(
    'promoted_talk_year',
    array(
      'default'   => date('Y'),
      'transport' => 'refresh',
    ));
  $wp_customize->add_control(
    'tedx_event_promoted_talk_year',
    array(
      'priority' => 2,
      'label'    => __('Promoted Talk Year', 'tedx'),
      'section'  => 'tedx_event',
      'settings' => 'promoted_talk_year',
      'type'     => 'text'
    ));

  $wp_customize->add_setting(
    'promoted_speaker_year',
    array(
      'default'   => date('Y'),
      'transport' => 'refresh',
    ));
  $wp_customize->add_control(
    'tedx_event_promoted_speaker_year',
    array(
      'priority' => 2,
      'label'    => __('Promoted Speaker Year', 'tedx'),
      'section'  => 'tedx_event',
      'settings' => 'promoted_speaker_year',
      'type'     => 'text'
    ));

  $wp_customize->add_setting(
    'logo'
  );
  $wp_customize->add_control(
    new WP_Customize_Image_Control(
      $wp_customize, 'logo', array(
      'priority' => 1,
      'label'    => __('Logo', 'tedx'),
      'section'  => 'tedx_event',
      'settings' => 'logo',
    )));

  $wp_customize->add_setting(
    'logo_link',
    array(
      'default'   => '/',
      'transport' => 'refresh',
    ));
  $wp_customize->add_control(
    'tedx_event_logo_link',
    array(
      'priority' => 2,
      'label'    => __('Logo Link', 'tedx'),
      'section'  => 'tedx_event',
      'settings' => 'logo_link',
      'type'     => 'text'
    ));


  $wp_customize->add_setting(
    'event_name',
    array(
      'default'   => 'TEDxCity',
      'transport' => 'refresh',
    ));
  $wp_customize->add_control(
    'tedx_event_event_name',
    array(
      'priority' => 3,
      'label'    => __('Event Name', 'tedx'),
      'section'  => 'tedx_event',
      'settings' => 'event_name',
      'type'     => 'text'
    ));

  $wp_customize->add_setting(
    'event_date',
    array(
      'default'   => 'Jan 1, 1970',
      'transport' => 'refresh',
    ));
  $wp_customize->add_control(
    'tedx_event_event_date',
    array(
      'priority' => 4,
      'label'    => __('Event Date', 'tedx'),
      'section'  => 'tedx_event',
      'settings' => 'event_date',
      'type'     => 'text'
    ));

  $wp_customize->add_setting(
    'event_location',
    array(
      'default'   => 'Toronto, ON',
      'transport' => 'refresh',
    ));
  $wp_customize->add_control(
    'tedx_event_event_location',
    array(
      'priority' => 5,
      'label'    => __('Event Location', 'tedx'),
      'section'  => 'tedx_event',
      'settings' => 'event_location',
      'type'     => 'text'
    ));

  $wp_customize->add_setting(
    'header_callout',
    array(
      'default'   => 'Header Callout',
      'transport' => 'refresh',
    ));
  $wp_customize->add_control(
    'tedx_event_header_callout',
    array(
      'priority' => 6,
      'label'    => __('Header Callout', 'tedx'),
      'section'  => 'tedx_event',
      'settings' => 'header_callout',
      'type'     => 'text'
    ));

  $wp_customize->add_setting(
    'button_callout_text',
    array(
      'default'   => 'CTA',
      'transport' => 'refresh',
    ));
  $wp_customize->add_control(
    'tedx_event_button_callout_text',
    array(
      'priority' => 7,
      'label'    => __('Button Callout Text', 'tedx'),
      'section'  => 'tedx_event',
      'settings' => 'button_callout_text',
      'type'     => 'text'
    ));

  $wp_customize->add_setting(
    'button_callout_link',
    array(
      'default'   => '/',
      'transport' => 'refresh',
    ));
  $wp_customize->add_control(
    'tedx_event_button_callout_link',
    array(
      'priority' => 8,
      'label'    => __('Button Callout Link', 'tedx'),
      'section'  => 'tedx_event',
      'settings' => 'button_callout_link',
      'type'     => 'text'
    ));

  // Section
  $wp_customize->add_section(
    'tedx_social',
    array(
      'title'    => __('TEDx Social', 'tedx'),
      'priority' => 2147483631
    ));

  $wp_customize->add_setting(
    'twitter_follow_button',
    array(
      'default'   => '<a href="https://twitter.com/twg" class="twitter-follow-button" data-show-count="false">Follow @twg</a>',
      'transport' => 'refresh',
    ));

  $wp_customize->add_control(
    'tedx_social_twitter_follow_button',
    array(
      'priority' => 8,
      'label'    => __('Twitter Follow Button', 'tedx'),
      'section'  => 'tedx_social',
      'settings' => 'twitter_follow_button',
      'type'     => 'text'
    ));


  $wp_customize->add_setting(
    'twitter_account',
    array(
      'default'   => '@twg',
      'transport' => 'refresh',
    ));
  $wp_customize->add_control(
    'tedx_social_twitter_account',
    array(
      'priority' => 7,
      'label'    => __('Twitter Account', 'tedx'),
      'section'  => 'tedx_social',
      'settings' => 'twitter_account',
      'type'     => 'text'
    ));
}

add_action('customize_register', 'tedx_customize_register');

<?php

// Initialize the custom theme options.
add_action('admin_init', 'custom_theme_options');

// Build the custom settings & update OptionTree.
function custom_theme_options () {
    // Get a copy of the saved settings array.
    $saved_settings = get_option('option_tree_settings', array());

    // Custom settings array that will eventually be passes to the OptionTree Settings API Class.
    $custom_settings = array(
        'contextual_help' => array(
            'sidebar' => ''
        ),
        'sections'        => array(
            array(
                'id'    => 'general',
                'title' => 'General'
            ),
            array(
                'id'    => 'social_media',
                'title' => 'Social Media'
            )
        ),
        'settings'        => array(
            array(
                'id'           => 'twitter_account',
                'label'        => 'Twitter Account',
                'desc'         => 'Twitter Account ie: TEDxCity (without @)',
                'std'          => '',
                'type'         => 'text',
                'section'      => 'social_media',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => ''
            ),
          array(
            'id'           => 'twitter_live_widget',
            'label'        => 'Twitter Live Widget',
            'desc'         => 'Twitter Live Widget Embed Code. Go to https://twitter.com/settings/widgets to create widgets',
            'std'          => '',
            'type'         => 'textarea-simple',
            'section'      => 'social_media',
            'rows'         => '',
            'post_type'    => '',
            'taxonomy'     => '',
            'min_max_step' => '',
            'class'        => ''
          ),
          array(
            'id'           => 'twitter_follow_button',
            'label'        => 'Twitter Follow Button',
            'desc'         => 'Twitter Follow Button. Go to https://about.twitter.com/resources/buttons',
            'std'          => '',
            'type'         => 'textarea-simple',
            'section'      => 'social_media',
            'rows'         => '',
            'post_type'    => '',
            'taxonomy'     => '',
            'min_max_step' => '',
            'class'        => ''
          ),
            array(
                'id'           => 'twitter_account_widget',
                'label'        => 'Twitter Account Widget',
                'desc'         => 'Twitter Account Embed Code. Go to https://twitter.com/settings/widgets to create widgets',
                'std'          => '',
                'type'         => 'textarea-simple',
                'section'      => 'social_media',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => ''
            ),
            array(
                'id'           => 'facebook_account_widget',
                'label'        => 'Facebook Account Widget',
                'desc'         => 'Facebook Account Embed Code',
                'std'          => '',
                'type'         => 'textarea-simple',
                'section'      => 'social_media',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => ''
            ),
            array(
                'id'           => 'newsletter_widget',
                'label'        => 'Newsletter Widget',
                'desc'         => 'Newsletter Widget HTML code from newsletter provider',
                'std'          => '',
                'type'         => 'textarea-simple',
                'section'      => 'social_media',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => ''
            ),
            array(
                'id'           => 'event_name',
                'label'        => 'Event Name',
                'desc'         => 'Event Name ie: TEDxCity',
                'std'          => '',
                'type'         => 'text',
                'section'      => 'general',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => ''
            ),
            array(
                'id'           => 'promoted_event_year',
                'label'        => 'Which event year are you currently promoting?',
                'desc'         => 'Choose the year you would like to promote. This affects which speakers will be pulled on the speakers template. The years in the menu are associated with speakers\' Event Year.',
                'std'          => '',
                'type'         => 'taxonomy-select',
                'section'      => 'general',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => 'event_years',
                'min_max_step' => '',
                'class'        => ''
            ),
            array(
                'id'           => 'event_date',
                'label'        => 'Event Date',
                'desc'         => 'Event date in header',
                'std'          => '',
                'type'         => 'text',
                'section'      => 'general',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'settings'     => array(
                    array(
                        'id'           => 'current_speaker_year',
                        'label'        => 'Which speakers should be considered "current"?',
                        'desc'         => 'Which speakers should be considered current and displayed as the current list of speakers?',
                        'std'          => '',
                        'type'         => 'taxonomy-select',
                        'rows'         => '',
                        'post_type'    => '',
                        'taxonomy'     => 'event_years',
                        'min_max_step' => '',
                        'class'        => ''
                    )
                )
            ),
            array(
                'id'           => 'event_location',
                'label'        => 'Event Location',
                'desc'         => 'Event location in header',
                'std'          => '',
                'type'         => 'text',
                'section'      => 'general',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => ''
            ),
            array(
                'id'           => 'header_callout',
                'label'        => 'Header Callout',
                'desc'         => 'Callout text in header',
                'std'          => '',
                'type'         => 'text',
                'section'      => 'general',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => ''
            ),
            array(
                'id'           => 'button_callout_text',
                'label'        => 'Button Callout Text',
                'desc'         => 'Text inside the callout button in header',
                'std'          => '',
                'type'         => 'text',
                'section'      => 'general',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => ''
            ),
            array(
                'id'           => 'logo_link',
                'label'        => 'Logo Link URL',
                'desc'         => 'Link URL for the logo. e.g. http://www.google.com',
                'std'          => '',
                'type'         => 'text',
                'section'      => 'general',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => ''
            ),
            array(
                'id'           => 'callout_link',
                'label'        => 'Callout Link URL',
                'desc'         => 'Link URL for the call button in the header. e.g. http://www.yahoo.com',
                'std'          => '',
                'type'         => 'text',
                'section'      => 'general',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => ''
            ),
            array(
                'id'           => 'logo',
                'label'        => 'Logo',
                'desc'         => 'Logo in header. Needs to be 229 x 50.',
                'std'          => '',
                'type'         => 'background',
                'section'      => 'general',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => ''
            )
        )
    );

    // Allow settings to be filtered before saving
    $custom_settings = apply_filters('option_tree_settings_args', $custom_settings);

    // settings are not the same update the DB
    if ($saved_settings !== $custom_settings) {
        update_option('option_tree_settings', $custom_settings);
    }
}
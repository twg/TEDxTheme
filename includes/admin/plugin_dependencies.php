<?php
class PluginDependencies {

  var $dependencies = [
    'advanced-custom-fields/acf.php' => 'You must install and activate the <a href="http://www.advancedcustomfields.com/" target="_blank">Advanced Custom Fields</a> Plugin'
  ];

  function __construct () {
    add_action('admin_notices', array($this, 'show_admin_messages'));
  }

  function show_admin_messages() {
    $messages = [];
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    // Populate the messages array
    foreach($this->dependencies as $plugin => $message) {
      if(!is_plugin_active($plugin)) {
        $messages[] = $message;
      }
    }

    if(count($messages) > 0) {
      $this->render_messages($messages);
    }

  }

  function render_messages($messages) {
    // Build the HTML fragment we want to render in the admin header
    $html = ["<div id='message' class='error'>"];
    foreach ($messages as $message) {
      $html[] = "<p><strong>{$message}</strong></p>";
    }
    $html[] = "</div>";
    // Render
    echo implode("\n", $html);
  }

}

$PluginDependencies = new PluginDependencies();
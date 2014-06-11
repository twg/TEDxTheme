<?php
class TEDxMenus {

  function __construct() {
    register_nav_menu('primary', 'Primary Header Menu');
  }

  function primary_nav() {
    return wp_nav_menu(['menu' => 'primary', 'depth' => 1]);
  }

  function secondary_nav() {
    return wp_nav_menu(['menu' => 'primary', 'echo' => false, 'walker' => new Selective_Walker() ]);
  }

  function show_secondary_nav() {
    $secondary_nav = $this->secondary_nav();
    return (strpos($secondary_nav, 'class="sub-menu"') !== false);
  }

}

$TEDxMenus = new TEDxMenus();
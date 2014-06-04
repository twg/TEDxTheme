<?php

class Renderer {

    public $data = array();
    public $base_path;

    function __construct () {
        $this->base_path = dirname(__FILE__) . '/views/';
    }

    function render ($view) {
        $template_path = $this->base_path . $view . '.php';
        ob_start();
        //TODO: WTF
        require_once $template_path;
        $output = ob_get_clean();

        return $output;
    }
}
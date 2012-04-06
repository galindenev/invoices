<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $is_ajax = FALSE;
    protected $session_id;
    public $data;
    public $loggeduser = null;

    function __construct() {
        parent::__construct();
        session_set_cookie_params(3600 * 2, '/'); //2 hours
        $data = & $this->data;
        // determine if this is an AJAX call or not
        $this->is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
        // FirePHP stuff
        $this->load->library('session');
    }

    function _unlink($file) {
        if (file_exists($file)) {
            unlink($file);
        }
    }
    
    public function inspect($object) {
        $methods = get_class_methods($object);
        $vars    = get_class_vars(get_class($object));
        $ovars   = get_object_vars($object);
        $parent  = get_parent_class($object);

        $output  = 'Parent class: ' . $parent . "\n\n";
        $output .= "Methods:\n";
        $output .= "--------\n";
        foreach ($methods as $method) {
            $meth = new ReflectionMethod(get_class($object), $method);
            $output .= $method . "\n";
            $output .= $meth->__toString();
        }

        $output .= "\nClass Vars:\n";
        $output .= "-----------\n";
        foreach ($vars as $name => $value) {
            $output .= $name . ' = ' . print_r($value, 1) . "\n";
        }

        $output .= "\nObject Vars:\n";
        $output .= "------------\n";
        foreach ($ovars as $name => $value) {
            $output .= $name . ' = ' . print_r($value, 1) . "\n";
        }

        echo '<pre>', $output, '</pre>';
    }

}
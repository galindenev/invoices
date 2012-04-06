<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 	Remove any kind of new-line characters from a string
 */
function nl_remove($string) {
    return str_replace(array("\r\n", "\n", "\r"), array("", "", ""), $string);
}

/**
 * 	Shortcut to use FirePHP to log variables
 */
function fb($var) {
    $ci = & get_instance();
    return $ci->firephp->log($var);
}

if (!function_exists('script_tag')) {

    function script_tag($src = '', $language = 'javascript', $type = 'text/javascript', $index_page = FALSE) {
        $CI = & get_instance();
        $script = '<scr' . 'ipt';

        if (is_array($src)) {
            foreach ($src as $k => $v) {
                if ($k == 'src' AND strpos($v, '://') === FALSE) {
                    if ($index_page === TRUE) {
                        $script .= ' src="' . $CI->config->site_url($v) . '"';
                    } else {
                        $script .= ' src="' . $CI->config->slash_item('base_url') . $v . '"';
                    }
                } else {
                    $script .= "$k=\"$v\"";
                }
            }

            $script .= "></scr" . "ipt>\n";
        } else {
            if (strpos($src, '://') !== FALSE) {
                $script .= ' src="' . $src . '" ';
            } elseif ($index_page === TRUE) {
                $script .= ' src="' . $CI->config->site_url($src) . '" ';
            } else {
                $script .= ' src="' . $CI->config->slash_item('base_url') . $src . '" ';
            }
            $script .= 'language="' . $language . '" type="' . $type . '"';
            $script .= ' /></script>' . "\n";
        }
        return $script;
    }

}

if (!function_exists('permalink')) {

    function permalink($string) {
        // remove all characters that aren’t a-z, 0-9, dash, underscore or space
        $NOT_acceptable_characters_regex = '#[^-a-zA-Z0-9_ ]#';
        $string = preg_replace($NOT_acceptable_characters_regex, '', $string);
        // remove all leading and trailing spaces
        $string = trim($string);
        //make all letters small
        $string = strtolower($string);
        // change all dashes, underscores and spaces to dashes
        $string = preg_replace('#[-_ ]+#', '-', $string);
        // return the modified string
        return $string;
    }

}

if (!function_exists('images_url')) {

    function images_url() {

        return site_url().'media/images/';
    }

}


if (!function_exists('storage_url')) {

    function storage_url() {
        /*return site_url().'media/storage/';*/
       
        return STORAGE_URL;
    }

}

if (!function_exists('dumpit')) {

    function dumpit($data, $varDump = false, $exit = true)
    {
        @header('Content-type: text/html; charset=UTF-8');

        echo "<pre>";

        if ($varDump == true){
            var_dump($data);
        }else{
            print_r($data);
        }

        if ($exit){
            exit;
        }
    }

}

if (!function_exists('base64UrlEncode')) {
    function base64UrlEncode($data)
    {
        return strtr(rtrim(base64_encode($data), '='), '+/', '-_');
    }
}

if (!function_exists('base64UrlDecode')) {
    function base64UrlDecode($base64)
    {
        return base64_decode(strtr($base64, '-_', '+/'));
    }
}

if (!function_exists('_t')){
    function _t($lk){
        global $__settings;

        if (isset($__settings) && is_array($__settings)){
            foreach($__settings as $key => $value){
                if ($value['key'] == $lk){
                    return $value['value'];
                }
            }
        }

        return $lk;
    }
}

if (! function_exists("lm")){
    function lm($str, $var_dump = false, $sFilenameSuffix = ''){
        $sShortDate = date('Y-m-d');
        $sFilename = "application/logs/$sShortDate";
        if (!empty($sFilenameSuffix)){
            $sFilename .= '-'.$sFilenameSuffix;
        }
        $date = date("d/m/Y H:i:s");
        $sOut = "========================= $date ========================= \n";

        if ($var_dump){
            $sOut .= var_export($str, true);
        }
        else {
            if (is_array($str)){
                $sOut .= print_r($str, true);
            }
            elseif (is_object($str)){
                $sOut .= print_r($str, true);
            }
            else {
                $sOut .= ">> $str\n";
            }
        }

        $sOut .= "=======================================================================\n";
        $sOut .= "=======================================================================\n\n\n";
        $fp = fopen($sFilename, "a");
        fwrite($fp, $sOut);
        fclose($fp);
    }
}
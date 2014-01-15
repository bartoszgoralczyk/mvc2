<?php

namespace Shared
{
    class Markup
    {
        public function __construct()
        {
            // nic nie rób
        }
        
        public function __clone()
        {
            // nic nie rób
        }
        
        public static function errors($array, $key, $separator = "<br />", $before = "<br />", $after = "")
        {
            if (isset($array[$key]))
            {
                return $before.join($separator, $array[$key]).$after;
            }
            return "";
        }
    }
}

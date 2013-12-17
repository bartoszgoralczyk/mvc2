<?php

namespace Framework\Router\Route
{
    use Framework\Router as Router;
    
    class Regex extends Router\Route
    {    
        /**
        * @readwrite
        */
        protected $_keys;
        
        public function matches($url)
        {
            $pattern = $this->pattern;
            
            // Sprawdzenie wartości
            preg_match_all("#^{$pattern}$#", $url, $values);
            
            if (sizeof($values) && sizeof($values[0]) && sizeof($values[1]))
            {
                // Znaleziono wartości, a więc modyfikujemy parametry i zwracamy
                $derived = array_combine($this->keys, $values[1]);
                $this->parameters = array_merge($this->parameters, $derived);
                
                return true;
            }
            
            return false;
        }
    }
}
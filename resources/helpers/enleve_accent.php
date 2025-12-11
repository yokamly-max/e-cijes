<?php

if (!function_exists("getEnleveAccent")) {

    function getEnleveAccent ($str, $charset='utf-8') {

        $str = htmlentities($str, ENT_NOQUOTES, $charset);
    
        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
        $str = preg_replace('/([^.a-z\/0-9]+)/i', '-', $str);
        $str = str_ireplace('.', '-', $str);
        $str = str_ireplace("/", '-', $str);
        return strtolower($str);
	}
}

?>
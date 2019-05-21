<?php

trait OutConsole {

    function getSeparator()
    {
        return ((php_sapi_name()=='cli')?"\n":"</br>");
    }
    function outConsole($value=null,$text=null)
    {
        $n=$this->getSeparator();
        if ($value==null && $text!=null) {
            echo $text."--".$n;
            echo $n;
        } elseif ($text==null && $value!=null) {
            echo "--".$n;
                print_r($value);
            echo $n;
            echo "--".$n;
        } else {
            echo $text."--".$n;
            echo "--".$n;
                print_r($value);
            echo $n;
            echo "--".$n;
        }
    }
}


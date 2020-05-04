<?php

class Debug
{
    public static function ddf($filename, $value)
    {
        ob_start();
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
        $str_value = ob_get_clean();

        $f = fopen(ROOT . '/log/' . $filename, 'a');
        fwrite($f, $str_value);
        fclose($f);
    }
}
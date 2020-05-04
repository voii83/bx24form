<?php

class FlashMessage
{
    public static function setFlash($key, $message)
    {
        $_SESSION[$key] = $message;
    }

    public static function hasFlash($key)
    {
        if (isset($_SESSION[$key])) {
            return true;
        }

        return false;
    }

    public static function getFlash($key)
    {
        $result = $_SESSION[$key];
        unset($_SESSION[$key]);

        return $result;
    }
}
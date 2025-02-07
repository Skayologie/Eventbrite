<?php

namespace App\core;

require realpath(__DIR__ . '/../../vendor/autoload.php');

class Validator
{
    public static function validate_email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validate_password($password) {
        return strlen($password) >= 8 &&
            preg_match('/[A-Z]/', $password) &&
            preg_match('/[a-z]/', $password) &&
            preg_match('/[0-9]/', $password);
    }

    public static function validate_username($username) {
        return preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username);
    }


}
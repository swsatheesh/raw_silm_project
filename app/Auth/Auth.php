<?php

namespace StockAnalysis\Auth;

use StockAnalysis\Models\User;

class Auth {

    public function user() {
        return User::find(isset($_SESSION['user']) ? $_SESSION['user']: null);
    }

    public function check() {
        return isset($_SESSION['user']);
    }

    public function attempt($email, $password) {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->id;
            return true;
        }

        return false;
    }

    public function logOut() {
        unset($_SESSION['user']);
    }
}
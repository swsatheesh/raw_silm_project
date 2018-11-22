<?php

    namespace StockAnalysis\Controllers\User;

    use StockAnalysis\Models\User;
    use StockAnalysis\Controllers\Controller;

    class UserController extends Controller {
        protected $user;
        public function getUser($request, $response) {
            $user = User::find(isset($_SESSION['user']) ? $_SESSION['user']: null);
            header('Content-Type: application/json');
            return $response->withJSON(
                $user,
                200,
                JSON_UNESCAPED_UNICODE
            );
        }

        public function checkUser() {
            return isset($_SESSION['user']);
        }
    }
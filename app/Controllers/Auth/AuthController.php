<?php

namespace StockAnalysis\Controllers\Auth;


use StockAnalysis\Models\User;
use StockAnalysis\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends  Controller {
    public function getLogOut($request, $response) {
        $this->auth->logOut();
        header('Content-Type: application/json');
        return $response->withJSON(
            ['status' => 'pass'],
            200,
            JSON_UNESCAPED_UNICODE
        );
    }
    public function postLogin($request, $response) {
        $parsedBody = $request->getParsedBody();
        $auth = $this->auth->attempt(
            $parsedBody['email'],
            $parsedBody['password']
        );

        if (!$auth) {
            header('Content-Type: application/json');
            return $response->withJSON(
                ['status' => 'fail'],
                200,
                JSON_UNESCAPED_UNICODE
            );
        } 

        header('Content-Type: application/json');
        return $response->withJSON(
            ['status' => 'pass'],
            200,
            JSON_UNESCAPED_UNICODE
        );
    }
    public function postSignup($request, $response) {
        $parsedBody = $request->getParsedBody();

        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'first_name' => v::notEmpty()->alpha(),
            'last_name' => v::notEmpty()->alpha(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed()) {
            header('Content-Type: application/json');
            return $response->withJSON(
                ['status' => 'fail', 'report' => $_SESSION['errors']],
                200,
                JSON_UNESCAPED_UNICODE
            );
        }

        $user = User::create([
                    'firstname' => $parsedBody['first_name'],
                    'lastname' => $parsedBody['last_name'],
                    'email' => $parsedBody['email'],
                    'mobile' => $parsedBody['display_name'],
                    'password' => password_hash($parsedBody['password'], PASSWORD_DEFAULT)
                ]);

        header('Content-Type: application/json');
        return $response->withJSON(
            ['status' => 'pass'],
            200,
            JSON_UNESCAPED_UNICODE
        );
    }
}
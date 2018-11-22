<?php

namespace StockAnalysis\Controllers\Auth;


use StockAnalysis\Models\User;
use StockAnalysis\Controllers\Controller;
use Respect\Validation\Validator as v;

class PasswordController extends  Controller {
    public function postChangePassword($request, $response) {
        $validation = $this->validator->validate($request, [
            'Oldpassword' => v::noWhitespace()->notEmpty()->matchesPassword($this->auth->user()->password),
            'Newpassword' => v::noWhitespace()->notEmpty()
        ]);

        if ($validation->failed()) {
            header('Content-Type: application/json');
            return $response->withJSON(
                ['status' => 'fail', 'report' => $_SESSION['errors']],
                200,
                JSON_UNESCAPED_UNICODE
            );
        }

        $this->auth->user()->setPassword($request->getParsedBody()['Newpassword']);

        header('Content-Type: application/json');
            return $response->withJSON(
                ['status' => 'pass'],
                200,
                JSON_UNESCAPED_UNICODE
            );
    }
}
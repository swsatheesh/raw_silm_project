<?php

namespace StockAnalysis\Validation\Rules;

use StockAnalysis\Models\User;
use Respect\Validation\Rules\AbstractRule;

class MatchesPassword extends AbstractRule {

    protected $password;

    public function __construct($password) {
        $this->password = $password;
    }
    public function validate($input) {
        return password_verify($input, $this->password);
    }
}
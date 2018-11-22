<?php

namespace StockAnalysis\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator {

    protected $errors;

    public function validate($request, array $rules) {
        $parsedBody = $request->getParsedBody();
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($parsedBody[$field]);
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
            
        }

        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    public function failed() {
        return !empty($this->errors);
    }
}
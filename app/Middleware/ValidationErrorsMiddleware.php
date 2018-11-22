<?php

namespace StockAnalysis\Middleware;

class ValidationErrorsMiddleware extends Middleware {

    public function __invoke($request, $response, $next) {
        unset($_SESSION['errors']);

        $response = $next($request, $response);
        return $response;   
    }
}
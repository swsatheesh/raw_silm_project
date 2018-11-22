<?php
    $app->post('/auth/signup', 'AuthController:postSignup');

    $app->post('/auth/login', 'AuthController:postLogin');

    $app->get('/user/getUser', 'UserController:getUser');

    $app->get('/user/checkUser', 'UserController:checkUser');

    $app->get('/auth/logout', 'AuthController:getLogOut');

    $app->post('/auth/password/change', 'PasswordController:postChangePassword');


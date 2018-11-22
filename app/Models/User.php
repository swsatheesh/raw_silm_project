<?php

    namespace StockAnalysis\Models;

    use Illuminate\Database\Eloquent\Model;

    class User extends Model {
        protected $table = 'users';

        protected $fillable = [
            'email',
            'firstname',
            'lastname',
            'password',
            'username',
            'mobile'
        ];

        public function setPassword($password) {

            $this->update([
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

        }
    }
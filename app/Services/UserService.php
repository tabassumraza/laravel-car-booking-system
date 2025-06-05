<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
        protected $model;

    public function __construct(){
         $this->model = new User();
    }
    public function createUser(array $data): User
    {
        $user = $this ->model->create ([
            
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
     
        return $user;
    }
}
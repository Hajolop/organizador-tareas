<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'name',
        'email',
        'password',
        'active',
        'administrator',
        'activation_token',
        'reset_token',
        'reset_expires',
        'profile_image',
        'remember_token',
        'remember_expires',
    ];
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRememberToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'remember_token'   => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'after' => 'profile_image'],
            'remember_expires' => ['type' => 'DATETIME', 'null' => true, 'after' => 'remember_token'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['remember_token', 'remember_expires']);
    }
}

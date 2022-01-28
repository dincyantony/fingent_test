<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
       $this->forge->addField([
          'id' => [
              'type' => 'INT',
              'constraint' => 5,
              'unsigned' => true,
              'auto_increment' => true,
          ],
          'emp_code' => [
              'type' => 'VARCHAR',
              'constraint' => '50',
          ],
          'emp_name' => [
              'type' => 'VARCHAR',
              'constraint' => '100',
          ],
          'designation' => [
              'type' => 'VARCHAR',
              'constraint' => '100',
          ],
          'age' => [
              'type' => 'INT',
              'constraint' => '10',
          ],
          'experience' => [
              'type' => 'INT',
              'constraint' => '10',
          ],          
       ]);
       $this->forge->addKey('id', true);
       $this->forge->createTable('employees');
    }

    public function down()
    {
        $this->forge->dropTable('employees');
    }
}

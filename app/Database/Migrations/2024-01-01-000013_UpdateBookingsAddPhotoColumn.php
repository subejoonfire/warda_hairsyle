<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateBookingsAddPhotoColumn extends Migration
{
    public function up()
    {
        $this->forge->addColumn('bookings', [
            'customer_photo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'notes',
            ],
            'price_confirmed' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'after'      => 'customer_photo',
            ],
            'price_status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'confirmed', 'rejected'],
                'default'    => 'pending',
                'after'      => 'price_confirmed',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('bookings', ['customer_photo', 'price_confirmed', 'price_status']);
    }
}
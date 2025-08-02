<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateBookingsServiceType extends Migration
{
    public function up()
    {
        // Update the service_type enum to include new service types
        $this->db->query("ALTER TABLE bookings MODIFY COLUMN service_type ENUM('salon', 'cornrow', 'boxbraid', 'home') DEFAULT 'salon'");
    }

    public function down()
    {
        // Revert back to original service types
        $this->db->query("ALTER TABLE bookings MODIFY COLUMN service_type ENUM('home', 'salon') DEFAULT 'salon'");
    }
}
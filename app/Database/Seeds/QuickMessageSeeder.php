<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class QuickMessageSeeder extends Seeder
{
    public function run()
    {
        $quickMessageModel = new \App\Models\QuickMessageModel();
        
        // Check if quick messages already exist
        if ($quickMessageModel->countAllResults() > 0) {
            return;
        }
        
        // Insert default quick messages
        $quickMessageModel->insertDefaultQuickMessages();
    }
}
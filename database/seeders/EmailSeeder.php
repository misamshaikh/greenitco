<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Email;   // ✅ ADD THIS LINE

class EmailSeeder extends Seeder
{
    public function run(): void
    {
        Email::create([
            'sender' => 'john@example.com',
            'recipient' => 'you@example.com',
            'subject' => 'Laptop Not Working Issue',
            'body' => 'Please check the attached report.',
            'attachments' => json_encode(['report.pdf']),
            'read' => false
        ]);

        Email::factory()->count(5)->create();
    }
}

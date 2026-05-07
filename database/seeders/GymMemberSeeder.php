<?php

namespace Database\Seeders;

use App\Models\GymMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GymMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'John Doe',
                'age' => 28,
                'gender' => 'male',
                'contact_number' => '+1234567890',
                'membership_plan' => 'Premium',
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'status' => 'active',
            ],
            [
                'name' => 'Jane Smith',
                'age' => 32,
                'gender' => 'female',
                'contact_number' => '+1234567891',
                'membership_plan' => 'Standard',
                'start_date' => '2024-02-15',
                'end_date' => '2024-08-15',
                'status' => 'active',
            ],
            [
                'name' => 'Mike Johnson',
                'age' => 25,
                'gender' => 'male',
                'contact_number' => '+1234567892',
                'membership_plan' => 'Basic',
                'start_date' => '2023-12-01',
                'end_date' => '2024-03-01',
                'status' => 'expired',
            ],
            [
                'name' => 'Sarah Williams',
                'age' => 30,
                'gender' => 'female',
                'contact_number' => '+1234567893',
                'membership_plan' => 'VIP',
                'start_date' => '2024-03-01',
                'end_date' => '2025-03-01',
                'status' => 'active',
            ],
            [
                'name' => 'Tom Brown',
                'age' => 35,
                'gender' => 'male',
                'contact_number' => '+1234567894',
                'membership_plan' => 'Standard',
                'start_date' => '2024-01-15',
                'end_date' => '2024-07-15',
                'status' => 'inactive',
            ],
        ];

        foreach ($members as $member) {
            GymMember::create($member);
        }
    }
}

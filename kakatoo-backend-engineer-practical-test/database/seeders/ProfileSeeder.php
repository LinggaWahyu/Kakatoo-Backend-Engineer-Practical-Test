<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles = ['board', 'expert', 'trainer', 'competitor'];

        foreach ($profiles as $profile) {
            Profile::create([
                'name' => $profile
            ]);
        }
    }
}

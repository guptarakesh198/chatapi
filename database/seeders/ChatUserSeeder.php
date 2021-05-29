<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\ChatUser;

class ChatUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ChatUser::insert([
            'phoneno' => '8690859176',
        ]);

        ChatUser::insert([
            'phoneno' => '8690859175',
        ]);
    }
}

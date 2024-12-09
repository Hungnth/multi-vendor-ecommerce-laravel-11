<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@gmail.com')->first();
        $vendor = new Vendor();
        $vendor->banner = 'uploads/1234.jpg';
        $vendor->phone = '1234564879';
        $vendor->email = 'admin@gmail.com';
        $vendor->address = 'USA';
        $vendor->description = 'Shop Description';
        $vendor->user_id = $user->id;
        $vendor->save();
    }
}

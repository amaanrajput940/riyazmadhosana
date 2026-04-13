<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KalaamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $title = 'شفاعت کی التجا';

        DB::table('kalaam')->insert([
            'title' => $title,
            'slug' => Str::slug($title) ?: uniqid(),

            'poet_name' => null, // agar unknown ho

            'content' =>
"شفاعت شفیع الوری کیجیۓ گا
میری روزِ محشر ذرا کیجیۓ گا

شفاعت کی قدرت تمھیں کو ملی ہے
شفاعت شہِ انبیاء کیجیۓ گا",

            'lines_per_sheir' => 2,

            'thumbnail' => null,
            'is_active' => true,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

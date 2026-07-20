<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Urgent', 'color' => 'danger'],
            ['name' => 'Important', 'color' => 'warning'],
            ['name' => 'Work', 'color' => 'primary'],
            ['name' => 'Personal', 'color' => 'info'],
            ['name' => 'Study', 'color' => 'success'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::updateOrCreate(
                ['name' => $category['name']],
                ['color' => $category['color']]
            );
        }
    }
}

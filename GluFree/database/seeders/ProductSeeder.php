<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category=Category::first();

        if($category){
            Product::firstOrCreate(
                ['name'=> 'Pâtes Riz Bio'],
                [
                    'description' => 'Pâtes 100% farine de riz, sans gluten.',
                    'price' => 4.99,
                    'quantitéStock'=> 100,
                    'category_id' => $category->id,
                    'photo' => '',
                    'certificationSansGluten'=> true,

                ]
            );
        }
    }
}

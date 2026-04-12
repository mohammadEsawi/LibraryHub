<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            ['name' => 'الخيال العلمي', 'description' => 'قصص خيالية علمية ومشوقة'],
            ['name' => 'الرومانسية', 'description' => 'قصص الحب والعاطفة'],
            ['name' => 'المغامرة', 'description' => 'حكايات مثيرة ومليئة بالحركة'],
            ['name' => 'التنمية الذاتية', 'description' => 'كتب لتطوير الذات والمهارات'],
            ['name' => 'التاريخ', 'description' => 'كتب تاريخية وحقائق عن الماضي'],
            ['name' => 'الغموض والإثارة', 'description' => 'قصص غامضة ومشوقة'],
            ['name' => 'الدراما', 'description' => 'قصص درامية وحزينة'],
            ['name' => 'الخيال', 'description' => 'قصص خيالية ساحرة'],
        ];

        return fake()->randomElement($categories);
    }
}

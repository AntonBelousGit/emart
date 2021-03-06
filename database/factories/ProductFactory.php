<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
            'summary' => $this->faker->text,
            'description' => $this->faker->paragraphs(4,true),
            'additional_info' => $this->faker->paragraphs(4,true),
            'return_cancel' => $this->faker->paragraphs(4,true),
            'stock' => $this->faker->numberBetween(2, 10),
            'brand_id' => $this->faker->randomElement(Brand::pluck('id')->toArray()),
            'vendor_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'cat_id' => $this->faker->randomElement(Category::where('is_parent', 1)->pluck('id')->toArray()),
            'child_cat_id' => $this->faker->randomElement(Category::where('is_parent', 0)->pluck('id')->toArray()),
            'photo'=>$this->faker->imageUrl('250','250'),
            'size_guide'=>$this->faker->imageUrl('100','100'),
            'price' => $this->faker->numberBetween(100, 2000),
            'offer_price' => $this->faker->numberBetween(100, 2000),
            'discount' => $this->faker->numberBetween(1, 100),
            'size_id' => $this->faker->randomElement(Size::pluck('id')->toArray()),
            'condition' => $this->faker->randomElement(['new', 'popular', 'winter']),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}

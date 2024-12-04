<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Traits\FactoryHelperTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    use FactoryHelperTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->randomHtml(),
            'published_at' => fake()->dateTime(),
        ];
    }

    protected $model = Post::class;

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (Post $post) {
            // ...
        })->afterCreating(function (Post $post) {
            // $url = fake()->imageUrl(width: 600, height: 300);

            // $post->addMediaFromUrl($url)
            //     ->toMediaCollection('cover');

            // * 建議改用本機生成
            [$file, $image] = $this->randomImage(storage_path('files'));

            $post->addMediaFromBase64($image)
                ->usingFileName($file)
                ->toMediaCollection('cover');
        });
    }

    public function notPublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => null,
        ]);
    }
}

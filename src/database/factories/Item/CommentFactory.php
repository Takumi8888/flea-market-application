<?php

namespace Database\Factories\Item;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'profile_id' => $this->faker->numberBetween(1, 8),
            'item_id'    => $this->faker->numberBetween(1, 8),
            'comment'    => $this->faker->randomElement([
                '購入を検討しています',
                '予算が足りないのですが、安くなりますでしょうか',
                '早急に入用なのですが、配送までにどれくらい掛かりますか',
                '他の商品とまとめて購入したいと考えていますが、まとめ買いで安くなりますか',
                '他の画像はありますか',
            ]),
        ];
    }
}

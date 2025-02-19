<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class ListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_a_new_listing()
    {
        Storage::fake('public');


        Artisan::call('migrate:refresh');
        $this->seed(\CategoriesTableSeeder::class);
        $this->seed(\ConditionsTableSeeder::class);


        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('listing.form'));
        $response->assertStatus(200);

        $categoryIds = Category::inRandomOrder()->limit(rand(1, 14))->pluck('id')->toArray();
        $condition = Condition::inRandomOrder()->first();

        $file = UploadedFile::fake()->image('item.jpg');

        $this->actingAs($user);

        $response = $this->post(route('listing.store'), [
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'description' => 'これはテスト商品です。',
            'price' => 5000,
            'condition' => $condition->name,
            'category'  => $categoryIds,
            'categories' => $categoryIds,
            'thumbnail' => $file,
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'description' => 'これはテスト商品です。',
            'price' => 5000,
            'condition_id' => $condition->id,
            'user_id' => $user->id,
        ]);

        $item = Item::where('name', 'テスト商品')->first();
        foreach ($categoryIds as $categoryId) {
        $this->assertTrue($item->categories->contains($categoryId));
        }

        Storage::disk('public')->assertExists($item->thumbnail);

        $response->assertRedirect('/');
        $response->assertSessionHas('success', '出品登録が完了しました');
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Artisan;


class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    /** @test */
    public function a_user_can_post_a_comment()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed', ['--class' => 'ConditionsTableSeeder']);

        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);

        $commentData = [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'この商品は素晴らしい！'
        ];

        $response = $this->post(route('comment.store', $item->id), $commentData);

        $this->assertDatabaseHas('comments', $commentData);

        $response->assertStatus(302);
    }

    /** @test */
    public function an_authenticated_user_cannot_post_a_comment()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed', ['--class' => 'ConditionsTableSeeder']);

        $item = Item::factory()->create();
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);

        $commentData = [
            'item_id' => $item->id,
            'comment' => 'この商品は素晴らしい！'
        ];

        $response = $this->post(route('comment.store', $item->id), $commentData);

        $this->assertDatabaseMissing('comments', $commentData);

        $response->assertRedirect(route('login'));
    }

     /** @test */
    public function a_comment_requires_content()
    {

        Artisan::call('migrate:refresh');
        Artisan::call('db:seed', ['--class' => 'ConditionsTableSeeder']);

        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);

        $commentData = [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => ''
        ];

        $response = $this->post(route('comment.store', $item->id), $commentData);

        $response->assertSessionHasErrors(['comment' => 'コメントを入力してください']);
        $this->assertDatabaseMissing('comments', $commentData);
    }

    /** @test */
    public function a_comment_cannot_exceed_255_characters()
    {

        Artisan::call('migrate:refresh');
        Artisan::call('db:seed', ['--class' => 'ConditionsTableSeeder']);

        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);

        $commentData = [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => str_repeat('あ', 256),
        ];

        $response = $this->post(route('comment.store', $item->id), $commentData);

        $response->assertSessionHasErrors(['comment' => 'コメントは255文字以内で入力してください']);
        $this->assertDatabaseMissing('comments', $commentData);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class SearchTest extends TestCase
{
    /**
     * A basic feature test example.
     */
        use RefreshDatabase , WithFaker;

    /** @test */
    public function user_can_search_for_items()
    {

        Artisan::call('migrate:refresh');
        Artisan::call('db:seed', ['--class' => 'ConditionsTableSeeder']);

        $item = Item::create([
            'name' => 'Test Item',
            'thumbnail' => 'test-image.jpg',
            'price' => $this->faker->randomNumber(6),
            'description' => $this->faker->sentence,
            'user_id' => null,
            'condition_id' => $this->faker->numberBetween(1, 4),
        ]);

        $response = $this->get('/?search=Test');

        $response->assertStatus(200);

        $response->assertSeeText('Test Item');
    }
    /** @test */
    public function search_query_is_retained_on_mylist_page()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed', ['--class' => 'ConditionsTableSeeder']);

        $item = Item::create([
            'name' => 'Test Item',
            'thumbnail' => 'test-image.jpg',
            'price' => $this->faker->randomNumber(6),
            'description' => $this->faker->sentence,
            'user_id' => null,
            'condition_id' => $this->faker->numberBetween(1, 4),
        ]);

        $response = $this->get('/?search=Test');

        $response->assertSeeText('Test Item');

        $response = $this->get('/?page=mylist&search=Test');

        $responseText = $response->getContent();
        $decodedValue = html_entity_decode('Test');
        $this->assertStringContainsString('value="'.$decodedValue.'"', $responseText);

        $response->assertStatus(200);
    }

}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class NewsTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * @test
     */
    public function can_view_news(): void
    {
        $response = $this->getJson('/api/v1/news');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function can_search_news(): void
    {
        $response = $this->getJson('/api/v1/news?search_query=Thursday');

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data')
            ->has('links')
            ->has('meta')
        );
    }

    /**
     * @test
     */
    public function can_search_and_filter_news_by_published_date(): void
    {
        $response = $this->getJson('/api/v1/news?search_query=Thursday&published_date=2025-01-09');

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data')
            ->has('links')
            ->has('meta')
        );
    }

    /**
     * @test
     */
    public function can_add_user_preference(): void
    {
        $response = $this->postJson('/api/v1/news/adds/preferences',[
            'news_id' => 16
        ]);

        $response->assertStatus(201);
    }

    /**
     * @test
     */
    public function can_view_preferences(): void
    {
        $response = $this->getJson('/api/v1/news/users/preferences');

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data')
            ->has('links')
            ->has('meta')
        );
    }

    /**
     * @test
     */
    public function can_view_a_preferences(): void
    {
        $response = $this->getJson('/api/v1/news/users/preferences/8');

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('data.id',8)
            ->where('data.type',"App\\Http\\Resources\\UserPreferenceResource")
        );
    }

    /**
     * @test
     */
    public function can_search_and_filter_preferences(): void
    {
        $response = $this->getJson('/api/v1/news/users/preferences?search_query=Thursday&published_date=2025-01-09');

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data')
            ->has('links')
            ->has('meta')
        );
    }

    /**
     * @test
     */
    public function can_remove_user_preference(): void
    {
        $response = $this->postJson('/api/v1/news/removes/preferences',[
            'news_id' => 16,
            '_method' => 'delete'
        ]);

        $response->assertStatus(200);
    }
}

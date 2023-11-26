<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function it_can_list_posts()
    {
        $posts = Post::factory(10)->create();

        $response = $this->getJson(route('posts.index'));

        $response->assertOk()->assertJsonCount(10, 'data');
    }

    /**
     * @test
     */
    public function it_can_create_a_post()
    {
        $data = Post::factory()->make()->toArray();

        $response = $this->postJson(route('posts.store'), $data);

        $response->assertCreated()->assertJson($data);
    }

    /**
     * @test
     */
    public function it_can_show_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->getJson(route('posts.show', $post));

        $response->assertOk()->assertJson($post->toArray());
    }

    /**
     * @test
     */
    public function it_can_update_a_post()
    {
        $post = Post::factory()->create();

        $data = Post::factory()->make()->toArray();

        $response = $this->putJson(route('posts.update', $post), $data);

        $response->assertOk()->assertJson($data);
    }

    /**
     * @test
     */
    public function it_can_delete_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson(route('posts.destroy', $post));

        $response->assertNoContent();
    }
}

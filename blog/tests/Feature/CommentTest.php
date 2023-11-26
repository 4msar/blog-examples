<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function it_can_list_comments()
    {
        $comments = Comment::factory(10)->create();

        $response = $this->getJson(route('posts.comments.index', $comments->first()->post_id));

        $response->assertOk()->assertJsonCount(10, 'data');
    }

    /**
     * @test
     */
    public function it_can_create_a_comment()
    {
        $comment = Comment::factory()->make();

        $response = $this->postJson(route('posts.comments.store', $comment->post_id), $comment->toArray());

        $response->assertCreated()->assertJson($comment->toArray());
    }

    /**
     * @test
     */
    public function it_can_show_a_comment()
    {
        $comment = Comment::factory()->create();

        $response = $this->getJson(route('posts.comments.show', [$comment->post_id, $comment]));

        $response->assertOk()->assertJson($comment->toArray());
    }

    /**
     * @test
     */
    public function it_can_update_a_comment()
    {
        $comment = Comment::factory()->create();

        $data = Comment::factory()->make()->toArray();

        $response = $this->putJson(route('posts.comments.update', [$comment->post_id, $comment]), $data);

        $response->assertOk()->assertJson($data);
    }

    /**
     * @test
     */
    public function it_can_delete_a_comment()
    {
        $comment = Comment::factory()->create();

        $response = $this->deleteJson(route('posts.comments.destroy', [$comment->post_id, $comment]));

        $response->assertNoContent();
    }
}

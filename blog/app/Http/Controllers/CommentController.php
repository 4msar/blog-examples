<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Post $post): AnonymousResourceCollection
    {
        $comments = $post->comments()->with('user')->paginate(10);

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCommentRequest $request
     * @return CommentResource
     */
    public function store(Post $post, StoreCommentRequest $request): CommentResource
    {
        $comment = $post->comments()->create($request->validated());

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param Comment $comment
     * @return CommentResource
     */
    public function show(Post $post, Comment $comment): CommentResource
    {
        $comment->load('user');

        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCommentRequest $request
     * @param Comment $comment
     * @return CommentResource
     */
    public function update(Post $post, UpdateCommentRequest $request, Comment $comment): CommentResource
    {
        $comment->update($request->validated());

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return JsonResponse
     */
    public function destroy(Post $post, Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully.']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Repositories\PostCommentRepository;
use Illuminate\Support\Facades\Log;

class PostCommentController extends Controller
{
    public function __construct(
        private readonly PostCommentRepository $comment,
    ) {}

    public function index(int $postId)
    {
        try {
            $comments = $this->comment->get($postId);
            return response()->json([
                'data' => $comments
            ]);
        } catch (\Throwable $th) {
            Log::error('Error fetching comments: ' . $th->getMessage());
            return response()->json([
                'error' => 'Failed to fetch comments.'
            ], 500);
        }
    }

    public function store(CommentRequest $request)
    {
        try {
            $data = $request->validatedData();
            $comment = $this->comment->store($data);
            return response()->json([
                'message' => 'Comment created successfully.',
                'data' => $comment
            ], 201);
        } catch (\Throwable $th) {
            Log::error('Error creating comment: ' . $th->getMessage());
            return response()->json([
                'error' => 'Failed to create comment.'
            ], 500);
        }
    }
}
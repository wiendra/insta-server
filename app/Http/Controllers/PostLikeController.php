<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\PostLikeRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostLikeController extends Controller
{
    public function __construct(
        private readonly PostLikeRepository $post,
    ){}

    public function like(int $postId)
    {
        try {
            $data = [
                'user_id' => Auth::id(),
                'post_id' => $postId,
            ];
            $this->post->store($data);
            return response()->json([
                'message' => 'Post liked successfully.'
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error creating post like: ' . $th->getMessage());
            return response()->json([
                'error' => 'Failed to create post like.'
            ], 500);
        }
    }

    public function unlike(int $postId)
    {
        try {
            $userId = Auth::id();
            $this->post->delete($postId, $userId);
            return response()->json([
                'message' => 'Post unliked successfully.'
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error deleting post like: ' . $th->getMessage());
            return response()->json([
                'error' => 'Failed to delete post like.'
            ], 500);
        }
    }

}
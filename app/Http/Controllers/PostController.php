<?php
namespace App\Http\Controllers;

use App\Enums\Visibility;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function __construct(
        private readonly PostRepository $post,
    ){}

    public function latest()
    {
        try {
            $data = [
                'authenticated_user_id' => Auth::id(),
                'visibility' => Visibility::Public->toNumber(),
            ];
            $posts = $this->post->latest($data);
            return response()->json([
                'data' => $posts
            ]);
        } catch (\Throwable $th) {
            Log::error('Error fetching latest posts: ' . $th->getMessage());
            return response()->json([
                'error' => 'Failed to fetch latest posts.'
            ], 500);
        }
    }

    public function detail(int $id)
    {
        try {
            $data = [
                'authenticated_user_id' => Auth::id(),
            ];
            $post = $this->post->find($id, $data);
            return response()->json([
                'post' => $post
            ]);
        } catch (ModelNotFoundException $e) {
            Log::error('Post not found: ' . $e->getMessage());
            return response()->json([
                'error' => 'Post not found.'
            ], 404);
        } catch (\Throwable $th) {
            Log::error('Error fetching post detail: ' . $th->getMessage());
            return response()->json([
                'error' => 'Failed to fetch post detail.'
            ], 404);
        }
    }

    public function byUser()
    {
        try {
            $userId = Auth::id();
            $posts = $this->post->byUser($userId);
            return response()->json([
                'data' => $posts
            ]);
        } catch (\Throwable $th) {
            Log::error('Error fetching posts by user: ' . $th->getMessage());
            return response()->json([
                'error' => 'Failed to fetch posts by user.'
            ], 500);
        }
    }

    public function create(PostRequest $request)
    {
        try {
            $data = $request->validatedData();
            $this->post->create($data);
            return response()->json([
                'message' => 'Post created successfully.',
                'data' => $data
            ], 201);
        } catch (\Throwable $th) {
            Log::error('Error creating post: ' . $th->getMessage());
            return response()->json([
                'error' => 'Failed to create post.'
            ], 500);
        }
    }

    public function delete(int $id)
    {
        try {
            $this->post->delete($id);
            return response()->json([
                'message' => 'Post deleted successfully.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Post not found for deletion: ' . $e->getMessage());
            return response()->json([
                'error' => 'Post not found.'
            ], 404);
        } catch (\Throwable $th) {
            Log::error('Error deleting post: ' . $th->getMessage());
            return response()->json([
                'error' => 'Failed to delete post.'
            ], 500);
        }
    }
}
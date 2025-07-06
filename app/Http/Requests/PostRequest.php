<?php

namespace App\Http\Requests;

use App\Enums\Visibility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'caption' => 'nullable|string|max:2000',
            'enable_comment' => 'required',
            'enable_like' => 'required',
            'visibility' => 'required|integer|between:1,3',
            'images' => 'required|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120'
        ];
    }

    public function messages()
    {
        return [
            'images.required' => 'Please upload at least one image',
            'images.*.max' => 'Each image must be less than 5MB',
        ];
    }

    public function validatedData()
    {
        $images = [];

        if ($this->hasFile('images')) {
            $uploadedImages = $this->file('images');
            $images = array_map(
                function ($index) use ($uploadedImages) {
                    $image = $uploadedImages[$index];
                    return [
                        'image' => $image->storeAs(
                            'posts',
                            Str::uuid().'.'.$image->extension(),
                            'public'
                        ),
                        'order' => $index + 1,
                    ];
                },
                array_keys($uploadedImages)
            );
        }

        return [
            'post' => [
                'user_id' => $this->user()->id,
                'caption' => $this->input('caption'),
                'enable_comment' => $this->input('enable_comment', true),
                'enable_like' => $this->input('enable_like', true),
                'visibility' => $this->input('visibility', Visibility::Public->toNumber()),
            ],
            'images' => $images,
        ];
    }
}

<?php

namespace App\Http\Requests\Backend;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // return [
        //     'image' => ['required', 'image', 'max:5120'],
        //     'name' => ['required', 'string', 'max:200'],
        //     'category' => ['required'],
        //     'brand' => ['required'],
        //     'price' => ['required'],
        //     'qty' => ['required'],
        //     'short_description' => ['required', 'max:600'],
        //     'long_description' => ['required'],
        //     'video_link' => ['url'],
        //     'seo_title' => ['nullable', 'max:255'],
        //     'seo_description' => ['nullable', 'max:600'],
        //     'status' => ['required'],
        // ];

        $rules = [
            'image' => ['required', 'image', 'max:5120'],
            'name' => ['required', 'string', 'max:200'],
            'category' => ['required'],
            'brand' => ['required'],
            'price' => ['required'],
            'qty' => ['required'],
            'short_description' => ['required', 'max:600'],
            'long_description' => ['required'],
            'video_link' => ['url'],
            'seo_title' => ['nullable', 'max:255'],
            'seo_description' => ['nullable', 'max:600'],
            'status' => ['required'],
        ];

        if ($this->isMethod('put')) {
            $rules['image'] = ['nullable', 'image', 'max:5120'];
        }

        return $rules;
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\ExistsUser;
use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'          => ['required','string'],
            'description'   => ['required','string'],
            'published'     => ['required','date_format:Y-m-d'],
            'authors'       => ['required','array','exists:authors,id'],
            'media'         => ['required','max:2048']
        ];
    }

    public function messages(): array
    {
        return [
            'media.max' => 'Maximum file size to upload is 2MB (2048 KB). If you are uploading a photo, try to reduce its resolution to make it under 2MB'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Any authenticated user can create a task.
        // Laravel's auth middleware protects the route, so we can return true here.
        return auth()->check();
    }
    /**
     * Prepare the data for validation.
     * Used to clean/sanitize inputs (e.g. trimming spaces and stripping tags).
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => strip_tags(trim($this->title)),
            'description' => strip_tags(trim($this->description)),
            'note' => $this->note ? strip_tags(trim($this->note)) : null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'note' => 'nullable|string',
        ];
    }

    /**
     * Get the custom validation error messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'A task title is required to create a task.',
            'title.max' => 'The task title must be less than 255 characters.',
            'description.required' => 'Please enter a description of what needs to be done.',
        ];
    }
}

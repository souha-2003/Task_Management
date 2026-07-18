<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Get the Task model bound from the route (e.g. /tasks/{task})
        $task = $this->route('task');

        // Allow update only if task exists and belongs to the currently logged in user
        return $task && $task->user_id === $this->user()->id;
    }

    /**
     * Prepare the data for validation.
     * Used to clean/sanitize inputs (e.g. trimming spaces and stripping tags).
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => strip_tags(trim($this->title)),
            'description' => trim($this->description),
            'note' => $this->note ? trim($this->note) : null,
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
            'title.required' => 'The task title cannot be left blank.',
            'title.max' => 'The task title cannot exceed 255 characters.',
            'description.required' => 'Please enter a description for the task update.',
        ];
    }
}

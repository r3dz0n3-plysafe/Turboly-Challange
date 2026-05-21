<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

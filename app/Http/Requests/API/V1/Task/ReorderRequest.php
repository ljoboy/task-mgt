<?php

namespace App\Http\Requests\API\V1\Task;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class ReorderRequest extends FormRequest
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
     * @return array<string, array|string>
     */
    public function rules(): array
    {
        return [
            'task_id' => [
                'required',
                'exists:tasks,id',
            ],
            'new_priority' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }
}

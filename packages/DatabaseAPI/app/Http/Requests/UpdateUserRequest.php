<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;
use App\Traits\ValidationTrait;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateUserRequest extends FormRequest
{
    use ValidationTrait;

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string',
            'contract_date' => 'nullable|date',
            'email' => 'nullable|email|unique:users,email,' . $this->route('user'),
            'password' => 'nullable|string|min:6',
        ];
    }
}

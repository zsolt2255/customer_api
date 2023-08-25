<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;
use App\Traits\ValidationTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;

class StoreUserRequest extends FormRequest
{
    use ValidationTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return parent::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [];

        if (! $this->isArrayRequest()) {
            $rules = [
                'name' => 'required|string',
                'contract_date' => 'required|date',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ];
        } else {
            $rules['*.name'] = 'required|string';
            $rules['*.code'] = 'nullable|string';
            $rules['*.contract_date'] = 'required|date';
            $rules['*.email'] = 'required|email|unique:users,email';
            $rules['*.password'] = 'required|string|min:6';
        }

        $rules['addresses.*.street'] = 'required|string';
        $rules['addresses.*.city'] = 'required|string';
        $rules['addresses.*.postal_code'] = 'required|string';

        return $rules;
    }

    /**
     * @return bool
     */
    protected function isArrayRequest(): bool
    {
        return is_array(Arr::first($this->input()));
    }
}

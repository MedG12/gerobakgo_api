<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Merchant;

class UpdateLocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $merchantToUpdate = Merchant::with(['user'])->find($this->route(param: 'id'));

        if (!$merchantToUpdate) {
            return false;
        }

        return $merchantToUpdate->user->user_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,user_id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
    }
}

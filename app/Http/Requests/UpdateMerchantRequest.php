<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UpdateMerchantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $userToUpdate = User::find($this->route(param: 'id'));

        if (!$userToUpdate) {
            return false;
        }

        return $userToUpdate->id === auth()->id() || auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
            'photoUrl' => 'sometimes|string',
            'description' => 'sometimes|string',
            'openHour' => 'sometimes|required|date_format:H:i:s|before:closeHour',
            'closeHour' => 'sometimes|required|date_format:H:i:s|after:openHour'
        ];
    }
}

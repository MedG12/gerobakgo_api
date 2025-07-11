<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Cari user yang akan diupdate
        $userToUpdate = User::find($this->route('id'));

        // Jika user tidak ditemukan
        if (!$userToUpdate) {
            return false;
        }

        // Bandingkan dengan user yang sedang login (gunakan guard sanctum)
        return $userToUpdate->user_id === auth()->id() || auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email',
            'photoUrl' => 'sometimes|nullable|string',
        ];
    }
}

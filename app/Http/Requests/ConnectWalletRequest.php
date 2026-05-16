<?php
// File: app/Http/Requests/ConnectWalletRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConnectWalletRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'wallet_address' => 'required|string|size:42',
            'signature' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
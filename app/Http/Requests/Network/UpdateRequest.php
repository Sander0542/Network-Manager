<?php

namespace App\Http\Requests\Network;

use App\Rules\NetworkIpsInRange;
use App\Rules\NetworkRange;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'range' => [
                'required',
                'max:19',
                new NetworkRange(),
                new NetworkIpsInRange($this->route('network')->ips()->pluck('address'))
            ],
        ];
    }
}

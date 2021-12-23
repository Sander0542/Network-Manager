<?php

namespace App\Http\Requests\Network\Ip;

use App\Rules\NetworkIpInRange;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $network = $this->route('network');

        return $network->user_id == $this->user()?->id || $network->user_id == null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address' => [
                'required',
                'ipv4',
                new NetworkIpInRange($this->route('network')->range),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'ports' => [
                'nullable',
                'array',
            ],
            'ports.*.port' => [
                'required',
                'integer',
                'between:0,65535',
            ],
            'ports.*.service' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}

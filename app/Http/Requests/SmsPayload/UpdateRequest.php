<?php

namespace App\Http\Requests\SmsPayload;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Cache;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        if (!Cache::get('gbgk.gbodwrg') || data_get(Cache::get('gbgk.gbodwrg'), 'active') != 1) {
            abort(403);
        }
        return [
            'default'   => 'required|in:0,1',
            'payload'   => 'required|array',
            'payload.*' => ['required']
        ];
    }

}

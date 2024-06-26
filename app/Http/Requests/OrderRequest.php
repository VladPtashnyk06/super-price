<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if (isset($this->user_phone)) {
            if (!str_starts_with($this->user_phone, '+380')) {
                if (str_starts_with($this->user_phone, '0')) {
                    $this->merge([
                        'user_phone' => '+38' . $this->user_phone,
                    ]);
                } else {
                    $this->merge([
                        'user_phone' => '+380' . $this->user_phone,
                    ]);
                }
            }
        }
    }
    public function rules(): array
    {
        return [
            'user_id' => ['nullable'],
            'payment_method_id' => ['required'],
            'user_name' => ['required', 'string'],
            'user_last_name' => ['required', 'string'],
            'user_middle_name' => ['required', 'string'],
            'user_phone' => ['required', 'regex:/^\+380(39|67|68|96|97|98|50|66|95|99|63|73|93)\d{7}$/'],
            'user_email' => ['nullable', 'string'],
            'password' => ['nullable'],
            'password_confirmation' => ['nullable'],
            'comment' => ['nullable'],
            'total_price' => ['required'],
            'currency' => ['required', 'string'],
            'cost_delivery' => ['required', 'string'],
            'delivery_type' => ['required', 'string'],
            'promo_code' => ['nullable', 'string'],
            'points' => ['nullable', 'integer'],
            'city_ref' => ['nullable', 'string'],
            'branch_ref' => ['nullable', 'string'],
            'branch_number' => ['nullable', 'integer'],
            'city_name' => ['nullable', 'string'],
            'region' => ['nullable', 'string'],
            'nova_poshta_region_ref' => ['nullable', 'string'],
            'nova_poshta_city_input' => ['nullable', 'string'],
            'nova_poshta_branches_input' => ['nullable', 'string'],
            'meest_region_ref' => ['nullable', 'string'],
            'meest_city_input' => ['nullable', 'string'],
            'meest_branches_input' => ['nullable', 'string'],
            'ukr_poshta_region_ref' => ['nullable', 'string'],
            'ukr_poshta_city_input' => ['nullable', 'string'],
            'ukr_poshta_branches_input' => ['nullable', 'string'],
            'district_ref' => ['nullable', 'string'],
            'district_input' => ['nullable', 'string'],
            'village_ref' => ['nullable', 'string'],
            'village_input' => ['nullable', 'string'],
            'street_ref' => ['nullable', 'string'],
            'street_input' => ['nullable', 'string'],
            'house' => ['nullable', 'string'],
            'flat' => ['nullable', 'string'],
        ];
    }
}

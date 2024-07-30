<?php

namespace App\Api\V1\Http\Requests\Review;

use App\Api\V1\Http\Requests\BaseRequest;

class ReviewRequest extends BaseRequest
{

    protected function methodPost():array
    {
        return[
            'product_id' => ['required', 'exists:App\Models\Product,id'],
            'rating' => ['required'],
            'content'=>['required','string'],
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
  protected function methodGet(): array
    {
        return [
            'product_id' => ['required', 'exists:App\Models\Product,id'],
            'rating' => ['nullable'],
            'per_page'=>['nullable','integer','min:1'],
        ];
    }
}

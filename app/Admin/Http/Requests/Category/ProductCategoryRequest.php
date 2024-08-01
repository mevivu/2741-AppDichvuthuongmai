<?php

namespace App\Admin\Http\Requests\Category;

use App\Admin\Http\Requests\BaseRequest;
use App\Admin\Rules\Category\CategoryParent;

class ProductCategoryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'name' => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:App\Models\Category,id'],
            'position' => ['required', 'integer'],
            'is_active' => ['required', 'boolean'],
            'avatar' => ['required']
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Category,id'],
            'name' => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:App\Models\Category,id', new CategoryParent($this->id)],
            'position' => ['nullable', 'integer'],
            'is_active' => ['required', 'boolean'],
            'avatar' => ['required']
        ];
    }
}

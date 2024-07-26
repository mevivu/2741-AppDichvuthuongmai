<?php

namespace App\Api\V1\Http\Requests\Cart;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Repositories\Area\AreaRepository;
use App\Api\V1\Repositories\Discount\DiscountRepositoryInterface;
use App\Api\V1\Rules\Area\CoordinateInArea;
use App\Api\V1\Rules\Cart\ValidCartItemIds;
use App\Api\V1\Rules\Discount\ValidDiscountCode;
use App\Enums\Area\AreaStatus;

class CartItemRequest extends BaseRequest
{
    protected AreaRepository $areaRepository;

    protected DiscountRepositoryInterface $discountRepository;


    public function __construct(AreaRepository              $areaRepository,
                                DiscountRepositoryInterface $discountRepository)
    {
        $this->areaRepository = $areaRepository;
        $this->discountRepository = $discountRepository;

    }

    protected function methodPost(): array
    {
        $areas = $this->areaRepository->getBy(['status' => AreaStatus::On]);
        $areaRule = new CoordinateInArea($areas);

        return [
//            'cart_item_ids' => ['required', 'array', new ValidCartItemIds($this->input('cart_id'))],
            'store_id' => 'required|exists:stores,id',
            'coordinates' => ['nullable','sometimes', $areaRule],
            'discount_code' => ['nullable', 'string', new ValidDiscountCode()],
            "points" => ['nullable', 'numeric'],

        ];
    }

    public function all($keys = null): array
    {
        $data = parent::all($keys);
        $lat = floatval($this->input('lat'));
        $lng = floatval($this->input('lng'));
        if($lat && $lng){
            $data['coordinates'] = [
                'lat' => $lat,
                'lng' => $lng
            ];
        }
        else{
            unset($data['lat'], $data['lng']);

        }

        return $data;
    }

    protected function methodPut(): array
    {
        return [
            'id' => 'required|exists:carts,id',
            'qty' => 'required|integer|min:1',
        ];
    }

    protected function methodDelete(): array
    {
        return [
            'id' => 'required|exists:carts,id',
        ];
    }
}

<?php

namespace App\Api\V1\Services\Order;

use App\Api\V1\Services\Order\OrderServiceInterface;
use App\Api\V1\Repositories\Order\{OrderRepositoryInterface, OrderDetailRepositoryInterface};
use App\Api\V1\Repositories\ShoppingCart\ShoppingCartRepositoryInterface;
use App\Enums\Order\{OrderStatus, PaymentMethod};
use App\Enums\Product\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Api\V1\Support\AuthSupport;

class OrderService implements OrderServiceInterface
{
    use AuthSupport;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;
    
    protected $repository;
    protected $repositoryOrderDetail;
    protected $repositoryShoppingCart;
    protected $subTotal = 0;
    protected $orderDetail = [];

    public function __construct(
        OrderRepositoryInterface $repository,
        OrderDetailRepositoryInterface $repositoryOrderDetail,
        ShoppingCartRepositoryInterface $repositoryShoppingCart,
    ){
        $this->repository = $repository;
        $this->repositoryOrderDetail = $repositoryOrderDetail;
        $this->repositoryShoppingCart = $repositoryShoppingCart;
    }
    
    public function store(Request $request){
        $this->data = $request->validated();
        $this->data['user_id'] = auth()->user()->id;
        $this->data['discount'] = 0;
        $this->data['payment_method'] = PaymentMethod::BankTransfer;
        $this->data['status'] = OrderStatus::Processing;
        DB::beginTransaction();
        try {
            $makeData = $this->getDataFromShoppingCart();
            if(!$makeData){
                return false;
            }

            $this->data['sub_total'] = $this->data['total'] = $this->subTotal;

            $order = $this->repository->create($this->data);

            $this->storeOrderDetail($order->id, $this->orderDetail);

            $this->repositoryShoppingCart->deleteAllCurrentAuth();

            DB::commit();
            return $order;
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            return false;
        }
    }

    public function update(Request $request){
        
        $this->data = $request->validated();


    }
    public function cancel(Request $request){

        return $this->repository->cancel($request->input('id'));

    }

    public function delete($id){
        return $this->repository->delete($id);
    }

    protected function storeOrderDetail($orderId, $data){
        foreach($data as $item){
            $item['order_id'] = $orderId;
            $this->repositoryOrderDetail->create($item);
        }
    }

    protected function getDataFromShoppingCart(){
        $shoppingCarts = $this->repositoryShoppingCart->getAuthCurrent();
        if($shoppingCarts->count() == 0){
            return false;
        }
        $discount = 1 - $this->getDiscountProduct() / 100;

        $shoppingCarts->map(function($shoppingCart) use ($discount){

            $discount = $shoppingCart->product->is_user_discount == true ? $discount : 1;
            $unitPrice = 0;

            if($shoppingCart->product->isSimple()){
                $unitPrice = $shoppingCart->product->promotion_price ?: $shoppingCart->product->price;
            }else{
                $unitPrice = $shoppingCart->productVariation->promotion_price ?: $shoppingCart->productVariation->price;
            }
            $unitPrice = $unitPrice * $discount;

            $this->orderDetail[] = [
                'product_id' => $shoppingCart->product_id,
                'product_variation_id' => $shoppingCart->product_variation_id,
                'unit_price' => $unitPrice,
                'qty' => $shoppingCart->qty,
                'detail' => $shoppingCart->only('product', 'productVariation')
            ];
            $this->subTotal += $unitPrice * $shoppingCart->qty;
        });
        return true;
    }
}
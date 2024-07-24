<?php

namespace App\Store\Http\Controllers\Dashboard;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
class DashboardController extends Controller
{
    public $repoUser;
    public $repoOrder;
    public function __construct(
        UserRepositoryInterface $repoUser,
        OrderRepositoryInterface $repoOrder,
    )
    {
        parent::__construct();
        $this->repoUser = $repoUser;
        $this->repoOrder = $repoOrder;
    }

    public function getView()
    {
        return [
            'index' => 'stores.dashboard.index'
        ];
    }
    public function index(){
        $totaluser = $this->repoUser->count();

        $chartOrder = $this->repoOrder->chartRevenue([now()->subDays(7), now()]);
        $chartProductSold = $this->repoUser->chartUser([now()->subDays(7), now()]);
        
        return view($this->view['index'], [
            'total_user' => $totaluser,
            'breadcrums' => $this->crums,
            'chart_order' => $chartOrder,
            'chart_product_sold' => $chartProductSold,
        ]);
    }

}
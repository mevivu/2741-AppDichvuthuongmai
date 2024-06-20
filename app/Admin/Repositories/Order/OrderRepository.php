<?php

namespace App\Admin\Repositories\Order;

use App\Admin\Repositories\EloquentRepository;
use App\Models\Order;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use App\Enums\Order\OrderStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class OrderRepository extends EloquentRepository implements OrderRepositoryInterface
{
    public function getModel(): string
    {
        return Order::class;
    }

    public function getFlatTreeNotInNode(array $nodeId)
    {
        $this->getQueryBuilderOrderBy('position', 'ASC');
        $this->instance = $this->instance->whereNotIn('id', $nodeId)
            ->withDepth()
            ->get()
            ->toFlatTree();
        return $this->instance;
    }

    public function getFlatTree()
    {
        $this->getQueryBuilderOrderBy('position', 'ASC');
        $this->instance = $this->instance->withDepth()
            ->get()
            ->toFlatTree();
        return $this->instance;
    }

    public function getOrdersByUserId($userId)
    {
        $filter = ['customer_id' => $userId];
        return $this->getByQueryBuilder($filter)->get();
    }

    public function getOrder($id)
    {
        $kq = Order::where('store_id', $id)->get();
        return $kq;
    }

    public function chartRevenue(array $dateBetween)
    {
        $period = CarbonPeriod::create(...$dateBetween);
        $array = [];

        $this->instance = $this->model->select(DB::raw('DATE_FORMAT(updated_at, "%d-%m-%Y") as order_date'), DB::raw('SUM(total) as order_total'))
            ->where('status', OrderStatus::Completed)
            ->whereBetween('updated_at', [$dateBetween[0]->subDay(), $dateBetween[1]->addDay()])
            ->groupBy(DB::raw('DATE_FORMAT(updated_at, "%d-%m-%Y")'))
            ->orderBy(DB::raw('DATE_FORMAT(updated_at, "%d-%m-%Y")'))
            ->pluck('order_total', 'order_date')->toArray();

        foreach ($period as $item) {
            $array[] = [
                'order_date' => $item->format('d-m-Y'),
                'order_total' => $this->instance[$item->format('d-m-Y')] ?? 0
            ];
        }
        return collect($array);
    }

    public function getTotalDriverIncome($driverId, $month, $year)
    {
        if($month && $year){
            return Order::where('driver_id', $driverId)
                ->where('status', OrderStatus::Completed)
                ->whereYear('updated_at', $year)
                ->whereMonth('updated_at', $month)
                ->sum(DB::raw('transport_fee - system_revenue'));
        }
        else{
            return Order::where('driver_id', $driverId)
                ->where('status', OrderStatus::Completed)
                ->sum(DB::raw('transport_fee - system_revenue'));
        }

    }


    public function getOrderByMonthAndYear($userId, $month, $year)
    {
        $lastDay = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $startDate = "$year-$month-01";
        $endDate = "$year-$month-$lastDay";

        $filter = [
            'customer_id' => $userId,
            ['created_at', '>=', $startDate],
            ['created_at', '<=', $endDate],
            'status' => OrderStatus::Completed
        ];

        Log::info('Filter array: ', $filter);

        try {
            return $this->getByQueryBuilder($filter);
        } catch (\Exception $e) {
            Log::error('Failed to get orders by month and year: ' . $e->getMessage());
            return null;
        }
    }

}

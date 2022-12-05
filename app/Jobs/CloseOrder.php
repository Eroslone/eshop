<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class CloseOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, $delay)
    {
        $this->order = $order;
        // 设置延迟的时间，delay() 方法的参数代表多少秒之后执行
        $this->delay($delay);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orderInfo=Order::where('id',$this->order->id)->first();
        if($orderInfo['state']!=0){
            return;
        }
        DB::table('orders')->where('id',$this->order->id)->update(['state'=>-1]);
        $son= DB::table('order_sons')->where('order_id',$this->order->id)->get();
        foreach ($son as $key=>$value){
            DB::table('product_attrs')->where('id',$value->size_id)->increment('stock',$value->quantity);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Enum\DeliveryStatus;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductType;
use App\Models\Stock;
use DB;
use Illuminate\Support\Facades\Response;

class BackordersController extends Controller
{
    public function download()
    {
        $backorders = $this->getBackorders();
        $date = date('YmdHis');
        $filename = "downloads/backorders_$date.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('ID', 'Product ID', 'Product Name', 'Quantity', 'Created At', 'Updated At'));
        foreach ($backorders as $backorder) {
            fputcsv($handle, array($backorder->id, $backorder->product_id, $backorder->product_name, $backorder->quantity, $backorder->created_at, $backorder->updated_at));
        }
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, "backorders_$date.csv", $headers);
    }

    private function getBackorders()
    {
        $orderLines = $this->getOrderLines();

        foreach ($orderLines as $orderLine) {
            $productSize = ProductSize::where('size', $orderLine->product_size)->first();
            $stockAmount = Stock::where('product_id', $orderLine->product_id)
                ->where('product_size_id', $productSize->id)
                ->where('product_type_id', $orderLine->product_type_id)
                ->where('amount', '>', 0)
                ->first()->amount ?? 0;

            if ($orderLine->amount > $stockAmount) {
                $productName = Product::find($orderLine->product_id)->name;
                $size = $orderLine->product_size;
                $type = ProductType::where('id', $orderLine->product_type_id)->first()->type;
                $quantity = $orderLine->amount - $stockAmount;
                $backorders[] = (object) [
                    'product_name' => $productName,
                    'product_size' => $size,
                    'product_type' => $type,
                    'quantity' => $quantity,
                ];
            }
        }

        dd($backorders);
        return $backorders ?? [];
    }

    /**
     * Get all order lines that are in processing or awaiting payment status
     * @return OrderLine[]
     */
    private function getOrderLines()
    {
        return OrderLine::select('product_size', 'product_id', OrderLine::raw('SUM(amount) as amount'), 'product_type_id')
            ->leftJoin('product_types as p', 'product_type_id', '=', 'p.id')
            ->join('orders as ord', 'order_id', '=', 'ord.id')
            ->whereIn('ord.status', [DeliveryStatus::Processing, DeliveryStatus::AwaitingPayment])
            ->groupBy('product_size', 'product_id', 'product_type_id')
            ->orderBy('product_id')
            ->get();
    }
}

<?php

namespace App\Http\Controllers;

use App\Enum\DeliveryStatus;
use App\Models\Order;
use App\Models\OrderLine;
use DB;
use Illuminate\Support\Facades\Response;

class BackordersController extends Controller
{
    public function download()
    {
        $this->getOrders();
        $backorders = $this->getFakeBackorders();
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

    private function getOrders()
    {
        //SELECT product_size, o.product_id, SUM(amount) AS amount, product_type_id
        // FROM order_lines o
        // LEFT JOIN product_product_type p
        // ON o.product_id = p.product_id
        // GROUP BY product_size, product_id ORDER BY product_id;
        // make this query in laravel

        $result = DB::table('order_lines as o')
            ->rightJoin('product_product_type as p', 'o.product_id', '=', 'p.product_id')
            ->join('orders as ord', 'o.order_id', '=', 'ord.id')
            ->select('o.product_size', 'o.product_id', DB::raw('SUM(o.amount) as amount'), 'p.product_type_id')
            ->where('ord.status', DeliveryStatus::Processing)
            ->orWhere('ord.status', DeliveryStatus::AwaitingPayment)
            ->groupBy('o.product_size', 'o.product_id', 'p.product_type_id')
            ->orderBy('o.product_id')
            ->get();
        dd($result);
    }

    private function getFakeBackorders()
    {
        $backorders = array();
        for ($i = 0; $i < 10; $i++) {
            $backorder = new \stdClass();
            $backorder->id = $i;
            $backorder->product_id = $i;
            $backorder->product_name = "Product " . $i;
            $backorder->quantity = $i;
            $backorder->created_at = date('Y-m-d H:i:s');
            $backorder->updated_at = date('Y-m-d H:i:s');
            array_push($backorders, $backorder);
        }
        return $backorders;
    }
}

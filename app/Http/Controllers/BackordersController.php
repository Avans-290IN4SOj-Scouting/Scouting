<?php

namespace App\Http\Controllers;

use App\Enum\DeliveryStatus;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductType;
use App\Models\Stock;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class BackordersController extends Controller
{
    public function download(Request $request)
    {
        $request->session()->put('url.intended', URL::previous());
        $backorders = $this->getBackorders();

        if (empty($backorders)) {
            return redirect()->route(session('url.intended'))->with('info', __('orders/backorders.no_backorders'));
        }

        try {
            $filename = $this->generateCsv($backorders);
        } catch (\Exception) {
            return redirect()->route(session('url.intended'))->with('error', __('orders/backorders.error'));
        }

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, basename($filename), $headers);
    }

    /**
     * Generate a CSV file with all backorders
     *
     * @param $backorders
     * @return string
     * @throws \Exception
     */
    private function generateCsv($backorders)
    {
        $date = date('YmdHis');
        $filename = "downloads/${date}_backorders.csv";
        $handle = fopen($filename, 'w+');

        if ($handle === false) {
            throw new \Exception('Unable to open file for writing');
        }

        fputcsv($handle, array(__('orders/backorders.product_name'), __('orders/backorders.product_size'), __('orders/backorders.product_type'), __('orders/backorders.quantity')));

        foreach ($backorders as $backorder) {
            fputcsv($handle, array($backorder->product_name, $backorder->product_size, $backorder->product_type, $backorder->quantity));
        }

        fclose($handle);

        return $filename;
    }

    /**
     * Get all backorders
     * @return array
     */
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
                $backorders[] = (object)[
                    'product_name' => $productName,
                    'product_size' => $size,
                    'product_type' => $type,
                    'quantity' => $quantity,
                ];
            }
        }

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

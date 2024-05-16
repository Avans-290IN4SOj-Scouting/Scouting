<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

class BackordersController extends Controller
{
    public function download() {
        $backorders = $this->getFakeBackorders();
        $filename = "backorders.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('ID', 'Product ID', 'Product Name', 'Quantity', 'Created At', 'Updated At'));
        foreach ($backorders as $backorder) {
            fputcsv($handle, array($backorder->id, $backorder->product_id, $backorder->product_name, $backorder->quantity, $backorder->created_at, $backorder->updated_at));
        }
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, 'backorders.csv', $headers);
    }

    private function getFakeBackorders() {
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

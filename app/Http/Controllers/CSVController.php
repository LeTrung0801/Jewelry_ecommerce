<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

use DB;
use App\Http\Components\Util;

use App\Models\Product;


class CSVController extends Controller
{
    public function exportCsv($header, $query, $fileName, $notUsedChunk = null)
    {
        // dd('abc');
    	$response = new StreamedResponse(function() use ($header, $query, $fileName, $notUsedChunk){
            // Open output stream
            $handle = fopen('php://output', 'w');
            //change charset
            $header = Util::changeCharset($header);
            // Add CSV headers
            fputcsv($handle, $header);

            if(empty($notUsedChunk))
            {
                // Get data
                $query->chunk(500, function($data) use($handle) {
    		        foreach ($data as $item) {
    		        	$item = $item->toArray();
    		        	//change charset
    		        	$row = [];
                        foreach ($item as $key => $value) {
                            array_push($row, $value);
                        }
                        $row = Util::changeCharset($row);
    		            // Add a new row with data
    		            fputcsv($handle, $row);
    		        }
    		    });
            }
            else
            {
                $query = array_map(function ($value) {
                    return (array)$value;
                }, $query);

                foreach ($query as $item) {
                    //change charset
                    $row = [];
                    foreach ($item as $key => $value) {
                        array_push($row, $value);
                    }
                    $row = Util::changeCharset($row);
                    // Add a new row with data
                    fputcsv($handle, $row);
                }
            }
            // Close the output stream
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' .$fileName. '.csv"',
        ]);

        return $response;
    }

    public function exportProduct(Request $request){
    //     $fileName = 'Product_' . date('Ymd');
    //     $header = [
    //         'Product Id',
    //         'Product Name',
    //         'Product Price',
    //         'Product Price Sale',
    //         'Product Quantity',
    //     ];

    //     $query = Product::select(
    //         'pro_id',
    //         'pro_name',
    //         'pro_price',
    //         'pro_price_sale',
    //         'pro_qty',
    //     );
    //     $notUsedChunk = true;

    //     return $this->exportCsv($header, $query, $fileName, $notUsedChunk);
        $search = $request->input('keyword');
        $data = Product::orderby('pro_id','asc')
            ->where('pro_name','like','%'.$search.'%')
            ->orwhere('pro_id',$search)
            ->get();

        if(count($data)){
            $delimiter = ',';
            $filename = "Product_" . date('d-m-Y') . ".csv";

            $f = fopen('php://memory','w');
            $data_array = array('Product Id',
                    'Product Name',
                    'Product Price',
                    'Product Price Sale',
                    'Product Quantity',);
            fputcsv($f,$data_array,$delimiter);

            foreach($data as $data_item){
                // $status = ($data_item->status == 1) ? 'Còn Hàng' : 'Hết Hàng';
            $line_data = array(
                $data_item->pro_id,
                $data_item->pro_name,
                $data_item->pro_price,
                $data_item->pro_price_sale,
                $data_item->pro_qty,
            );
            fputcsv($f,$line_data,$delimiter);
            }

            fseek($f,0);

            header('Content-Type: text/csv'); 
            header('Content-Disposition: attachment; filename="' . $filename . '";'); 

            fpassthru($f);
        }
        else{
            Session::flash('error', 'Không thành công');
            return redirect()->back();
        }
    }
}

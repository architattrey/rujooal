<?php

namespace App\Imports;

use App\models\Products;
use Maatwebsite\Excel\Concerns\ToModel;

class InvoiceImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Products([
            'cat_id'=>(isset($row[0]) && !empty($row[0]))? $row[0]:" ",
            'brand_id'=>(isset($row[1]) && !empty($row[1]))? $row[1]:" ",
            'products'=>(isset($row[2]) && !empty($row[2]))? $row[2]:" ",
            'mrp'=>(isset($row[3]) && !empty($row[3]))? $row[3]:" ",
            'big_basket_mrp'=>(isset($row[4]) && !empty($row[4]))? $row[4]:" ",
            'rujooal_price'=>(isset($row[5]) && !empty($row[5]))? $row[5]:" ",
            'weight'=>(isset($row[6]) && !empty($row[6]))? $row[6]:" ",
            'unit'=>(isset($row[7]) && !empty($row[7]))? $row[7]:" ",
            'product_image'=>(isset($row[8]) && !empty($row[8]))? $row[8]:" ",
            'description'=>(isset($row[9]) && !empty($row[9]))? $row[9]:" ",
            'stock'=>(isset($row[10]) && !empty($row[10]))? $row[10]:" ",
            'delete_status'=>'1',
            'created_at'=> date('Y-m-d'),
        ]);
    }
}

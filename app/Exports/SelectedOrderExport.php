<?php

namespace App\Exports;

use App\Model\Order;
use App\Model\Product;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Psy\Util\Str;


class SelectedOrderExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	use Exportable;

	protected $orders;

	public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $orders = Order::whereIn('id', $this->orders)->get();
        $i =1;
        foreach ($orders as $order) {
            $priceTotal = 0;
            $product_names = [];
            $product_prices = [];
            $product_qtys = [];
            $total_prices = [];


            if(request()->status== "unpack") {

                foreach ($order->orderProduct as $product){
                    $product_name =  wordwrap($product->products->name, 50, "\n");
                    if(isset($product->products->users->vendorDetails)){
                        $vendor_name = $product->products->users->vendorDetails->name;
                        $vendor_address = $product->products->users->vendorDetails->address;
                        $vendor_phone = $product->products->users->vendorDetails->primary_phone;
                    }else{
                        if(isset($product->products->users)){
                            
                        $vendor_name = $product->products->users->first_name .' '.$product->products->users->last_name;
                        $vendor_address = "               ";
                        $vendor_phone = $product->products->users->phone?$product->products->users->phone: "               ";
                        }else{
                            $vendor_name = "               ";
                        $vendor_address = "               ";
                        $vendor_phone = "               ";
                        }
                    }

                    $product_qty = $product->qty;

                }



                $columns[] = array(
                    'S No' => $i,
                    'Product' => $product_name,
                    'Qty' => $product_qty,
                    'V.Name' => $vendor_name,
                    'V.Address' => $vendor_address,
                    'V.Contact' => $vendor_phone,


                );





            }else{
                foreach ($order->products as $key => $product) {
//                dd($product);
                    $product_names[] = wordwrap($product->name, 50, "\n");
                    $product_prices[] = number_format($product->pivot->price);
                    $product_qtys[] = $product->pivot->qty;
                    $total_prices[] = number_format($product->pivot->qty * $product->pivot->price);

                    $actualPrice = $product->pivot->qty * $product->pivot->price;
                    $dis = $product->pivot->discount;
                    $priceTotal += ($actualPrice - $dis);
                }

                if ($order->shipping_amount) {
                    $priceTotal += $order->shipping_amount;

                }

                $priceTotal = number_format($priceTotal);

                $columns[] = array(
                    'S No' => $i,
                    'Order No' => $order->code,
                    'Name' => $order->shipping_address->first_name . ' ' . $order->shipping_address->last_name,
                    'Address' => $order->shipping_address->area ."\n ". $order->shipping_address->district . ', ' . $order->shipping_address->zone,
                    'Contact' => $order->shipping_address->phone ? $order->shipping_address->mobile . ', ' . $order->shipping_address->phone : $order->shipping_address->mobile,
                    'Product' => implode("\n\n", $product_names),
                    'Qty' => implode("\n\n", $product_qtys),
                    'price' => implode("\n\n", $product_prices),
                    'Total Price' => implode("\n\n", $total_prices),
                    'shipping_amount'=> $order->shipping_amount,
                    'Final Price' => $priceTotal,
                    'Payment Type' => $order->payment?$order->payment->name:"COD",
                    'Remarks' => "               ",
                );
            }



            $i++;

        }


        return collect($columns);
    }

    public function headings(): array
    {
        if(request()->status == "unpack") {
            return [
                'S No',
                'Product',
                'Qty',
                'V.Name',
                'V.Address',
                'V.Contact',
                'Remarks',
            ];
        }else{
            return [
                'S No',
                'Order No',
                'Name',
                'Address',
                'Contact',
                'Product',
                'Qty',
                'Price',
                'Total Price',
                'shipping_amount',
                'Final Price',
                'Payment Type',
                'Remarks',
            ];
        }

    }

    public function registerEvents(): array
    {
    	$styleArray = [
    		'font' => [
    			'bold' => true
    		],


    	];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($styleArray) {
                $event->sheet->getStyle('A1:P1')->applyFromArray($styleArray);
                $event->sheet->getStyle('D1:D100')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('F1:F100')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('G1:G100')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('H1:H100')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('I1:I100')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('B1:B100')->getAlignment()->setWrapText(true);
//                $event->sheet->getStyle('E1:E100')->getD()->setWrapText(true);


            }
        ];
    }
}

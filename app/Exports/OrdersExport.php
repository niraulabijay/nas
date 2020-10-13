<?php

namespace App\Exports;

use App\Model\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrdersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function collection()
    {
        switch ($this->status) {
            case 'pending':
                $orders = Order::where('order_status_id', 1)->orderBy('id', 'desc')->get();
                break;
            case 'approved':
                $orders = Order::where('order_status_id', 2)->orderBy('id', 'desc')->get();
                break;
            case 'received':
                $orders = Order::where('order_status_id', 3)->orderBy('id', 'desc')->get();
                break;
            case 'delivered':
                $orders = Order::where('order_status_id', 4)->orderBy('id', 'desc')->get();
                break;
            case 'cancelled':
                $orders = Order::where('order_status_id', 5)->orderBy('id', 'desc')->get();
                break;
            case 'review':
                $orders = Order::where('order_status_id', 6)->orderBy('id', 'desc')->get();
                break;
            case 'dispatched':
                $orders = Order::where('order_status_id', 7)->orderBy('id', 'desc')->get();
                break;
            case 'completed':
                $orders = Order::where('order_status_id', 8)->orderBy('id', 'desc')->get();
                break;
            case 'pack':
                $orders = Order::where('order_status_id', 10)->orderBy('id', 'desc')->get();
                break;
            case 'unpack':
                $orders = Order::where('order_status_id', 11)->orderBy('id', 'desc')->get();
                break;
            case 'all':
                $orders = Order::orderBy('id', 'desc')->get();
                break;
        }

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
                    'Order Date' => $order->order_date,
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
                'Order Date',
                'Remarks',
            ];
        }
    }

    public function registerEvents(): array
    {
    	$styleArray = [
    		'font' => [
    			'bold' => true
    		]
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

            }
        ];
    }
}

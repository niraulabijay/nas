<?php

namespace App\Jobs;

use App\Model\NotifyInstock;
use App\Model\Product;
use App\Notifications\StockNotify as Notify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class StockNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notify_emails = NotifyInstock::where('product_id', $this->product->id)->get();
        if (isset($notify_emails) && $notify_emails->isNotEmpty()) {
            Notification::send($notify_emails, new Notify($this->product));
        }
    }
}

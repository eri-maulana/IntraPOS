<?php

namespace App\Observers;

use App\Models\IncomingProduct;
use App\Models\Product;

class IncomingProductObserver
{
    /**
     * Handle the IncomingProduct "created" event.
     */
    public function created(IncomingProduct $incomingProduct)
    {
        Product::find($incomingProduct->product_id)?->increment('stock', $incomingProduct->quantity);
    }


    /**
     * Handle the IncomingProduct "updated" event.
     */
    public function updated(IncomingProduct $incomingProduct): void
    {
        if ($incomingProduct->isDirty('quantity')) {
            $originalQty = $incomingProduct->getOriginal('quantity');
            $selisih = $incomingProduct->quantity - $originalQty;

            Product::find($incomingProduct->product_id)?->increment('stock', $selisih);
        }

        if ($incomingProduct->isDirty('product_id')) {
            // Jika product_id diganti, kita harus kurangi dari produk lama & tambah ke produk baru
            $oldProductId = $incomingProduct->getOriginal('product_id');
            $newProductId = $incomingProduct->product_id;
            $quantity = $incomingProduct->quantity;

            Product::find($oldProductId)?->decrement('stock', $quantity);
            Product::find($newProductId)?->increment('stock', $quantity);
        }
    }

    /**
     * Handle the IncomingProduct "deleted" event.
     */
    public function deleted(IncomingProduct $incomingProduct): void
    {
        Product::find($incomingProduct->product_id)?->decrement('stock', $incomingProduct->quantity);
    }

    /**
     * Handle the IncomingProduct "restored" event.
     */
    public function restored(IncomingProduct $incomingProduct): void
    {
        //
    }

    /**
     * Handle the IncomingProduct "force deleted" event.
     */
    public function forceDeleted(IncomingProduct $incomingProduct): void
    {
        //
    }
}

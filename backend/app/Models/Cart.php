<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['customer_id', 'address_id', 'tax_rate', 'total_price'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'cart_item')
                    ->withPivot('quantity', 'price');
    }

    public function calculateTotal()
    {
        $subtotal = $this->items->sum(function($item) {
            return $item->pivot->quantity * $item->pivot->price;
        });

        $tax = $subtotal * ($this->tax_rate / 100);
        $this->total_price = $subtotal + $tax;

        return $this->total_price;
    }
}

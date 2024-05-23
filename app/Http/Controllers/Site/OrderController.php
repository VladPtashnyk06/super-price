<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentMethod;
use App\Models\User;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('site.orders.all-my-orders', compact('orders'));
    }

    public function create()
    {
        $cartItems = \Cart::getContent()->sortBy('id');

        $totalPrice = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->quantity * $item->price);
        }, 0);

        $totalDiscountPrice = $totalPrice;
        $discount = 0;

        if(session()->get('currency') == 'USD') {
            $currencyRateUsd = session()->get('currency_rate_usd');

            if ($totalPrice > (2500 / $currencyRateUsd) && $totalPrice <= (5000 / $currencyRateUsd)) {
                $discount = $totalPrice * 0.10;
                $totalDiscountPrice -= $discount;
            }

            $freeShipping = $totalPrice > (1000 / $currencyRateUsd) && $totalPrice < (2500 / $currencyRateUsd);
            $minimumAmount = 500 / $currencyRateUsd;
            $belowMinimumAmount = $totalPrice < $minimumAmount;
        } elseif(session()->get('currency') == 'EUR') {
            $currencyRateEUR = session()->get('currency_rate_eur');

            if ($totalPrice > (2500 / $currencyRateEUR) && $totalPrice <= (5000 / $currencyRateEUR)) {
                $discount = $totalPrice * 0.10;
                $totalDiscountPrice -= $discount;
            }

            $freeShipping = $totalPrice > (1000 / $currencyRateEUR) && $totalPrice < (2500 / $currencyRateEUR);
            $minimumAmount = 500 / $currencyRateEUR;
            $belowMinimumAmount = $totalPrice < $minimumAmount;
        } else {
            if ($totalPrice > 2500 && $totalPrice <= 5000) {
                $discount = $totalPrice * 0.10;
                $totalDiscountPrice -= $discount;
            }

            $freeShipping = $totalPrice > 1000 && $totalPrice < 2500;
            $minimumAmount = 500;
            $belowMinimumAmount = $totalPrice < $minimumAmount;
        }

        $paymentMethods = PaymentMethod::all();

        return view('site.orders.create', compact('cartItems', 'totalPrice', 'totalDiscountPrice', 'discount', 'freeShipping', 'belowMinimumAmount', 'minimumAmount', 'paymentMethods'));
    }

    public function store(OrderRequest $request)
    {
        if ($request->validated('user_phone')) {
            $falsePhone = $request->validated('user_phone');
            $normalizedPhone = preg_replace('/\D/', '', $falsePhone);
            if (substr($normalizedPhone, 0, 1) === '0') {
                $phone = '+38' . $normalizedPhone;
            } else {
                $phone = '+380' . $normalizedPhone;
            }
        }
        if ($request->post('registration') == 'on') {
            if ($request->validated('password') == $request->validated('password_confirmation')) {
                $newUser = User::create([
                    'phone' => $phone,
                    'email' => $request->validated('user_email') ? $request->validated('user_email') : null,
                    'name' => $request->validated('user_name'),
                    'last_name' => $request->validated('user_last_name'),
                    'password' => \Hash::make($request->validated('password')),
                ]);
            }
        }
        if (isset($newUser)) {
            $newOrder = Order::create([
                'user_id' => $newUser->id,
                'order_status_id' => 1,
                'payment_method_id' => $request->validated('payment_method_id'),
                'cost_delivery' => $request->validated('cost_delivery'),
                'total_price' => $request->validated('total_price'),
                'currency' => $request->validated('currency'),
                'comment' => $request->validated('comment')
            ]);
        } else {
            $newOrder = Order::create([
                'user_id' => !empty($request->validated('user_id')) ? $request->validated('user_id') : null,
                'order_status_id' => 1,
                'user_name' => !empty($request->validated('user_id')) ? null : $request->validated('user_name'),
                'user_last_name' => !empty($request->validated('user_id')) ? null : $request->validated('user_last_name'),
                'user_phone' => !empty($request->validated('user_id')) ? null : $phone,
                'user_email' => !empty($request->validated('user_id')) ? null : ($request->validated('user_email') ? $request->validated('user_email') : null),
                'payment_method_id' => $request->validated('payment_method_id'),
                'cost_delivery' => $request->validated('cost_delivery'),
                'total_price' => $request->validated('total_price'),
                'currency' => $request->validated('currency'),
                'comment' => $request->validated('comment')
            ]);
        }
        if (isset($newOrder)) {
            $cartItems = \Cart::getContent()->sortBy('id');
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $item->attributes->product_id,
                    'color' => $item->attributes->color,
                    'size' => $item->attributes->size,
                    'quantity_product' => $item->quantity
                ]);
            }
        }

        return redirect()->route('site.product.index');
    }

    public function oneOrder(Order $order)
    {
        return view('site.orders.one-order', compact('order'));
    }
}

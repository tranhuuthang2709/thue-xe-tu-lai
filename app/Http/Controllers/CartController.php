<?php

namespace App\Http\Controllers;

use App\Http\Requests\Add_carRequest;
use App\Models\Address;
use App\Models\Car;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->get();
        $totalPrice = 0;
        foreach ($carts as $cart) {
            $price = $cart->car->discounted_price ? $cart->car->discounted_price : $cart->car->price;
            $carPrice = $price * $cart->rental_days;
            if ($cart->pickup_type === 'Giao xe tận nơi') {
                $carPrice += 100000;
            }
            $totalPrice += $carPrice;
        }

        return view('user.cart', compact('carts', 'totalPrice'));
    }

    public function add(Car $car, Add_carRequest $request)
    {
        $cart_exist = Cart::where('car_id', $car->id)
            ->where('user_id', Auth::id())
            ->first();

        $pickup_type = $request->pickup_type;
        $rental_days = $request->rental_days;
        $pickupAddress = null;
        $returnAddress = null;

        if ($cart_exist) {
            $pickupAddress = Address::updateOrCreate(
                ['id' => $cart_exist->pickup_address_id],
                [
                    'street' => $request->pickup_street,
                    'province' => $request->pickup_province,
                    'district' => $request->pickup_district,
                    'ward' => $request->pickup_ward,
                    'pickup_time' => $request->pickup_time,
                ]
            );
            $returnAddress = Address::updateOrCreate(
                ['id' => $cart_exist->return_address_id],
                [
                    'street' => $request->return_street,
                    'province' => $request->return_province,
                    'district' => $request->return_district,
                    'ward' => $request->return_ward,
                    'return_time' => $request->return_time,
                ]
            );
            $cart_exist->update([
                'pickup_address_id' => $pickupAddress->id,
                'return_address_id' => $returnAddress->id,
                'pickup_type' => $pickup_type,
                'rental_days' => $rental_days
            ]);

            return redirect()->route('cart.index')->with('success', 'Giỏ hàng của bạn đã được cập nhật!');
        } else {
            $pickupAddress = Address::create([
                'street' => $request->pickup_street,
                'province' => $request->pickup_province,
                'district' => $request->pickup_district,
                'ward' => $request->pickup_ward,
                'pickup_time' => $request->pickup_time,
            ]);

            $returnAddress = Address::create([
                'street' => $request->return_street,
                'province' => $request->return_province,
                'district' => $request->return_district,
                'ward' => $request->return_ward,
                'return_time' => $request->return_time,
            ]);

            Cart::create([
                'car_id' => $car->id,
                'user_id' => Auth::id(),
                'pickup_address_id' => $pickupAddress->id,
                'return_address_id' => $returnAddress->id,
                'pickup_type' => $pickup_type,
                'rental_days' => $rental_days
            ]);

            return redirect()->route('cart.index')->with('success', 'Xe đã được thêm vào giỏ hàng!');
        }
    }


    public function edit($id)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.cart_edit', compact('cart'));
    }
    public function update(Request $request, $id)
    {
        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);
        $pickupAddress = null;
        $returnAddress = null;
        $rental_days = $request->rental_days;

        $pickupAddress = Address::updateOrCreate(
            ['id' => $cart->pickup_address_id],
            [
                'street' => $request->pickup_street,
                'province' => $request->pickup_province,
                'district' => $request->pickup_district,
                'ward' => $request->pickup_ward,
                'pickup_time' => $request->pickup_time,
            ]
        );

        $returnAddress = Address::updateOrCreate(
            ['id' => $cart->return_address_id],
            [
                'street' => $request->return_street,
                'province' => $request->return_province,
                'district' => $request->return_district,
                'ward' => $request->return_ward,
                'return_time' => $request->return_time1,
            ]
        );


        $cart->update([
            'pickup_address_id' => $pickupAddress->id,
            'return_address_id' => $returnAddress->id,
            'pickup_type' => $request->pickup_type,
            'rental_days' => $rental_days,
        ]);

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng của bạn đã được cập nhật!');
    }



    public function delete($id)
    {
        $cart = Cart::find($id);
        if ($cart) {
            if ($cart->pickup_address_id && Address::where('id', $cart->pickup_address_id)->exists()) {
                Address::find($cart->pickup_address_id)->delete();
            }
            if ($cart->return_address_id && Address::where('id', $cart->return_address_id)->exists()) {
                Address::find($cart->return_address_id)->delete();
            }
            $cart->delete();
        }
        return redirect()->route('cart.index')->with('success', 'Xóa sản phẩm ra khỏi giỏ hàng thành công');
    }


    public function clear()
    {
        $user_carts = Cart::where('user_id', Auth::id())->get();
        foreach ($user_carts as $cart) {
            if ($cart->pickup_address_id && Address::where('id', $cart->pickup_address_id)->exists()) {
                Address::find($cart->pickup_address_id)->delete();
            }
            if ($cart->return_address_id && Address::where('id', $cart->return_address_id)->exists()) {
                Address::find($cart->return_address_id)->delete();
            }
            $cart->delete();
        }
        return redirect()->back()->with('success', 'Đã xóa tất cả giỏ hàng');
    }
}

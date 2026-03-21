<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('course')
            ->where('user_id', Auth::id())
            ->get();

        return view('home.cart.index', compact('cartItems'));
    }

    public function add($courseId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $exists = Cart::where('user_id', Auth::id())->where('course_id', $courseId)->exists();

        if (!$exists) {
            Cart::create([
                'user_id' => $user->id,
                'course_id' => $courseId,
            ]);
        }

        return redirect()->back()->with('success', 'Added to cart successfully');
    }

    // remove single cart
    public function remove($courseId)
    {
        Cart::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->delete();

        return redirect()->back()->with('success', 'Course removed from cart!');
    }

    // remove all cart
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Cart cleared successfully');
    }
}

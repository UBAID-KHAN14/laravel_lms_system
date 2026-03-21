<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $query = Wishlist::with(['course' => function ($q) {
            $q->withCount([
                'enrollments',
                'reviews'
            ]);
        }])->where('user_id', Auth::id());



        if ($request->search) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $wishlists = $query->paginate(10);

        $wishlistIds  = Auth::check() ? Wishlist::where('user_id', Auth::id())->pluck('course_id')->toArray() : [];
        $cartIds = Auth::check() ? Cart::where('user_id', Auth::id())->pluck('course_id')->toArray() : [];

        // IMPORTANT
        if ($request->ajax()) {
            return view('home.wishlist.partials.wishlist_items',  compact('wishlists', 'wishlistIds', 'cartIds'))->render();
        }


        return view('home.wishlist.index', compact('wishlists', 'wishlistIds', 'cartIds'))->render();
    }

    public function add($courseId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please Login.');
        }

        $exists = Wishlist::where('user_id', Auth::id())->where('course_id', $courseId)->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => Auth::id(),
                'course_id' => $courseId,
            ]);
        }

        return redirect()->back()->with('success', 'Add to Wishlist.');
    }


    public function remove($courseId)
    {
        Wishlist::where('user_id', Auth::id())->where('course_id', $courseId)->delete();
        return redirect()->back()->with('success', 'Remove From Wishlist.');
    }
}
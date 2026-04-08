<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Mail\ContactEmailMail;
use App\Models\Cart;
use App\Models\Category;
use App\Models\CourseView;
use App\Models\PrivacyPolicy;
use App\Models\Slider;
use App\Models\SocialLink;
use App\Models\Student\Course\CourseReview;
use App\Models\SubCategory;
use App\Models\Teacher\Course\Course;
use App\Models\TermAndPrivacy;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['category', 'subCategory', 'user'])
            ->withCount([
                'reviews',
                'enrollments',
                'enrollments as is_enrolled' => function ($q) {
                    if (Auth::check()) {
                        $q->where('user_id', Auth::id());
                    }
                }
            ])
            ->where('status', 'published');



        $courses = $query->paginate(20);
        $categories = Category::all();
        $subcategories = SubCategory::all();

        $wishlistIds  = Auth::check() ? Wishlist::where('user_id', Auth::id())->pluck('course_id')->toArray() : [];
        $cartIds = Auth::check() ? Cart::where('user_id', Auth::id())->pluck('course_id')->toArray() : [];
        return view('home.index', compact('courses', 'categories', 'subcategories', 'wishlistIds', 'cartIds'));
    }

    public function about()
    {
        return view('home.about_us');
    }
    public function contact()
    {
        return view('home.contact_us');
    }
    // send email
    public function send_email(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:255',
        ]);

        try {
            Mail::to('ubaidkhanweb2004@gmail.com')->send(new ContactEmailMail($data));
            return back()->with('success', 'Email sent successfully.',);
        } catch (\Throwable $e) {
            Log::error('Contact mail failed: ' . $e->getMessage());
            return back()->with('error', 'Unable to send email. Check logs for details.');
        }
    }


    // PRIVACY POLICY
    public function privacy_policy()
    {
        $privacies = TermAndPrivacy::where('status', true)->where('type', 'privacies')->orderBy('sort_order')->get();
        return view('home.privacy_policy', compact('privacies'));
    }
    // TERMS CONDITION
    public function terms_condition()
    {
        $terms = TermAndPrivacy::where('status', true)->where('type', 'terms')->orderBy('sort_order')->get();
        return view('home.terms_condition', compact('terms'));
    }


    public function course_index(Request $request)
    {
        $query = Course::with(['category', 'subCategory', 'user'])
            ->withCount([
                'reviews',
                'enrollments',
                'enrollments as is_enrolled' => function ($q) {
                    if (Auth::check()) {
                        $q->where('user_id', Auth::id());
                    }
                }
            ])
            ->where('status', 'published');

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Subcategory filter
        if ($request->has('subcategory') && $request->subcategory) {
            $query->where('sub_category_id', $request->subcategory);
        }


        // Level filter
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }


        // Price filter
        if ($request->filled('price')) {
            if ($request->price === 'free') {
                $query->whereDoesntHave('pricing');
            } elseif ($request->price === 'paid') {
                $query->whereHas('pricing', function ($q) {
                    $q->where('price', '>', 0);
                });
            }
        }

        // Sorting
        switch ($request->sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;

            case 'popular':
                $query->withCount('enrollments')
                    ->orderBy('enrollments_count', 'desc');
                break;

            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $courses = $query->paginate(20);
        $categories = Category::all();
        $subcategories = SubCategory::all();

        $wishlistIds  = Auth::check() ? Wishlist::where('user_id', Auth::id())->pluck('course_id')->toArray() : [];
        $cartIds = Auth::check() ? Cart::where('user_id', Auth::id())->pluck('course_id')->toArray() : [];

        return view('home.courses.all_courses', compact('courses', 'categories', 'subcategories', 'wishlistIds', 'cartIds'));
    }

    public function getSubcategoriesByCategory(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->category_id)->get();
        return response()->json($subcategories);
    }



    public function course_show($slug)
    {
        $course = Course::with([
            'category',
            'subCategory',
            'user',
            'sections' => function ($query) {
                $query->orderBy('order_number');
            },
            'sections.lectures',
            'faqs',
            'comments' => function ($query) {
                $query->whereNull('parent_id')
                    ->with('replies.user');
            },
            'comments.user',
            'myEnrollment',
        ])
            ->withCount([
                // check if current user enrolled
                'enrollments as is_enrolled' => function ($q) {
                    if (Auth::check()) {
                        $q->where('user_id', Auth::id());
                    }
                }
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Count Only Unique Views
        $alreadyViewed = CourseView::where('course_id', $course->id)
            ->where(function ($query) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('ip_address', request()->ip());
                }
            })
            ->exists();

        if (!$alreadyViewed) {

            // Store detailed view
            CourseView::create([
                'course_id' => $course->id,
                'user_id'   => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Increase fast counter (IMPORTANT)
            $course->increment('views');
        }

        // Rating stats
        $ratings = CourseReview::where('course_id', $course->id)
            ->selectRaw('rating, COUNT(*) as total')
            ->groupBy('rating')
            ->pluck('total', 'rating');

        $userReview = Auth::check()
            ? CourseReview::where('course_id', $course->id)
            ->where('user_id', Auth::id())
            ->first()
            : null;

        // Get similar courses
        $similarCourses = Course::where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->where('status', 'published')
            ->limit(4)
            ->get();

        // Get other courses by instructor
        $otherCourses = Course::where('teacher_id', $course->teacher_id)
            ->where('id', '!=', $course->id)
            ->where('status', 'published')
            ->limit(3)
            ->get();




        return view('home.courses.course_show', compact(
            'course',
            'similarCourses',
            'otherCourses',
            'ratings',
            'userReview',

        ));
    }
}

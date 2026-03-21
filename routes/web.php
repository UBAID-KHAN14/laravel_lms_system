<?php

use App\Http\Controllers\ActivationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Category\SubCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\TermAndPrivacyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Home\CartController;
// Home Controller

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\WishlistController;
// Student Controllers
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\Course\EnrollmentController;
use App\Http\Controllers\Student\Course\ReviewController;
use App\Http\Controllers\Student\Course\CommentController;

// Teacher Controllers
use App\Http\Controllers\Teacher\CourseController;
use App\Http\Controllers\Teacher\CourseFAQController;
use App\Http\Controllers\Teacher\CourseLectureController;
use App\Http\Controllers\Teacher\CourseLectureMaterialController;
use App\Http\Controllers\Teacher\CoursePriceController;
use App\Http\Controllers\Teacher\CourseSectionController;
use App\Http\Controllers\Teacher\DasboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\Course\EnrollmentController as TeacherEnrollmentController;

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Any Role)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/change-password/update', [ProfileController::class, 'password_update'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // USERS
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    // direct change in the table
    Route::post('/users/{id}/update', [UserController::class, 'update'])->name('admin.users.update');
    // Edit page
    Route::get('/users/edit{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/update{id}', [UserController::class, 'update_user'])->name('admin.users.update_user');
    Route::delete('/users/{id}/delete', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // PRIVACY POLICY 
    Route::get('/term-privacy', [TermAndPrivacyController::class, 'index'])->name('admin.term_privacy.index');
    Route::get('/term-privacy/create', [TermAndPrivacyController::class, 'create'])->name('admin.term_privacy.create');
    Route::post('/term-privacy/store', [TermAndPrivacyController::class, 'store'])->name('admin.term_privacy.store');
    Route::get('/term-privacy/edit/{id}', [TermAndPrivacyController::class, 'edit'])->name('admin.term_privacy.edit');
    Route::put('/term-privacy/update/{id}', [TermAndPrivacyController::class, 'update'])->name('admin.term_privacy.update');
    Route::delete('/term-privacy/delete/{id}', [TermAndPrivacyController::class, 'destroy'])->name('admin.term_privacy.destroy');

    // CATEGORIES
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/categories/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    // SUB CATEGORIES
    Route::get('/sub_categories', [SubCategoryController::class, 'index'])->name('admin.sub_categories.index');
    Route::get('/sub_categories/create', [SubCategoryController::class, 'create'])->name('admin.sub_categories.create');
    Route::post('/sub_categories/store', [SubCategoryController::class, 'store'])->name('admin.sub_categories.store');
    Route::get('/sub_categories/edit/{id}', [SubCategoryController::class, 'edit'])->name('admin.sub_categories.edit');
    Route::put('/sub_categories/update/{id}', [SubCategoryController::class, 'update'])->name('admin.sub_categories.update');
    Route::delete('/sub_categories/delete/{id}', [SubCategoryController::class, 'destroy'])->name('admin.sub_categories.destroy');

    // COURSE APPROVALS
    Route::get('/course-approvals', [AdminController::class, 'index'])->name('admin.course_approvals.index');
    Route::get('/course-approvals/{course}', [AdminController::class, 'approve'])->name('admin.course_approvals.approve');
    Route::get('/course-reject/{course}', [AdminController::class, 'reject'])->name('admin.course_approvals.reject');


    // COURSES OVRERVIEW
    Route::get('/courses-overview/{id}', [AdminController::class, 'courses_overview'])->name('admin.courses_overview.index');


    // SHOW THE ENROLL ALL STUDENT
    Route::get('/courses-enroll/all', [AdminController::class, 'course_enroll_all'])->name('admin.courses.enroll_all');
    // UPDATE THE IS_ACTIVE 
    Route::post('/enrollments/{id}/update', [AdminController::class, 'course_enroll_update'])->name('admin.courses.enroll_update');



    // SETTINGS
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('admin.settings.update');

    // SLIDER
    Route::controller(SliderController::class)->group(function () {
        Route::get('/sliders', 'index')->name('admin.sliders.index');
        Route::get('/sliders/create', 'create')->name('admin.sliders.create');
        Route::post('/sliders/store', 'store')->name('admin.sliders.store');
        Route::get('/sliders/edit/{id}', 'edit')->name('admin.sliders.edit');
        Route::put('/sliders/update/{id}', 'update')->name('admin.sliders.update');
        Route::delete('/sliders/delete/{id}', 'destroy')->name('admin.sliders.destroy');
    });

    // SOCIAL LINKS
    Route::controller(SocialLinkController::class)->group(function () {
        Route::get('/social-links', 'index')->name('admin.socialLinks.index');
        Route::get('/social-links/create', 'create')->name('admin.socialLinks.create');
        Route::post('/social-links/store', 'store')->name('admin.socialLinks.store');
        Route::get('/social-links/edit/{id}', 'edit')->name('admin.socialLinks.edit');
        Route::put('/social-links/update/{id}', 'update')->name('admin.socialLinks.update');
        Route::delete('/social-links/delete/{id}', 'destroy')->name('admin.socialLinks.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/
// Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->group(function () {
//     Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');

//     // COURSES
//     Route::get('/courses', [CourseController::class, 'index'])->name('teacher.courses.index');
//     Route::get('/courses/create', [CourseController::class, 'create'])->name('teacher.courses.create');
//     Route::post('/courses/store', [CourseController::class, 'store'])->name('teacher.courses.store');
//     Route::get('/courses/edit/{id}', [CourseController::class, 'edit'])->name('teacher.courses.edit');
//     Route::get('/courses/manage/{id}', [CourseController::class, 'manage_course'])->name('teacher.courses.manage');
//     Route::put('/courses/update/{id}', [CourseController::class, 'update'])->name('teacher.courses.update');
//     Route::delete('/courses/delete/{id}', [CourseController::class, 'destroy'])->name('teacher.courses.destroy');

//     Route::get('/courses/manage/{id}', [CourseController::class, 'manage_course'])
//         ->name('teacher.courses.manage');




//     // COURSE SECTIONS
//     Route::get('/course-section', [CourseSectionController::class, 'index'])->name('teacher.course_sections.index');
//     Route::get('/course-section/create', [CourseSectionController::class, 'create'])->name('teacher.course_sections.create');
//     Route::post('/course-section/store', [CourseSectionController::class, 'store'])->name('teacher.course_sections.store');
//     Route::get('/course-section/edit/{id}', [CourseSectionController::class, 'edit'])->name('teacher.course_sections.edit');
//     Route::put('/course-section/update/{id}', [CourseSectionController::class, 'update'])->name('teacher.course_sections.update');
//     Route::delete('/course-section/delete/{id}', [CourseSectionController::class, 'destroy'])->name('teacher.course_sections.destroy');

//     // COURSE LECTURES
//     Route::get('/course-lectures', [CourseLectureController::class, 'index'])->name('teacher.course_lectures.index');
//     Route::get('/course-lectures/create', [CourseLectureController::class, 'create'])->name('teacher.course_lectures.create');
//     Route::post('/course-lectures/store', [CourseLectureController::class, 'store'])->name('teacher.course_lectures.store');
//     Route::get('/course-lectures/edit/{id}', [CourseLectureController::class, 'edit'])->name('teacher.course_lectures.edit');
//     Route::put('/course-lectures/update/{id}', [CourseLectureController::class, 'update'])->name('teacher.course_lectures.update');
//     Route::delete('/course-lectures/delete/{id}', [CourseLectureController::class, 'destroy'])->name('teacher.course_lectures.destroy');
//     // SUBMIT FOR REVIEW
//     Route::get('/submit-course/{id}', [CourseController::class, 'submit'])->name('teacher.course.submit');

//     // COURSE LECTURE MATERIALS
//     Route::get('/course-lecture-materials', [CourseLectureMaterialController::class, 'index'])->name('teacher.course_lecture_materials.index');
//     Route::get('/course-lecture-materials/create', [CourseLectureMaterialController::class, 'create'])->name('teacher.course_lecture_materials.create');
//     Route::post('/course-lecture-materials/store', [CourseLectureMaterialController::class, 'store'])->name('teacher.course_lecture_materials.store');
//     Route::get('/course-lecture-materials/edit/{id}', [CourseLectureMaterialController::class, 'edit'])->name('teacher.course_lecture_materials.edit');
//     Route::put('/course-lecture-materials/update/{id}', [CourseLectureMaterialController::class, 'update'])->name('teacher.course_lecture_materials.update');
//     Route::delete('/course-lecture-materials/delete/{id}', [CourseLectureMaterialController::class, 'destroy'])->name('teacher.course_lecture_materials.destroy');

//     // COURSE FAQs
//     Route::get('/course-faqs', [CourseFAQController::class, 'index'])->name('teacher.course_faqs.index');
//     Route::get('/course-faqs/create', [CourseFAQController::class, 'create'])->name('teacher.course_faqs.create');
//     Route::post('/course-faqs/store', [CourseFAQController::class, 'store'])->name('teacher.course_faqs.store');
//     Route::get('/course-faqs/edit/{id}', [CourseFAQController::class, 'edit'])->name('teacher.course_faqs.edit');
//     Route::put('/course-faqs/update/{id}', [CourseFAQController::class, 'update'])->name('teacher.course_faqs.update');
//     Route::delete('/course-faqs/delete/{id}', [CourseFAQController::class, 'destroy'])->name('teacher.course_faqs.destroy');
// });

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');

    // COURSES
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses/store', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/manage/{id}', [CourseController::class, 'manage_course'])->name('courses.manage');
    Route::put('/courses/{id}/basic', [CourseController::class, 'updateBasic'])->name('courses.update.basic');
    Route::delete('/courses/delete/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
    // DELTE TEACHER IN BULK
    Route::delete('/courses/bulk-delete', [CourseController::class, 'bulkDelete'])->name('courses.bulkDelete');


    Route::get('/courses/edit/{id}', [CourseController::class, 'edit'])->name('courses.edit');

    // SUBMIT FOR REVIEW
    Route::get('/submit-course/{id}', [CourseController::class, 'submit'])->name('course.submit');

    // Sections and Lectures
    Route::post('/courses/{course}/sections', [CourseSectionController::class, 'store'])->name('courses.sections.store');
    Route::post('/courses/{course}/curriculum/save', [CourseSectionController::class, 'saveCurriculum'])->name('courses.curriculum.save');
    Route::delete('/sections/{section}', [CourseSectionController::class, 'destroy'])->name('sections.destroy');

    // Lectures
    Route::post('/sections/{section}/lectures', [CourseLectureController::class, 'store'])->name('sections.lectures.store');
    Route::delete('/lectures/{lecture}', [CourseLectureController::class, 'destroy'])->name('lectures.destroy');

    // Materials
    Route::post('/lectures/{lecture}/materials', [CourseLectureMaterialController::class, 'store'])->name('lectures.materials.store');
    Route::delete('/materials/{material}', [CourseLectureMaterialController::class, 'destroy'])->name('materials.destroy');

    Route::prefix('teacher/courses/{course}')->group(function () {
        Route::get('/faqs', [CourseFAQController::class, 'index'])->name('courses.faqs');
        Route::post('/faqs', [CourseFAQController::class, 'store'])->name('courses.faqs.store');
        Route::put('/faqs/{faq}', [CourseFAQController::class, 'update'])->name('courses.faqs.update');
        Route::post('/faqs/save', [CourseFAQController::class, 'saveFAQs'])->name('courses.faqs.save');
    });

    Route::delete('/faqs/{faq}', [CourseFAQController::class, 'destroy'])
        ->name('courses.faqs.delete');

    // Pricing
    Route::post('/courses/pricing', [CoursePriceController::class, 'store'])->name('courses.price.store');
    Route::delete('/courses/pricing/{pricing}', [CoursePriceController::class, 'destroy'])->name('courses.price.destroy');

    // PREIVIEW COURSE
    Route::get('/courses/{course}/preview', [CourseController::class, 'preview'])->name('courses.preview');

    // START ENROLLED SECTION
    // MY STUDENT ENROLLED 
    Route::get('/enrollments', [TeacherEnrollmentController::class, 'index'])->name('enrollments.index');
    // MY STUDENT REQUEST PENDING TO APPROVED OR APPROVED TO PENDING    
    Route::post('/enrollments/{id}/update', [TeacherEnrollmentController::class, 'status_update'])->name('enrollments.status_update');

    Route::post('/enrollments/{id}/activation/update', [TeacherEnrollmentController::class, 'activation_update'])->name('enrollments.activation_update');
    // END ENROLLED SECTION
});



/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');

    // DASHBOARD
    // My Course COURSE
    Route::get('/my-course', [StudentDashboardController::class, 'my_courses'])->name('student.my_courses');

    // student enroll course
    Route::post('/enroll', [EnrollmentController::class, 'store'])->name('student.course.enroll');
    // Continue Learning - Show course learning page
    Route::get('/courses/{course}/learn/overview', [EnrollmentController::class, 'learn'])->name('student.courses.learn');

    // REVIEW
    Route::post('/course/{id}/review', [ReviewController::class, 'store'])->name('student.course.review');
    Route::put('/review/{id}', [ReviewController::class, 'update'])->name('student.course.review.update');
    Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->name('student.course.review.delete');

    // COMMENTS
    Route::post('/course/{id}/comment', [CommentController::class, 'store'])->name('student.course.comment');



    // ADD TO WISHLIST
    // search the wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{course}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{course}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    // ADD TO CART
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{course}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{course}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/activate/{token}', [ActivationController::class, 'activate'])->name('activate.account');

Route::post('/resend-activation', [ActivationController::class, 'resend'])->name('resend.activation');










Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home.index');
    Route::get('/about-us', 'about')->name('home.about_us');
    Route::get('/contact-us', 'contact')->name('home.contact_us');
    // send contact us to email
    Route::post('/contact/send', 'send_email')->name('contact.send');

    // ALL COURSES
    // Route::get('/courses-all', 'all_courses')->name('home.courses.all');
    Route::get('/courses', 'course_index')->name('courses.course_index');
    //  view specific course
    Route::get('/courses/{course:slug}', 'course_show')->name('courses.course_show');
    Route::get('/api/subcategories/byCategory',  'getSubcategoriesByCategory')->name('api.subcategories.byCategory');


    //privacy policy
    Route::get('/privacy-policy', 'privacy_policy')->name('home.privacy_policy');
    Route::get('/terms-condition', 'terms_condition')->name('home.terms_condition');

    Route::post('/chatbot/message', [ChatbotController::class, 'message']);
});





require __DIR__ . '/auth.php';


// CUSTOM
Route::get('/login', function () {
    return view('auth.custom-login');
})->name('login');

Route::get('/register', function () {
    return view('auth.custom-register');
})->name('register');

// logout
Route::get('/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');

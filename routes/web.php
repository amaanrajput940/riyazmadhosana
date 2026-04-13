<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController; // ✅ MUST
use App\Http\Controllers\ProductController; // ✅ MUST
use App\Http\Controllers\CartController; // ✅ MUST
use App\Http\Controllers\CheckoutController; // ✅ MUST
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Dashboard\ProductController as DashboardProductController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CategoryController as DashboardCategoryController;
use App\Http\Controllers\Dashboard\DashboardOrderController;

Route::get('/', [HomeController::class, 'index'])->name('kalaam.index');
Route::get('/kalaam', [HomeController::class, 'index'])->name('kalaam.index');

Route::get('/kalaam/{slug}', [HomeController::class, 'show'])->name('kalaam.show');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('default_dashboard');


require __DIR__.'/auth.php';


Route::get('/migrate', function (Request $request) {

    // Security check (optional but recommended)
    if (!app()->environment('local')) {
        abort(403, 'Not allowed');
    }

    $params = [
        '--force' => true // required for some environments
    ];

    // agar ?seed=1 ho
    if ($request->query('seed') == 1) {
        $params['--seed'] = true;
    }

    Artisan::call('migrate:fresh', $params);

    return response()->json([
        'status' => 'Migration completed',
        'seeded' => $request->query('seed') == 1
    ]);
});

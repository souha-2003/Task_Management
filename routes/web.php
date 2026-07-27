<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::get('lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tasks CRUD Routes
    Route::resource('tasks', TaskController::class);
    // Custom route to toggle completed status
    Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

    // Categories CRUD Routes
    Route::resource('categories', CategoriesController::class);
   
});

// Route::get('/test-decrypt', function () {
//     $user = App\Models\User::find(1); 

//     if ($user) {
//         // إذا كان الحقل فارغاً، سنقوم بتحديثه بملاحظة تجريبية لتراها
//         if (is_null($user->secret_note)) {
//             $user->secret_note = 'هذه ملاحظة سرية تجريبية تم تشفيرها تلقائياً!';
//             $user->save();
            
//             // إعادة جلب المودل لضمان قراءة البيانات المحدثة
//             $user = App\Models\User::find(1);
//         }

//         return response()->json([
//             'original_name' => $user->name,
//             'encrypted_in_db' => DB::table('users')->where('id', 1)->value('secret_note'), // القيمة الخام المشفرة في قاعدة البيانات
//             'decrypted_by_laravel' => $user->secret_note // القيمة بعد فك التشفير التلقائي بواسطة لارافيل
//         ], 200, [], JSON_UNESCAPED_UNICODE);
//     }

//     return 'لم يتم العثور على المستخدم رقم 1.';
// });


require __DIR__.'/auth.php';

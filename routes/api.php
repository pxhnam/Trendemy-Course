<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::prefix('courses')->group(function () {
    Route::get('', [CourseController::class, 'list']);
    Route::get('all', [CourseController::class, 'all']);
    Route::get('find/{id}', [CourseController::class, 'show']);
    Route::get('check/{id}', [CourseController::class, 'check']);
    Route::get('randomCoursesNotInCart/{ids}', [CourseController::class, 'getRandomCoursesNotInCart']);
    Route::post('', [CourseController::class, 'store'])->name('store');
    Route::put('/{id}', [CourseController::class, 'update'])->name('update');
    Route::delete('/{id}', [CourseController::class, 'destroy'])->name('destroy');
});

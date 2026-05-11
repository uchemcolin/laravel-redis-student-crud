<?php

use App\Http\Controllers\RedisController;
use App\Http\Controllers\StudentsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/redis', [RedisController::class, 'index']);

/*// These are like doors in your school:
Route::get('/students', [StudentsController::class, 'index'])->name('students.index');        // 📋 See all students
Route::post('/students', [StudentsController::class, 'store'])->name('students.store');        // ➕ Add a student
Route::get('/students/{id}', [StudentsController::class, 'show'])->name('students.show');      // 🔍 See one student
Route::delete('/students/{id}', [StudentsController::class, 'destroy'])->name('students.destroy'); // ❌ Remove student*/

// Main routes
Route::get('/students', [StudentsController::class, 'index'])->name('students.index');
Route::post('/students', [StudentsController::class, 'store'])->name('students.store');
Route::get('/students/{id}', [StudentsController::class, 'show'])->name('students.show');

// EDIT/UPDATE routes (NEW!)
Route::get('/students/{id}/edit', [StudentsController::class, 'edit'])->name('students.edit');
Route::put('/students/{id}', [StudentsController::class, 'update'])->name('students.update');

// DELETE routes
Route::delete('/students/{id}', [StudentsController::class, 'destroy'])->name('students.destroy');

// EXTRA FEATURES (NEW!)
Route::post('/students/{id}/field', [StudentsController::class, 'updateField']); // Quick update
Route::post('/students/{id}/increment/{field}', [StudentsController::class, 'incrementField']); // Add 1
Route::post('/students/{id}/increment', [StudentsController::class, 'incrementByAmount']); // Add amount
Route::delete('/students/{id}/field/{field}', [StudentsController::class, 'deleteField']); // Delete field

// Check database (just for fun!)
Route::get('/check-db', [StudentsController::class, 'checkDatabase']);
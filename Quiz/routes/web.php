<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
Route::get('/', function () {
    return view('welcome');
});

// Quizzes Routes
Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
Route::get('quizzes/{id}', [QuizController::class, 'show'])->name('quizzes.show');
Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');

// Questions Routes
Route::get('/quizzes/{quiz}/questions', [QuestionController::class, 'index'])->name('questions.index');
Route::get('/quizzes/{quiz}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');
Route::get('questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
Route::put('questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
Route::delete('questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');
Route::get('/quizzes/{quiz}/submit', [QuestionController::class, 'submitQuestions'])->name('questions.submit');
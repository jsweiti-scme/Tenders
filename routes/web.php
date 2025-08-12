<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;




Auth::routes(['verify' => true]);


Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', function () {
        return redirect('dashboard');
    });
    Route::get('/home', function () {
        return redirect('dashboard');
    });
    Route::get('/dashboard', 'App\Http\Controllers\HomeController@index')->name('dashboard');
    Route::get('/cities', 'App\Livewire\Cities\CitiesTable@index')->name('Cities.index');
    Route::get('/companies', 'App\Livewire\Companies\CompaniesTable@index')->name('Companies.index');
    Route::get('/questions', 'App\Livewire\Questions\QuestionsTable@index')->name('Questions.index');
    Route::get('/tenders', 'App\Livewire\Tenders\TendersTable@index')->name('Tenders.index');
    Route::get('/committes', 'App\Livewire\Committes\CommittesTable@index')
        ->name('Committes.index');
    Route::get('/TenderApplicants/{id}', 'App\Livewire\TendersApplicants\TendersApplicantsTable@index')->name('TenderApplicants.index');
});

Route::get('/auth/google', 'App\Http\Controllers\Auth\GoogleLoginController@redirectToGoogle');
Route::get('/auth/google/callback', 'App\Http\Controllers\Auth\GoogleLoginController@handleGoogleCallback');
Route::get('/LoginCommitts', 'App\Http\Controllers\Auth\GoogleLoginController@LoginCommitts')->name('LoginCommitts.show');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
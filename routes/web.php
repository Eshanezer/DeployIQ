<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('/home', [HomeController::class, 'index'])->middleware('permitted')->name('home');

Route::get('/logout', [UserController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->group(function () {
    // Generalized Resource Routes
    $entities = [
        'users' => [
            'class' => UserController::class,
            'index' => true,
            'enroll' => true,
            'list' => true,
            'get' => true,
            'delete' => true
        ],
        'usertypes' => [
            'class' => UserTypeController::class,
            'index' => true,
            'enroll' => true,
            'list' => true,
            'get' => true,
            'delete' => true
        ],
        'logs' => [
            'class' => LogController::class,
            'index' => true,
            'predict' => true,
            'more-info' => true
        ]
    ];

    foreach ($entities as $prefix => $values) {
        Route::prefix("/{$prefix}")->name("admin.{$prefix}.")->group(function () use ($values) {

            if ($values['index']) {
                Route::get('/', [$values['class'], 'index'])->middleware('permitted')->name('index');
            }

            if (isset($values['predict']) &&  $values['predict']) {
                Route::get('/predict/{filename}', [$values['class'], 'predict'])->name('predict');
            }

            if (isset($values['more-info']) &&  $values['more-info']) {
                Route::get('/more-info/{filename}', [$values['class'], 'moreinfo'])->name('more-info');
            }

            if (isset($values['enroll']) &&  $values['enroll']) {
                Route::post('/enroll', [$values['class'], 'enroll'])->name('enroll');
            }

            if (isset($values['list']) &&  $values['list']) {
                Route::get('/list', [$values['class'], 'list'])->name('list');
            }

            if (isset($values['get']) &&  $values['get']) {
                Route::get('/get', [$values['class'], 'getOne'])->name('get.one');
            }

            if (isset($values['delete']) &&  $values['delete']) {
                Route::get('/delete', [$values['class'], 'deleteOne'])->name('delete.one');
            }
        });
    }
});

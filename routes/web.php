<?php

use App\Models\Task;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $tasks = Task::all();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'can'   => [
                'createTask' => auth()->user()->can('task_create'),
                'editTask' => auth()->user()->can('task_edit'),
                'destroyTask' => auth()->user()->can('task_destroy'),
            ],
        ]);
    })->name('dashboard');
});

Route::resource('tasks', \App\Http\Controllers\TaskController::class);

<?php

use App\Honeypot\BlockSpam;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('post/create', function () {
        return view('post.create');
    })->name('post.create');

    Route::post('post', function (Request $request) {
        Post::create(
            $request->validate([
                'title' => 'required',
                'body' => 'required|min:3'
            ])
        );
        return 'Published';
    })->middleware( BlockSpam::class)->name('post.store');
});

require __DIR__.'/auth.php';

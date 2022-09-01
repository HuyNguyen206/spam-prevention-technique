<?php

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

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
        if (! $request->has('name')) { // normal/valid user will always send this field name
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Spam detected');
        }

        if ($request->get('name')) { // normal/valid user will always send this field name with empty/null value
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Spam detected');
        }

        $currentTime = microtime(true);
        if ($currentTime - $request->get('time') <=3 ) { // fill data to quick
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Spam detected');
        }

        Post::create(
            $request->validate([
                'title' => 'required',
                'body' => 'required|min:3'
            ])
        );
        return 'Published';
    })->name('post.store');
});

require __DIR__.'/auth.php';

<?php

use App\Survey;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

function updateToken() {

    $token = Str::random(60);

    Auth::user()->forceFill([
        'api_token' => hash('sha256', $token),
    ])->save();

    return $token;
}

Route::group(['middleware' => ['guest']], function () {

    Route::get('/', function () {
        return view('guest');
    })->name('app');
});

/*******************************************************************************/
Auth::routes();                                                              /**/
// To disable registration uncomment this line below and comment line above  /**/
// Auth::routes(['register' => false]);                                      /**/
/*******************************************************************************/

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/new_survey', function () {

        if(Auth::user()->type === "admin") {

            return view('new_survey', [
                'token' => updateToken()
            ]);
        } else {

            return abort(403);
        }
    })->name('new_survey');
    Route::get('/survey/{path}', function ($path) {

        try {
            $survey = Survey::where('slug', '=', $path)->firstOrFail();
            
            return view('survey_detail', [
                'token' => updateToken(),
            ]);

        } catch(ModelNotFoundException $e) {

            return abort(404);
        }
    });
});

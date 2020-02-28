<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*****************************************************************************************/
/*                                  SURVEY API                                           */
/**/ Route::middleware('auth:api')->get('/getSurveyList', 'SurveyController@index');   /**/
/**/ Route::middleware('auth:api')->post('/addSurvey', 'SurveyController@store');      /**/
/**/ Route::middleware('auth:api')->post('/deleteSurvey', 'SurveyController@destroy'); /**/
/*****************************************************************************************/

Route::middleware('auth:api')->post('/addContents', 'ContentController@store');
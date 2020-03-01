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

/**********************************************************************************************/
/*                                  SURVEY API                                                */
/**********************************************************************************************/
/**/ Route::middleware('auth:api')->get('/getSurveyList', 'SurveyController@index');        /**/
/**/ Route::middleware('auth:api')->get('/getSurvey/{slug}', 'SurveyController@show');      /**/
/**/ Route::middleware('auth:api')->get('/checkDate/{slug}', 'SurveyController@isExpired'); /**/
/**/ Route::middleware('auth:api')->post('/addSurvey', 'SurveyController@store');           /**/
/**/ Route::middleware('auth:api')->post('/deleteSurvey', 'SurveyController@destroy');      /**/
/**********************************************************************************************/

/***********************************************************************************************/
/*                                  CONTENT API                                                */
/***********************************************************************************************/
/**/ Route::middleware('auth:api')->get('/getContent/{id}', 'ContentController@show');       /**/
/**/ Route::middleware('auth:api')->post('/addContents', 'ContentController@store');         /**/
/***********************************************************************************************/

/**********************************************************************************************/
/*                                  ANSWER API                                                */
/**********************************************************************************************/
/**/ Route::middleware('auth:api')->post('/addAnswers', 'AnswerController@store');          /**/
/**********************************************************************************************/

/***********************************************************************************************/
/*                                  RESPOND API                                                */
/***********************************************************************************************/
/**/ Route::middleware('auth:api')->get('/checkExistence/{slug}', 'RespondController@show'); /**/
/**/ Route::middleware('auth:api')->get('/getRespondList', 'RespondController@index');       /**/
/**/ Route::middleware('auth:api')->post('/addRespond', 'RespondController@store');          /**/
/***********************************************************************************************/
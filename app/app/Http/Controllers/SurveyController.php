<?php

namespace App\Http\Controllers;

use Auth;
use App\Survey;
use App\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = Auth::user();
        if($currentUser->type === "admin") {

            return response()->json([
                'message'=> 'success',
                'surveyList' => Survey::all(),
            ], 200);

        } else {

            return abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->type === "admin") {

            $survey = Survey::create([
                'slug'        => Str::random(10),
                'title'       => $request->title,
                'description' => $request->description,
                'content_ids' => $request->content_ids,
                'duration'    => implode('|', (array) $request->duration),
            ]);
    
            return response()->json([
                'message'=> 'success',
            ], 200);

        } else {

            return abort(403);
        }
    }

    public function show($slug)
    {
        $survey = Survey::where('slug', '=', $slug)->first();

        if(Auth::user()->type === 'admin') {

            $contents = array();
            $contentIds = explode("-", $survey->content_ids);

            for ($i=0; $i < count($contentIds); $i++) { 

                $contentId = $contentIds[$i];
                $currentContent = Content::where('id', '=', $contentId)->first();

                array_push($contents, $currentContent);
            }

            return response()->json([
                'message'=> 'success',
                'survey'=> $survey,
                'contents'=> $contents,
            ], 200);

        } else {

            $currentDate = date('Y-m-d');
            $currentDate = date('Y-m-d', strtotime($currentDate));
            
            $dateFrom = date('Y-m-d', strtotime(explode("|", $survey->duration)[0]));
            $dateTo = date('Y-m-d', strtotime(explode("|", $survey->duration)[1]));
    
            if(!(($currentDate >= $dateFrom) && ($currentDate <= $dateTo))) {
    
                return response()->json([
                    'message'=> 'success',
                    'isExpired'=> true,
                ], 200);
    
            } else {
    
                $contents = array();
                $contentIds = explode("-", $survey->content_ids);
    
                for ($i=0; $i < count($contentIds); $i++) { 
    
                    $contentId = $contentIds[$i];
                    $currentContent = Content::where('id', '=', $contentId)->first();
    
                    array_push($contents, $currentContent);
                }
    
                return response()->json([
                    'message'=> 'success',
                    'survey'=> $survey,
                    'contents'=> $contents,
                    'isExpired'=> false,
                ], 200);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        if(Auth::user()->type === "admin") {

            $survey->delete();

            return response()->json([
                'message'=> 'success',
            ], 200);

        } else {

            return abort(403);
        }
    }
}

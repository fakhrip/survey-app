<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Survey;
use App\Respond;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RespondController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $responds = DB::table('responds')
            ->join('surveys', 'responds.survey_id', '=', 'surveys.id')
            ->select('responds.*', 'surveys.title', 'surveys.description')->get();

        return response()->json([
            'message'=> 'success',
            'respondList' => $responds,
        ], 200);
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

    function get_ip_address(){

        if (!empty($_SERVER['HTTP_CLIENT_IP']))   
        {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
        {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from remote address
        else
        {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        return $ip_address;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ip_addr = $this->get_ip_address();
        
        $respond = Respond::create([
            'ip_address'    => $ip_addr,
            'answer_ids'    => $request->answer_ids,
            'user_id'       => Auth::user()->id,
            'survey_id'     => $request->survey_id,
        ]);

        return response()->json([
            'message'=> 'success',
            'respond' => $respond,
        ], 200);
    }

    public function show($slug)
    {
        $currentUser = Auth::user();
        $isFinished = false;
        $respond = null;

        try {
        
            $respond = Respond::where('survey_id', '=', Survey::where('slug', '=', $slug)->first()->id)
                ->where('user_id', '=', $currentUser->id)->firstOrFail();
            $isFinished = true;

        } catch(ModelNotFoundException $e) {

            $isFinished = false;
        }

        return response()->json([
            'message'=> 'success',
            'isFinished' => $isFinished,
            'respond' => $respond,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Respond  $respond
     * @return \Illuminate\Http\Response
     */
    public function edit(Respond $respond)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Respond  $respond
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Respond $respond)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Respond  $respond
     * @return \Illuminate\Http\Response
     */
    public function destroy(Respond $respond)
    {
        //
    }
}

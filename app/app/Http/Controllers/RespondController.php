<?php

namespace App\Http\Controllers;

use Auth;
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
        //
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
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
    
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $respond = Respond::create([
            'ip_address'    => get_ip_address(),
            'answer_ids'    => $request->answer_ids,
            'user_id'       => Auth::user()->id,
            'survey_id'     => $request->survey_id,
        ]);

        return response()->json([
            'message'=> 'success',
            'respond' => $respond,
        ], 200);
    }

    public function show()
    {
        $currentUser = Auth::user();
        $isFinished = false;
        $respond = null;

        try {
         
            $respond = Respond::where('user_id', '=', $currentUser->id)->firstOrFail();
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

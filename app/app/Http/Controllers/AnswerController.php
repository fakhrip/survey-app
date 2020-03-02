<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->input('0.secret') === "1337_t0k3n") {

            $answer_ids = '';
            for ($i=0; $i<count($request->all()); $i++) { 
                
                $answer = Answer::create([
                    'answer'        => is_array($request->input($i.'.answer')) ? implode('|', (array) $request->input($i.'.answer')) : $request->input($i.'.answer'),
                    'content_id'    => $request->input($i.'.content_id'),
                ]);

                $answer_ids .= $answer->id;

                if($i !== count($request->all())-1)
                    $answer_ids .= '-';
            }

            return response()->json([
                'message'=> 'success',
                'answer_ids' => $answer_ids,
            ], 200);

        } else {

            return abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}

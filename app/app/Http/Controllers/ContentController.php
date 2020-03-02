<?php

namespace App\Http\Controllers;

use Auth;
use App\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
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
        if(Auth::user()->type === 'admin') {

            $contentIds = '';
            for ($i=0; $i<count($request->all()); $i++) { 
                
                $currentId = $request->input($i.'.id');

                if($currentId === 0) {

                    //------------------------------------------------------ ADD CONTENT

                    $content = Content::create([
                        'type'          => $request->input($i.'.type'),
                        'question'      => $request->input($i.'.question'),
                        'right_answer'  => $request->input($i.'.right_answer'),
                        'choices'       => implode("|", $request->input($i.'.choices')),
                        'isRequired'    => $request->input($i.'.isRequired'),
                    ]);

                } else {

                    //------------------------------------------------------ EDIT CONTENT

                    $content = Content::where('id', '=', $currentId)->first();
                    $content->type          = $request->input($i.'.type');
                    $content->question      = $request->input($i.'.question');
                    $content->right_answer  = $request->input($i.'.right_answer');
                    $content->choices       = implode("|", $request->input($i.'.choices'));
                    $content->isRequired    = $request->input($i.'.isRequired');
                    $content->save();
                }
        
                $contentIds .= $content->id;
    
                if($i !== count($request->all())-1)
                    $contentIds .= '-';
            }
    
            return response()->json([
                'message'=> 'success',
                'contentIds' => $contentIds,
            ], 200);

        } else {
            
            return abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

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
        $contentIds = '';
        for ($i=0; $i<count($request->all()); $i++) { 
            
            $content = Content::create([
                'type'          => $request->input($i.'.type'),
                'question'      => $request->input($i.'.question'),
                'right_answer'  => $request->input($i.'.right_answer'),
                'choices'       => implode("|", $request->input($i.'.choices')),
                'isRequired'    => $request->input($i.'.isRequired'),
            ]);

            $contentIds .= $content->id;

            if($i !== count($request->all())-1)
                $contentIds .= '-';
        }

        return response()->json([
            'message'=> 'success',
            'contentIds' => $contentIds,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $content = Content::where('id', '=', $id)->first();

        return response()->json([
            'message'=> 'success',
            'content' => $content,
        ], 200);
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

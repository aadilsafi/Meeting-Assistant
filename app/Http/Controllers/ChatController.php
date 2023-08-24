<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selected_chat = null;
        $chats = Chat::where('user_id',auth()->id())->get()->sortByDesc('created_at');
        return view('chat-direct',compact('chats','selected_chat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $selected_chat = Chat::where('id',$id)->where('user_id',auth()->id())->first();
        if(!$selected_chat){
            return redirect()->route('chat.index');
        }
        $chats = Chat::where('user_id',auth()->id())->get()->sortByDesc('created_at');
        return view('chat-direct',compact('selected_chat','chats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

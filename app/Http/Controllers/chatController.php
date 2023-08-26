<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use Illuminate\Http\Request;
use App\Models\group;
use App\Models\User;
use auth;

class chatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try{
            $user = auth::user();

            $contacts = $user->contacts;
            $group = group::all();
            return view("chat", compact("contacts","group"));
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function sendMessage() {
        $sender_id = (int)request()->input("sender_id");
        $reciever_id = (int)request()->get("reciever_id");
        $idsArray = [$sender_id, $reciever_id];
        sort($idsArray);
        $message = request()->get("message");
        try {
            broadcast( new SendMessage( $sender_id, $reciever_id, $message ) )->toOthers();
        } catch(\Exception $e) {
            return $e;
        }
        

    }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

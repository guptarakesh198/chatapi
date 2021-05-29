<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ChatHelper;
use App\Models\ChatData;

class ChatApiController extends Controller
{
    //
    public function index(){

      	return ['api_version' => '1.0.0'];
    } 

    public function send_message(Request $request){

    	$validator = \Validator::make(
			$request->all(), 
			[
			    'sender_id' => 'required|numeric',
			    'receiver_id' => 'required|numeric',
			    'message' => 'required',
			]
		);

		if($validator->fails()){
			$out = array('success'=>false,'error'=>$validator->getMessageBag()->first());
		    return response()->json($out, 422);
		}

		$table_name = ChatHelper::chat_init($request->sender_id,$request->receiver_id);

		$chatdata = new ChatData(['table'=>$table_name]);
		$chatdata->user_id = $request->sender_id;
		$chatdata->message = $request->message;
		$chatdata->save();

		// send cloud notification to receiver device to detect message

		$data = new ChatData(['table'=>$table_name]);
		$data = $data->get();

		$out = array('success'=>true,'data'=>$data);
		return response()->json($out, 200);

    }

    public function send_list(Request $request){


    	$validator = \Validator::make(
			$request->all(), 
			[
			    'sender_id' => 'required|numeric',
			    'receiver_id' => 'required|numeric',
			]
		);

		if($validator->fails()){
			$out = array('success'=>false,'error'=>$validator->getMessageBag()->first());
		    return response()->json($out, 422);
		}

		$table_name = ChatHelper::chat_init($request->sender_id,$request->receiver_id);

		$data = new ChatData(['table'=>$table_name]);
		$data = $data->get();

		$out = array('success'=>true,'data'=>$data);
		return response()->json($out, 200);

    }

}

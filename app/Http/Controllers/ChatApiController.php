<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ChatHelper;
use App\Models\ChatData;
use App\Models\ChatUser;


class ChatApiController extends Controller
{
    //
    public function index(){

      	return ['api_version' => '1.0.0'];
    }

    public function user_list(Request $request){

    	$validator = \Validator::make(
			$request->all(), 
			[
			    'phoneno' => 'required|numeric',
			]
		);

		if($validator->fails()){
			$out = array('success'=>false,'error'=>$validator->getMessageBag()->first());
		    return response()->json($out, 200);
		}

		$row = ChatUser::where('phoneno',$request->phoneno)->first();

		if($row != null){

			$out = array('success'=>false,'data'=> $row);
		    return response()->json($out, 200);

		}else{

			$out = array('success'=>false,'error'=> 'No User Found');
		    return response()->json($out, 200);

		}


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
		    return response()->json($out, 200);
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
		    return response()->json($out, 200);
		}

		$table_name = ChatHelper::chat_init($request->sender_id,$request->receiver_id);

		$data = new ChatData(['table'=>$table_name]);
		$data = $data->get();

		$out = array('success'=>true,'data'=>$data);
		return response()->json($out, 200);

    }

    public function message_seen(Request $request){

    	$validator = \Validator::make(
			$request->all(), 
			[
				'sender_id' => 'required|numeric',
			    'receiver_id' => 'required|numeric',
			    'msg_id' => 'required|numeric',
			]
		);

		if($validator->fails()){
			$out = array('success'=>false,'error'=>$validator->getMessageBag()->first());
		    return response()->json($out, 200);
		}

		$table_name = ChatHelper::chat_init($request->sender_id,$request->receiver_id);

		$chat_table = new ChatData(['table'=>$table_name]);

	    if($chat_table->where('id',$request->msg_id)->update(['is_seen'=>1])){

	    	$out = array('success'=>true);
			return response()->json($out, 200);

	    }else{

	    	$out = array('success'=>false);
			return response()->json($out, 200);

	    }

    }

}

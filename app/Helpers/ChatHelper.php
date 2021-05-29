<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ChatData;

class ChatHelper
{
    
    public static function get_user_table($sender_id, $receiver_id){

	    $collection = collect([$sender_id, $receiver_id]);
			$sorted = $collection->sort();
			$values = $sorted->values()->all();
			$table_name = 'chat_'.$values[0].'_'.$values[1];

			ChatHelper::generate_table($table_name);

			return $table_name;
    }

    public static function generate_table($table_name){

    	if (!Schema::hasTable($table_name)) {

	    	Schema::create($table_name, function (Blueprint $table) {
	        $table->id();
	        $table->integer('user_id');
	        $table->string('message');
	        $table->timestamps();
	      });

    	}else{

    		$table = new ChatData(['table'=>$table_name]);
    		$table->activityOlderThan(10)->delete();

    	}

    }

    public static function chat_init($sender_id, $receiver_id){

    	return ChatHelper::get_user_table($sender_id, $receiver_id);

    }

}
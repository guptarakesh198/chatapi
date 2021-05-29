<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ChatData extends Model
{
    use HasFactory;

    protected $table = 'chat_';
    protected $primaryKey = 'id';

    public function __construct($params=array()) {
	    if (isset($params['table'])) {
	        $this->table = $params['table'];
	    }
	}

	public function scopeActivityOlderThan($query, $interval)
	{
	    return $query->where('created_at', '<', Carbon::now()->subMinutes($interval)->toDateTimeString());
	}

}

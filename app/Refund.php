<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    // public $request;
    // public function __construct(Request $r)
    // {
    //     $this->request=$r;
    // }
    public $created_at=false;
    public $updated_at=false;
    protected $fillable=[
        'request_id',
        'worker_id',
        'attachment',
        'reason',
        'quantity'
    ];

}

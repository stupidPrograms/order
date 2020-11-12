<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderRecord extends Model
{
    //
    use SoftDeletes;

    protected $table = 'order_record';

    protected $fillable = [
        'uuid',
        'order_id',
        'mark',
        'mobile',
        'comment',
        'operator',
        'record_type'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function addRecord($data)
    {
        return $this->create($data);
    }

}

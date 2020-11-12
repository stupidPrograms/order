<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderAddress extends Model
{
    //
    use SoftDeletes;

    protected $table = 'order_address';

    protected $fillable = [
        'uuid',
        'recipient',
        'province',
        'city',
        'area',
        'address',
        'phone',
        'default',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function getUserAddressList($uuid){
        return $this->where('uuid', $uuid)->get();
    }

    public function addAddress($uuid, $recipient, $province, $city, $area, $address, $phone, $default)
    {

        $data = [
            'uuid' => $uuid,
            'recipient' => $recipient,
            'province' => $province,
            'city' => $city,
            'area' => $area,
            'address' => $address,
            'phone' => $phone,
            'default' => $default
        ];
        return $this->create($data);
    }

    public function updateAddress($uuid, $address_id, $data)
    {
        return $this->where('uuid', $uuid)->where('id', $address_id)->update($data);
    }

    public function getAddressString()
    {
        return $this->province.$this->city.$this->area.$this->address;
    }

    public function getRecipient()
    {
        return $this->recipient;
    }
}

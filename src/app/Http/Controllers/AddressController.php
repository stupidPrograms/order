<?php

namespace App\Http\Controllers;

use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Translation\Exception\InvalidResourceException;

class AddressController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $uuid = $request->user()->uuid;
            $order_list = OrderAddress::query()->where('uuid',$uuid)->get();
            return $this->success($order_list);
        }catch (\Throwable $throwable){
            return $this->failed($throwable->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return $this->success('create');
    }

    /**
     * 添加地址
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'province'  => 'required|string',
            'city'      => 'required|string',
            'area'      => 'required|string',
            'default'   => 'bail|required|in:0,1',
            'recipient' => 'required|max:16',
            'address'   => 'required|max:255',
            'phone'     => 'required|numeric|regex:/^[1-9]{2}\d{9}$/',
        ]);
        if ($error = $validate->errors()->first()) {
            return $this->failed($error);
        }

        $default    = $request->input('default',0);

        try{
            $uuid = $request->user()->uuid;

            //若有原有的默认地址，则修改原有
            if($default == 1){
                OrderAddress::query()->where('uuid', $uuid)->where('default', 1)->update(['default' => 0]);
            }

            $data = $request->all();
            unset($data['area_code']);
            $data['uuid']   =   $uuid;

            $address_info = OrderAddress::query()->insert($data);
            if (!$address_info){
                throw new InvalidResourceException('添加地址失败');
            }

            return $this->success('添加地址成功');
        }catch (\Throwable $throwable){
            return $this->failed($throwable->getMessage());
        }
    }

    /**
     * 地址详情
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = OrderAddress::query()->find($id);
        return $this->success($address);
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
        return $this->success('edit');
    }

    /**
     * 更新/修改地址
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(),[
                'recipient' =>  'bail|required|string',
                'address'   =>  'bail|required|string|max:255',
                'phone'     =>  'bail|required|string',
                'default'   =>  'bail|required|integer|in:0,1',
                'province'  =>  'bail|required',
                'city'      =>  'bail|required',
                'area'      =>  'bail|required',
            ]);

            if($error = $validator->errors()->first()){
                return  $this->failed($error);
            }


            $uuid = $request->user()->uuid;
            if($request->input('default') == 1){
                OrderAddress::query()->where('uuid',$uuid)->where('default',1)->update(['default'=> 0]);
            }

            $data = $request->all();
            unset($data['area_code']);

            $order_list = OrderAddress::query()->where('uuid',$uuid)->where('id',$id)->update($data);

            if (!$order_list){
                throw new InvalidResourceException('更新地址失败');
            }
            return $this->success('修改成功');
        }catch (\Throwable $throwable){
            return $this->failed($throwable->getMessage().$throwable->getLine());
        }
    }

    /**
     * 删除地址
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function destroy(Request $request,$id)
    {
        $uuid = $request->user()->uuid;

        $res = OrderAddress::query()->where('uuid',$uuid)->where('id',$id);

        $del = clone $res;

        $info = $res->first();
        //若是選中的地址為默認地址
        if($info->default == 1){
            //刪除地址
            $edit = OrderAddress::query()->where('uuid',$uuid)->orderBy('id','desc')->limit(1)->first(['id','default']);
            $edit->default = 1;
            $edit->save();
        }
        $del->delete();

        return $this->success('修改成功');

    }

    /**
     * 默认地址信息
     * @param Request $request
     * @return mixed
     */
    public function defaultAddress(Request $request)
    {
        $token = $request->header('X-API-Key');
        try {
            $uuid    = $request->user()->uuid;
            $address = OrderAddress::query()->where('default', 1)->where('uuid', $uuid)->first();

            return $this->success($address);
        }catch (\Throwable $throwable){
            return $this->failed($throwable->getMessage());
        }
    }

    /**
     * 设置默认地址
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function setDefaultAddress(Request $request, $id)
    {
        try {
            $uuid = $request->user()->uuid;
            $res = OrderAddress::query()->where('id', $id)->first();
            if(!$res){
                throw new InvalidResourceException('选择地址出错');
            }

            OrderAddress::query()->where('uuid', $uuid)->where('default', 1)->update(['default' => 0]);

            OrderAddress::query()->where('id', $id)->where('uuid', $uuid)->update(['default' => 1]);

            return $this->success('设置成功');
        }catch (\Throwable $throwable){
            return $this->failed($throwable->getMessage());
        }
    }

}

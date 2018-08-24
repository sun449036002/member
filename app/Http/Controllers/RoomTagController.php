<?php

namespace App\Http\Controllers;

use App\Model\RoomTagModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomTagController extends Controller
{
    public function index()
    {
        $model = new RoomTagModel();
        $this->pageData['list'] = $model->getList(['*'], ['isDel' => 0]);
        return view('roomTag/index', $this->pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rule = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => '标签名称必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        (new RoomTagModel())->insert(['name' => $data['name']]);

        return redirect("roomTag");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->pageData['row'] = (new RoomTagModel())->getOne(['*'], ['id' => $id]);
        return view('roomTag/edit', $this->pageData);
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
        $data = $request->all();
        $rule = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => '标签名称必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        $model = new RoomTagModel();
        $model->updateData(['name' => $data['name']], ['id' => $id]);

        return redirect('roomTag');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = new RoomTagModel();
        $model->updateData(['isDel' => 1], ['id' => $id]);
        exit(json_encode(['code' => 0, 'msg' => '删除成功']));
    }
}

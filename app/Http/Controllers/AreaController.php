<?php

namespace App\Http\Controllers;

use App\Model\AreaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new AreaModel();
        $this->pageData['list'] = $model->getList(['*'], ['isDel' => 0]);
        return SView('area/index', $this->pageData);
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
            'name.required' => '名称必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        (new AreaModel())->insert(['name' => $data['name']]);

        return redirect("area");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->pageData['row'] = (new AreaModel())->getOne(['*'], ['id' => $id]);
        return view('area/edit', $this->pageData);
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
            'name.required' => '名称必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        $model = new AreaModel();
        $model->updateData(['name' => $data['name']], ['id' => $id]);

        return redirect('area');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = new AreaModel();
        $model->updateData(['isDel' => 1], ['id' => $id]);
        exit(json_encode(['code' => 0, 'msg' => '删除成功']));
    }
}

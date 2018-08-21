<?php

namespace App\Http\Controllers;

use App\Model\CustomServiceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $this->pageData['title'] = "客服列表";
        $this->pageData['list'] = (new CustomServiceModel())->getList(['*'], ['isDel' => 0]);
        return view('customService/index', $this->pageData);
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
            'tel' => 'required',
        ];
        $message = [
            'name.required' => '姓名必填',
            'tel.required' => '联系电话必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        (new CustomServiceModel())->insert([
            'name' => $data['name'],
            'tel' => $data['tel'],
        ]);

        return redirect("customService");
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->pageData['row'] = (new CustomServiceModel())->getOne(['*'], ['id' => $id]);
        return view('customService/edit', $this->pageData);
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
            'tel' => 'required',
        ];
        $message = [
            'name.required' => '姓名必填',
            'tel.required' => '联系电话必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        $model = new CustomServiceModel();
        $model->updateData([
            'name' => $data['name'],
            'tel' => $data['tel'],
        ], ['id' => $id]);

        return redirect('adminGroups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = new CustomServiceModel();
        $model->updateData(['isDel' => 1], ['id' => $id]);
        exit(json_encode(['code' => 0, 'msg' => '删除成功']));
    }
}

<?php

namespace App\Http\Controllers;

use App\Model\AdsModel;
use Couchbase\SpatialViewQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->pageData['list'] = (new AdsModel())->getList(['*'], ['isDel' => 0]);
        return SView('ads/index', $this->pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return SView('ads/add', $this->pageData);
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
            'img' => 'required',
        ];
        $message = [
            'img.required' => '广告图片不得为空',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        (new AdsModel())->insert([
            'title' => $data['title'],
            'url' => $data['url'],
            'img' => $data['img'],
        ]);

        return redirect('/ads');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = (new AdsModel())->getOne(['*'], ['id' => $id]);

        $this->pageData['row'] = $row;
        return SView('ads/edit', $this->pageData);
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
            'img' => 'required',
        ];
        $message = [
            'img.required' => '广告图片不得为空',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        (new AdsModel())->updateData([
            'title' => $data['title'],
            'url' => $data['url'],
            'img' => $data['img'],
        ], ['id' => $id]);

        return redirect('/ads');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        (new AdsModel())->updateData(['isDel' => 1], ['id' => $id]);

        return ResultClientJson(0, '删除成功');
    }
}

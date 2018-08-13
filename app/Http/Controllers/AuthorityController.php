<?php

namespace App\Http\Controllers;

use App\Model\GroupRouteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorityController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = new GroupRouteModel();
        $myRouteList = $model->getList(['*'], ['groupId' => $id]);

        //取得当前组下可用的权限
        $treeList = [];
        $myRoutes = [];
        foreach ($myRouteList as $item) {
            $myRoutes[] = $item->route;
        }

        //遍历所有权限，生成  js tree 数据
        foreach ($this->pageData['allMenuList'] as $menu) {
            $subList = [];
            foreach ($menu['subMenuList'] ?? [] as $subMenu) {
                $subList[] = [
                    'text' => $subMenu['title'],
                    'li_attr' => [
                        'route' => $subMenu['route']
                    ],
                    'state' => [
                        'selected' => in_array($subMenu['route'], $myRoutes),
                    ]
                ];
            }
            $treeList[] = [
                'text' => $menu['title'],
                'li_attr' => [
                    'route' => $menu['route']
                ],
                'state' => [
                    'selected' => in_array($menu['route'], $myRoutes),
                ],
                'children' => $subList
            ];
        }
        $this->pageData['treeJson'] = json_encode($treeList, JSON_UNESCAPED_UNICODE);
        $this->pageData['group_id'] = $id;

        return SView('authority/index', $this->pageData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rule = [
            'id' => 'required',
        ];
        $message = [
            'id.required' => '授权的用户组ID必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        $model = new GroupRouteModel();
        $model->where(['groupId' => $data['id']])->delete();

        if (!empty($data['route'])) {
            foreach ($data['route'] as $route) {
                $route = trim($route);
                if ($route == "#") {
                    continue;
                }
                $model->insert([
                    'groupId' => $data['id'],
                    'route' => $route
                ]);
            }
        }

        return redirect('authority/' . $data['id'] . "/edit");
    }
}

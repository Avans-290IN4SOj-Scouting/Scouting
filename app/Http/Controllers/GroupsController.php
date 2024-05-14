<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    //
    public function index()
    {
        $groups = Group::orderBy('name', 'asc')->get();

        return view('admin.groups', [
            'groups' => $groups,

            'subgroups' => [
                (object)['name' => 'hello!'],
                (object)['name' => 'world!']
            ],
            'subGroupLeaders' => [
                (object)['email' => 'hello!'],
                (object)['email' => 'world!']
            ],
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\LeftList;
use Illuminate\Http\Request;

class LeftListController extends Controller
{

    public function index()
    {
        return LeftList::get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inRegion' => 'required',
            'toRegion' => 'required',
            'who'      => 'required',
            'start'    => 'required',
            'back'     => 'required'
        ]);

        return LeftList::create([
            'region'   => $data['inRegion'],
            'toregion' => $data['toRegion'],
            'start'    => $data['start'],
            'back'     => $data['back'],
            'courier'  => $data['who'],
        ]);
    }
}

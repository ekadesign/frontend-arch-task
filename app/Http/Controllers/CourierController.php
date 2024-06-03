<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function index()
    {
        return Courier::get();
    }

    public function show($id)
    {
        return Courier::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'courier' => 'required|string'
        ]);
        $data['busytime'] = Carbon::now();

        return Courier::create($data);
    }
}

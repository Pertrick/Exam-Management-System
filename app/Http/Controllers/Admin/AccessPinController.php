<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessPin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessPinController extends Controller
{
    public function index()
    {
        $data['pins'] = AccessPin::with('creator','usedBy')->latest()->get();
        $data['i']=1;
        return view('admin.access_pin.index', $data);
    }

    public function create()
    {

        $qtys =10;
        $batch=rand(). uniqid();

        for ($i = 0; $i < $qtys; $i++) {
            $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $sh1 = str_shuffle($str);
            $st = $sh1 . uniqid();
            $sh2 = str_shuffle($st);

            AccessPin::create([
                "pin"=> substr($sh2, 0,7),
                "serial"=> $batch.$i,
                "created_by" => Auth::id()
            ]);
        }

        return redirect()->route('admin.accesspin.index')->with("success", "Access pins generated successfully");
    }

}

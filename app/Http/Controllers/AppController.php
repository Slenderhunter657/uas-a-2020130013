<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuCount = Menu::all()->count();
        $orderCount = Order::all()->count();
        return view('index',compact('menuCount','orderCount'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        return view('orders.index',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::all();
        return view('order', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'status' => 'required|not_in:none'
        ];
        $validated = $request->validate($rules);
        Order::create($validated);

        // $testing = $request['id'.$i];

        // for($i=0;$i<count($request)-1;$i++){

        // }

        $menucount = Menu::all()->count();
        $orderId = Order::all()->last()->id;
        for($i = 1; $i<=$menucount; $i++){
            if($request['quantity'.$i]>0){
                DB::table('order_menu')->insert([
                    'order_id' => $orderId,
                    'menu_id' => $request['id'.$i],
                    'quantity' => $request['quantity'.$i],
                ]);
            }
        }
        $request->session()->flash('success',"Successfully added Order Number {$orderId}!");
        return redirect(route('main.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $datas = DB::select('SELECT om.menu_id,m.nama,m.rekomendasi,om.quantity,m.harga FROM order_menu om LEFT JOIN menus m ON om.menu_id = m.id WHERE om.order_id = ?',[$order->id]);

        $priceList = DB::select('SELECT m.rekomendasi,om.quantity*m.harga gross_price FROM order_menu om JOIN menus m ON om.menu_id = m.id WHERE om.order_id = ?',[$order->id]);
        $price = 0;
        foreach($priceList as $pl){
            if($pl->rekomendasi){
                $price += round($pl->gross_price*0.9,2);
                // dump($price);
            }else{
                $price+=$pl->gross_price;
                // dump($price);
            }
        }
        $price = round($price*1.11,2);

        return view('orders.show', compact('order','datas','price'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect(route('order.index'))->with('success', "Successfully deleted Order Number {$order['id']}!");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Log\Test\DummyTest;
use Ramsey\Uuid\Type\Integer;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $try = "FD";
        // $try2 = "001";
        // dump($try . $try2);
        $menus = Menu::all();
        return view('menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('menus.create');
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
            'id' => 'required|not_in:none',
            'nama' => 'required',
            'rekomendasi' => 'present',
            'harga' => 'required|min:0',
        ];
        $validated = $request->validate($rules);
        $type = '';
        switch ($validated["id"]) {
            case "food":
                $type = 'FD';
                break;
            case "drink":
                $type = 'DR';
                break;
            case "dessert":
                $type = 'DS';
                break;
            default:
                $type = 'OT';
                break;
        }

        $latestId = DB::select("SELECT RIGHT(id,4) rightid FROM menus WHERE id LIKE '$type%' ORDER BY rightid DESC");

        if(!$latestId){
            $currentId = sprintf("%04d", 1);
        }else{
            $currentId = sprintf("%04d", $latestId[0]->rightid + 1);
        }

        $validated["id"] = $type . $currentId;

        Menu::create($validated);
        $request->session()->flash('success',"Successfully added {$validated['nama']}!");
        return redirect(route('menus.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return view('menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        return view("menus.edit", compact("menu"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $rules = [
            'id' => 'required|not_in:none',
            'nama' => 'required',
            'rekomendasi' => 'present',
            'harga' => 'required|min:0',
        ];
        $validated = $request->validate($rules);
        $type = '';
        switch ($validated["id"]) {
            case "food":
                $type = 'FD';
                break;
            case "drink":
                $type = 'DR';
                break;
            case "dessert":
                $type = 'DS';
                break;
            default:
                $type = 'OT';
                break;
        }

        $latestId = DB::select("SELECT RIGHT(id,4) rightid FROM menus WHERE id LIKE '$type%' ORDER BY rightid DESC");

        if(!$latestId){
            $currentId = sprintf("%04d", 1);
        }else{
            $currentId = sprintf("%04d", $latestId[0]->rightid + 1);
        }

        $validated["id"] = $type . $currentId;

        $menu->update($validated);
        $request->session()->flash('success',"Successfully updated {$validated['nama']}!");
        return redirect(route('menus.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect(route('menus.index'))->with('success', "Successfully deleted {$menu['nama']}!");
    }
}

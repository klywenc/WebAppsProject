<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    public function dashboard()
    {
        $menuItems = Menu::all();
        return view('admin.dashboard', compact('menuItems'));
    }
}

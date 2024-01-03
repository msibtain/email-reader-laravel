<?php

namespace App\Http\Controllers;
use App\Models\BlacklistLinks;

use Illuminate\Http\Request;

class BlacklistLinksController extends Controller
{
    public function index()
    {
        $blacklistlinks = BlacklistLinks::get();
        return view('blacklistlinks.list', compact('blacklistlinks'));
    }

    public function add()
    {
        return view('blacklistlinks.add');
    }

    public function submit(Request $request)
    {
        $BlacklistLinks = new BlacklistLinks();
        $BlacklistLinks->column = $request->column;
        $BlacklistLinks->operator = $request->operator;
        $BlacklistLinks->value = $request->value;
        $BlacklistLinks->save();

        return redirect("/blacklists")->with("success", "New Rule has been added");
    }

    public function edit($id)
    {
        $blacklistlinks = BlacklistLinks::where("id", $id)->first();
        return view('blacklistlinks.edit', compact('blacklistlinks'));
    }

    public function update($id, Request $request)
    {
        $BlacklistLinks = BlacklistLinks::where("id", $id)->first();
        $BlacklistLinks->column = $request->column;
        $BlacklistLinks->operator = $request->operator;
        $BlacklistLinks->value = $request->value;
        $BlacklistLinks->save();

        return redirect("/blacklists")->with("success", "Rule has been updated");
    }

    public function delete($id)
    {
        BlacklistLinks::where("id", $id)->delete();
        return redirect("/blacklists")->with("success", "Rule has been deleted");
    }

}

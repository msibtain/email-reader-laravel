<?php

namespace App\Http\Controllers;
use App\Models\Rule;

use Illuminate\Http\Request;

class RulesController extends Controller
{
    public function index()
    {
        $rules = Rule::get();
        return view('rules.list', compact('rules'));
    }

    public function add()
    {
        return view('rules.add');
    }

    public function submit(Request $request)
    {
        $Rule = new Rule();
        $Rule->column = $request->column;
        $Rule->operator = $request->operator;
        $Rule->value = $request->value;
        $Rule->save();

        return redirect("/rules")->with("success", "New Rule has been added");
    }

    public function edit($id)
    {
        $rule = Rule::where("id", $id)->first();
        return view('rules.edit', compact('rule'));
    }

    public function update($id, Request $request)
    {
        $Rule = Rule::where("id", $id)->first();
        $Rule->column = $request->column;
        $Rule->operator = $request->operator;
        $Rule->value = $request->value;
        $Rule->save();

        return redirect("/rules")->with("success", "Rule has been updated");
    }

    public function delete($id)
    {
        Rule::where("id", $id)->delete();
        return redirect("/rules")->with("success", "Rule has been deleted");
    }

}

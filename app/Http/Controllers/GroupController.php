<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller {


	public function index(Request $request) {
		return view("admin.groups", ["groups" => Group::all()]);
	}

	public function store(Request $request) {
		$inputs = $this->processInputs($request->all());
		$user = Group::create($inputs);
	}

	public function update(Request $request, Group $group) {
		$inputs = $this->processInputs($request->all());
		$group->fill($inputs)->save();
	}

	public function processInputs($inputs) {
		return $inputs;
	}

	public function destroy(Request $request, $group) {
		$group->delete();
	}
}

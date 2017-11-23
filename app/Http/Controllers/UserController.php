<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\User;
use App\Group;
use App\Notifications\Signin;

class UserController extends Controller {

	public function index(Request $request) {
		return view("admin.users", ["users" => User::orderBy('lastname', 'ASC')->get()]);
	}

	public function store(Request $request) {
		$inputs = $this->processInputs($request->all());
		$user = User::create($inputs);

		if ($request->has('groups')) {
			$user->groups()->sync(array_keys($inputs['groups']));
		}

		return $user;
	}

	public function signin(Request $request) {

		$user = $this->store($request);

		Notification::send(User::administrators(), new Signin($user));
	}

	public function update(Request $request, User $user) {
		$inputs = $this->processInputs($request->all());
		$user->fill($inputs)->save();

		if ($request->has('groups')) {
			$user->groups()->sync(array_keys($inputs['groups']));
		}
	}

	public function processInputs($inputs) {
		if (isset($inputs['password'])) {
			$inputs['password'] = bcrypt($inputs['password']);
		} else {
			unset($inputs['password']);
		}
		return $inputs;
	}

	public function destroy(Request $request, $user) {
		$user->delete();
	}
}

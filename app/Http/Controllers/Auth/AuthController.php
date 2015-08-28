<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;
use App\User;

class AuthController extends Controller {

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}
}

<?php


namespace App\Http\Controllers;


use Authorization\Application\Service\User\UserApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return view("login");
        }

        return redirect()->intended('/backlog');
    }

    public function postRegister(Request $request, UserApplicationService $service)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $email = $request->get("email");
        $password = $request->get("password");
        $name = $request->get("name");
        $result = $service->create(
            $email,
            $password,
            $name
        );

        if ($result->isError()) {
            $message = "Email already registered.";
            return view("register", compact("message"));
        }

        return redirect()->intended("/backlog");
    }

    public function postLogout()
    {
        Auth::logout();

        return redirect("/");
    }

    private function validator(array $data)
    {
        return Validator::make($data, [
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "string", "email", "max:100"],
            // "password" => ["required", "string", "min:8", "confirmed"],
            "password" => ["required", "string", "min:8"],
        ]);
    }
}

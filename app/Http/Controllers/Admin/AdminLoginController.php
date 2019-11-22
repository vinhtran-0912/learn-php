<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// khai báo sử dụng loginRequest
use App\Http\Requests\LoginRequest;
use Auth;
use App\User;
class AdminLoginController extends Controller
{

    public function getLogin()
    {
        if (Auth::check()) {
            // nếu đăng nhập thàng công thì 
            return redirect('admincp');
        } else {
            return view('admin.login');
        }

    }

    /**
     * @SWG\Post(
     *      path="/api/v1/login",
     *      summary="Login",
     *      tags={"Authorization"},
     *      @SWG\Parameter(
     *          name="email",
     *          in="formData",
     *          required=true,
     *          type="string",
     *          format="email",
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          in="formData",
     *          required=true,
     *          type="string",
     *          format="password",
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Login successfully!",
     *          examples={"application/json": {
     *              "token_type": "Bearer",
     *              "expires_at": "01/01/1970 00:00:00",
     *              "access_token": "eyJ0eX.eyJhdWQ.CqlglC3",
     *              "refresh_token": "def50200e"
     *          }}
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="Authentication Error!",
     *          @SWG\Schema(
     *              ref="#/definitions/AuthenticationError",
     *          ),
     *      ),
     *      @SWG\Response(
     *          response=500,
     *          description="Internal server error!",
     *          @SWG\Schema(
     *              ref="#/definitions/InternalServerError",
     *          ),
     *      ),
     * )
     */
    public function postLogin(LoginRequest $request)
    {
        $login = [
            'email' => $request->txtEmail,
            'password' => $request->txtPassword,
        ];
        if (Auth::attempt($login)) {
            return redirect('admincp');
        } else {
            return redirect()->back()->with('status', 'Email hoặc Password không chính xác');
        }
    }

    /**
     * @SWG\Post(
     *      path="/api/v1/logout",
     *      summary="Logout",
     *      tags={"Authorization"},
     *      security={
     *          {"passport": {}},
     *      },
     *      @SWG\Response(
     *          response=200,
     *          description="Logout successfully!",
     *          examples={"application/json": {
     *              "data": {
     *                  "message": "ログアウトに成功しました。!",
     *                  "logout_at": "01/01/1970 00:00:00",
     *              }
     *          }},
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="Authentication Error!",
     *          @SWG\Schema(
     *              ref="#/definitions/AuthenticationError",
     *          ),
     *      ),
     *      @SWG\Response(
     *          response=500,
     *          description="Internal server error!",
     *          @SWG\Schema(
     *              ref="#/definitions/InternalServerError",
     *          ),
     *      ),
     * )
     */
    public function getLogout()
    {
        Auth::logout();

        return response()->json([
            'data' => [
                'message' => __('auth.logout_successful'),
                'logout_at' => formatDateTimeDefault(Carbon::now()),
            ],
        ]);
    }

}

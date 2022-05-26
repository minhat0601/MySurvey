<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Providers\JWT\Lcobucci;

use App\User;

use Tymon\JWTAuth\Facades\JWTFactory;
use GenTux\Jwt\JwtToken;

class AuthController extends Controller
{
    public function signup(Request $request)
    {   
        $rules = [
            'email' =>'required|email',
            'password' => 'required|min:8',
            'fullname' => 'required|min:5'
        ];
        $messages = [
            'email.required' => 'Bạn chưa nhập Email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự',
            'fullname.min' => 'Tên của bạn phải trên 5 ký tự'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(['msg' => $validator->errors()], 417);
        }else{
            if(User::where('email', $request->input('email'))->first()){
                return response()->json(['msg' => 'Email đã tồn tại, bạn vui lòng chọn một Email khác'], 417);
            }else{
                $User = new User();
                $User->fullname = $request->input('fullname');
                $User->email = $request->input('email');
                $User->password = bcrypt($request->input('password'));
                $User->phone = $request->input('phone');
                $User->user_type = 1;
                $User->save();
                return response()->json(['msg' => 'Tạo tài khoản thành công', 'data' => $User], Response::HTTP_OK);
            }
        }
    }

    public function login(Request $request)
    {
        $rules = [
            'email' =>'required|email',
            'password' => 'required',
        ];
        $messages = [
            'email.required' => 'Bạn chưa nhập Email',
            'email.email' => 'Email không đúng định dạng',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(['msg' => $validator->errors()], 417);
        }else{
            $email = $request->input('email');
            $password = $request->input('password');
            // Xác thực thông tin người dùng
            if(Auth::attempt(['email' => $email, 'password' => $password])) {
                // $customClaim = [
                //     "user_id" => Auth::user()['user_id'],
                //     "email" => Auth::user()['email'],
                // ];
                // $payload = JWTFactory::make($customClaim);
                // $token = JWTAuth::encode($payload);
                
                // $customClaims = ['foo' => 'bar', 'baz' => 'bob'];

                // $payload = JWTFactory::make($customClaims);

                // $token = JWTAuth::encode($payload);
                // return ($token);


                // $token1 = auth()->claims(
                //     [
                //         'user_id' => Auth::user()['user_id'],
                //         'fullname' => Auth::user()['fullname']
                //         ]
                //     )->attempt(['email' => $email, 'password' => $password]);

                // $testUser = User::find(1);
                // return auth()->login($testUser);
                    return  response()->json(['msg' => 'Đăng nhập thành công', 'data' => Auth::user()], 200);
            } else {
                return response()->json(['msg' => 'Tài khoản hoặc mật khẩu không đúng'], 403);
            }
        }
    }



    public function user(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            return response($user, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function me()
    {
        return Lcobucci::encode(User::find(1));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


}

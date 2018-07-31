<?php
namespace App\Http\Controllers;
use App\Constants\ConstProfile;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;


class AuthController extends Controller
{
    /**
     * Object
     * {
     *      "email": "andrevini@gmail.com",
     *      "name" : "André Vinicius da Silva Caixeta",
     *      "password": "abcd1234",
     *      "cellphone": "61998280155",
     *      "cpf": "00713877146",
     *      "birthday": "1985-07-13"
     *   }
     */
    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'email' => 'required|unique:users',
                'name' => 'required',
                'password' => 'required',
                'cellphone' => 'required|unique:users',
                'cpf' => 'required|unique:users|cpf'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag(), 400);
            }

            $user = new User;
            $user->email = $request->email;
            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->cellphone = $request->cellphone;
            $user->cpf = $request->cpf;
            $user->birthday = $request->birthday;
            if ($request->gender) {
                $user->gender = $request->gender;
            }
            $user->save();
            $user->profiles()->attach(ConstProfile::USUARIO);

            DB::commit();
            return response([
                'status' => 'success',
                'data' => $user
            ], 200);
        }catch (\Exception $e){
            DB::rollBack();
            return response(['status' => 'error', 'data' => $e->getMessage(), 'code' => $e->getCode()]);
        }
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 400);
        }
        return response([
            'status' => 'success',
            'token' => $token
        ]);
    }
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response([
            'status' => 'success',
            'data' => $user
        ]);
    }
    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request) {
        $this->validate($request, ['token' => 'required']);
        
        try {
            JWTAuth::invalidate($request->input('token'));
            return response([
            'status' => 'success',
            'msg' => 'You have successfully logged out.'
        ]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response([
                'status' => 'error',
                'msg' => 'Failed to logout, please try again.'
            ]);
        }
    }
    public function refresh()
    {
        return response([
            'status' => 'success'
        ]);
    }
}
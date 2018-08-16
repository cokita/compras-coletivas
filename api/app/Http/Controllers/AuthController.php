<?php
namespace App\Http\Controllers;
use App\Constants\ConstProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
            return response(['status' => 'error', 'data' => $e->getMessage(), 'code' => $e->getCode() ? $e->getCode() : 400]);
        }
    }
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                throw new \Exception("Usuário ou senha inválidos!", 401);
            }

            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;

            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);

            $token->save();

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ]);
        }catch (\Exception $e){
            dd($e->getMessage());
            return response()->json(['message' => $e->getMessage()], $e->getCode() ? $e->getCode() : 400);
        }
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
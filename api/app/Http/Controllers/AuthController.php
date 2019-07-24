<?php
namespace App\Http\Controllers;
use App\Constants\ConstProfile;
use App\Models\ProfilesActions;
use App\Models\UsersProfiles;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;


class AuthController extends Controller
{

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

            $perfis = UsersProfiles::query()
                ->join('profiles as p', 'p.Id', '=', 'users_profiles.profile_id')
                ->where('user_id', auth()->user()->id)
                ->select(['p.id', 'p.name'])
                ->get();

            if($perfis){
                $count = 0;
                foreach ($perfis->toArray() as $perfil){
                    $actions = ProfilesActions::query()
                        ->join('actions as a', 'a.id', '=', 'profiles_actions.action_id')
                        ->where('profiles_actions.profile_id', $perfil['id'])
                        ->select(['a.id', 'a.name'])->get();
                    $perfis[$count]['actions'] = $actions->toArray();
                }
            }

            $user = auth()->user()->toArray();
            $user['profiles'] = $perfis;

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                'user' => $user
            ]);
        }catch (\Exception $e){
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
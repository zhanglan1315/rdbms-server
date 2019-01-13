<?php

namespace App\Services;

use DB;
use Carbon\Carbon;
use App\Repositories\Facades\Users;
use Firebase\JWT\JWT as JWTBase;

class JWT
{
    protected $user;

    protected $key;

    private $token;

    private $tokenInfo = false;

    public function __construct()
    {
        $this->key = config('jwt.secret');
    }

    private function encode(array $data)
    {
        return JWTBase::encode($data, $this->key);
    }

    // if token is invalid or expired, it can not be decoded
    public function decode($token)
    {
        try {
            return JWTBASE::decode($token, $this->key, ['HS256']);
        } catch (\Exception $e) {
            return false;
        }
    }

    // 

    public function generate($id)
    {
        $now = Carbon::now()->timestamp;
        $rfa = Carbon::now()->addDay(1000)->timestamp;
        $exp = Carbon::now()->addDay(1000)->timestamp;

		$user = DB::table('user')
			->select('id', 'updated_at')
            ->addSelect(DB::raw('to_json(roles) as roles'))
            ->where('id', $id)
			->first();

		$user->roles = json_decode($user->roles);
        $user->sub = 1;
        $user->aud = 'DataPlanner';
        $user->iat = $now;
        $user->exp = $exp;
        $user->rfa = $rfa;

        return [
            'token' => 'Bearer '.$this->encode((array)$user),
            'expired_at' => $exp,
            'refresh_at' => $rfa,
        ];
    }

    public function refresh()
    {
        $id = $this->tokenInfo->id;
        return $this->generate($id);
    }

    public function isNeedToRefresh()
    {
        $now = Carbon::now()->timestamp;
        $rfa = $this->tokenInfo->rfa;

        return $rfa < $now;
    }

    public function parseToken()
    {
        $this->token = substr(request()->header('authorization'), 7);

        $this->tokenInfo = $this->decode($this->token);

        if ($this->tokenInfo) return true;
        else return false;
    }

    public function token()
    {
        return $this->token;
    }

    public function tokenInfo()
    {
        return $this->tokenInfo;
    }
}

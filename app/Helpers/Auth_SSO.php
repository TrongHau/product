<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use MiladRahimi\Jwt\Cryptography\Algorithms\Rsa\RS256Signer;
use MiladRahimi\Jwt\Cryptography\Algorithms\Rsa\RS256Verifier;
use MiladRahimi\Jwt\Cryptography\Keys\RsaPrivateKey;
use MiladRahimi\Jwt\Cryptography\Keys\RsaPublicKey;
use MiladRahimi\Jwt\Generator;
use MiladRahimi\Jwt\Parser;
use function PHPUnit\Framework\result;

class Auth_SSO
{
    public static function verifyToken($token)
    {
        try {
            $token = str_replace('Bearer ', '', $token);
            $publicKey = new RsaPublicKey(base_path('oauth-public.key'));
            $verifier = new RS256Verifier($publicKey);
            $parser = new Parser($verifier);
            $claims = $parser->parse($token);
            return true;
        }catch (\Exception $exception) {
            return false;
        }
    }
    public static function getUser($token, $bearer = false) {
        $url = env('DomainAuth').'/api/user';
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $bearer ? $token : 'Bearer '.$token,
        ])->timeout(30)->asForm()->get($url);
        if ($response->successful()) {
            return json_decode($response->body(), true);
        }
        return null;
    }
}

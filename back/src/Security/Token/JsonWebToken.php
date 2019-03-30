<?php
/**
 * Created by PhpStorm.
 * User: tymek
 * Date: 30.03.19
 * Time: 13:12
 */

namespace App\Security\Token;


use Firebase\JWT\JWT;

class JsonWebToken
{
    private $secretKey;
    private $serverName;

    const DEFAULT_LIVE_TIME = 750;

    /**
     * JsonWebToken constructor.
     * @param string $secretKey
     * @param string $serverName
     */
    public function __construct(string $secretKey, string $serverName)
    {
        $this->secretKey = $secretKey;
        $this->serverName = $serverName;
    }

    public function encode(string $tokenId, $data, int $expire = self::DEFAULT_LIVE_TIME, int $notBefore = 0)
    {
        $iat = time();
        $nbf = $iat + $notBefore;
        $exp = $nbf + $expire;

        $data = [
            'iat'  => $iat,
            'jti'  => $tokenId,
            'iss'  => $this->serverName,
            'nbf'  => $nbf,
            'exp'  => $exp,
            'data' => $data
        ];

        return JWT::encode(
            $data,
            $this->secretKey,
            'HS512'
        );
    }
}

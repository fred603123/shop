<?php

namespace App\Http\Controllers;

class JwtController extends Controller
{
    public const JWT_EXPIRE_TIME = 86400; //持續時間(一天 單位：秒

    /**
     * 將data進行base64加密
     *
     * @param json $data
     * @return string base64
     */
    private static function base64Url_Encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
         
    /**
     * 將data進行base64解密
     *
     * @param json $data
     * @return string base64
     */
    private static function base64Url_Decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    //產生JWT header
    private const JWT_HEADER = [
        'alg' => 'HS256',
        'typ' => 'JWT'
    ];

    /**
     * 將JWT的header和payload包成json並且進行base64加密後用 ”.“ 連接起來
     *
     * @param array $payload
     * @return string base64
     */
    private static function generateJwtData(array $payload)
    {
        return self::base64Url_Encode(json_encode(self::JWT_HEADER)) . '.' . self::base64Url_Encode(json_encode($payload));
    }

    /**
     * 取得signature
     *
     * @param String $jwtData
     * @return string base64
     */
    private static function signature(String $jwtData)
    {
        return self::base64Url_Encode(hash_hmac('sha256', $jwtData, env('APP_KEY'), true));
    }

    /**
     * 建立一個完整的JWT
     *
     * @param array $jwtPayload
     * @return string $jwt
     */
    public static function generateJwt(array $jwtPayload)
    {
        $jwtPayload['iat'] = time(); //發行時間
        $jwtData = self::generateJwtData($jwtPayload);
        $jwtSignature = self::signature($jwtData);
        $jwt = $jwtData . '.' . $jwtSignature;
        return $jwt;
    }

    /**
     * Undocumented function
     *
     * @param String $jwt
     * @return array $payload
     */
    public static function decodeJwtPayload(String $jwt)
    {
        $payload = explode('.', $jwt)[1];
        return json_decode(self::base64Url_Decode($payload));
    }

    /**
     * 驗證Jwt
     *
     * @param String $jwt
     * @return boolean
     */
    public static function verifyToken(String $jwt)
    {
        try {
            $jwtStringArray = explode('.', $jwt);
            $jwtData = implode('.', [$jwtStringArray[0], $jwtStringArray[1]]);
            $jwtSignature = $jwtStringArray[2];
            $serverSignature = self::signature($jwtData);

            if ($serverSignature !== $jwtSignature) {
                return false;
            }

            $jwtPayload = self::decodeJwtPayload($jwtData);
            if ($jwtPayload->iat + self::JWT_EXPIRE_TIME < time()) {
                return false;
            }
            return true;
        } catch (Throwable $th) {
            return false;
        }
    }
}


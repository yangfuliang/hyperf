<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class IndexController extends AbstractController
{
    public function index()
    {
        $privateKey = <<<EOD
-----BEGIN PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCjkzAyEyqztqQr
iiy2d2uVugcnUCCPOw7q+kSDdZ6AGbOAx42qbiZJgDmhNqiKOwnwXDJMRmlBALtt
a24w8X9R+tkpUYMhkBfkKLBi3MaU+nkzAONo4NBTSkXAusVw5xfl2e+zDyLp73FR
EL7L4TCruswQhgHwLguC6zZ/U1iRBOKHgHrx+cS6GZOo8VpJBXhobT/iOw2VmuYV
4XXDcVNPDpZNvZ8j9dLkdTGzgI4ISyH0MwdmOhbOYsbHIn2rZAGP5zJZXmkQNnGk
So3PEfhrSvjQZBIQsafxk0usCkqIUtNrSNzuCeev/GxqTM0UoVtC4aYlIQcCfXgw
2IigI937AgMBAAECggEBAI090dbbP/sP0PAbjoI72bTefcDPal3i4/23/iL5E9SO
3LVtGgE4vWyoAJsYxC0fz3QxV+kOv2G2jSBtLCesz4BtNsh7rtvzPP3wuGWVNw96
u95zfOmZfaj9r/88BrJ3iOYa6ePWRRJ0g4c5C1amas1OLVhzLgdC6wOvsE3/HLGS
gYIXYbxkxMmfkAUsgzOaIBGQCTsG6BmNiwfanRWK1CzdNfV4ZPeUhIDfk+33qAvi
s5Vwuh9WeGyUJZeTgLkbdxxJRqLcJKd+IzsdzIDnzcrzEjfdIk+zkYJJc3cJB1QV
SlHB70/uQaU1fUC8TRaDIjeFog9Ij5GhZz81CwAI3gECgYEA1a97AlPrgc9esJU/
Fp6mM3CC8Q4WyIH67MIZMJY6udQ//uKoQWQ9o7F06Bp1nGYeEV2yxyO+T4QFDbI0
F6+CyP/p0SfjWg+O3C/9d3YJwfZD8nzp0xNV+S+O86XYl+Ad3jFzY5X9uy0EgFhk
1tfTbDHbOWSS2fFzXcD9Mz9IgPsCgYEAw/dq2Mp384M34e3XyI2SZRf61aAfD/N3
a2YYsOEx57GjiMfTRCvS20oEoZtXvZtXdc3Gxna/1hjJY8gGgS2zNmISKsZ6qH5r
JFWX1ifdkoJupa71CTqhMfRiuwNIdvpbbUi5qTvm8cyLL1MxFzVKEJ8WkVrhDI/V
gCKBuDzVhwECgYBjbGOioKNaYb8gEEEraCPSmU4DlNea8Ydr85++0JeAcTZZhOJe
kqJvcJkBiZYhcA4bbGpLZ+EbpESpq7m7L4l9tjz3eUS6WbTR1G5tz/kYS1owEFjH
Qh7lc3BjA0500+1xvbZ/poFJPtfyU66PnBoeJFBpMtd1GnfgLnRhDNfSUwKBgFVV
VeeVMuqNBzaQlVg1nbv71zRTB3Owtx3DVZkgVtTnm6iiKzMSSj1HXADrXieoj0sz
Eg22BA88t+WFYp+5wMI7rmGGED9y3UDzLK0KqwdzWK85ImakazEPlDaPVWzJ1Cog
cwhol0ZPpYQ0G7pZcCkQvYkKI9mOgI/NduM9SlYBAoGACdQTNOMw3X4LakKo0+EN
NRHrGM5KGu5zVG3FuTA6DO4qJG2lVU0bM4whEwMBrNGiIOfWDQDLb25Y1TvKf+7O
KEW1cTxt1v9D62yfl7BQg40Dj5AUAu9cIPpV6JW0k2mwsPnPBD1ufhp1x7IjzEMN
u3AKgxORTzl10IV04BojN00=
-----END PRIVATE KEY-----
EOD;

        $publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAyKrSlmIcilAcZxiE8ujZ
04EVAYSKhNECxzu3dDpjGXyJZMVUssXNRIbW6x+1UGDoLq6MYHAtid49dgnjzUg5
leEIZn5AkNUZfkROnUOMLP1DTd2ssRBKIGC37c4sdRmnAnWo3iVvhSBxfGwq5gQo
g2K0ff5ozXaMrpOns2PsUlpjE9Ebw8sx+v8VwifD+j7g8rBV8dCwUOLMjRG4gba5
rB4xORAV6ZlB4vcQwQAEJ3EpdQO87W7gnaZNwlxq762feNRKt4zGgw1kjgBIIHH7
/Wd7wznaC8+FbIaFuH+8dI5ZmJ+L7u6Ew4pvI2mkDAZvWkXnw612fz1tu53tFmUR
Acntyo2XkaMOsPNr4Ul+lA8/tfCkpuRjM4WyHr9cisS52mCtTnfJWJaJKw0jWOqB
3cQQdz7b7p5oi3eNMey+GOmSfUUXHxD5anhLBOHt11FwKRP27kzbTBrWkPFOwIaZ
aCxzb6L0sbCgugD5L+GFfDhhVREKztdb+VZcRGupDMOo0TqdkDH+h1viba4MqKF4
YaLvXDQeNPy3JAJgx8Fi7cQZHc899qWdm4Ni8DbQFdLjHtnMNMYIoaD4WZkhw4dq
cBJkfCjrNNojLmJI0EfSSLqf31YsHjtmNn1Z8VD2rqczqteP4OxqF6EAoItEZf8c
83t9f6c8mkmmacnBl8bxYjkCAwEAAQ==
-----END PUBLIC KEY-----
EOD;

        $token = <<<EOD
eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImE3MDg3ZjE4MzkyZDMzZjlhODYxNjFmYjA5OTYxN2ZmN2MwMjBmYjY4M2M5YzgzODgyNDUzY2JhNjg5ZDM1NjAwNDQ2NWM5YzZjMDc1NGNkIn0.eyJhdWQiOiIxMSIsImp0aSI6ImE3MDg3ZjE4MzkyZDMzZjlhODYxNjFmYjA5OTYxN2ZmN2MwMjBmYjY4M2M5YzgzODgyNDUzY2JhNjg5ZDM1NjAwNDQ2NWM5YzZjMDc1NGNkIiwiaWF0IjoxNjUwMDcxMDM2LCJuYmYiOjE2NTAwNzEwMzYsImV4cCI6MTY1MDkzNTAzNiwic3ViIjoiMTU4Mzk3NTAwNDk4NTgwMyIsInNjb3BlcyI6W119.Qyw-Pg9cabDnZvfCXJd0-8Vh4MdBsZhvVrjahFnpG6ZTqmMmYwXpMpO3OR8XNn2eI5JfJwQ7GKxvmTqF89QpMgI4t1r_3-YbBVtLrMu4wQVeGIyCnfXP1qqT-V0SN9JA0MTqbNeeprc8UV6qaWqMGp7YC1NCyIoBNL1CpimpLkrx_Jv8GU5PJA5t9b6ZTkl8iPuPZ8XPzTqL6GF6Q6bQ-aXK4O0Yl8pv_tzM-Y0svBlrYzAhsB1uj15znQuTyC8vGsj9Dye_AwmDU5_6zAKiQNGpTGeHTYjCo49a4_bh37nqkKQt1FLaSANm706NIeRFhi1u2v8tcoMn5KHWD64HTCikiV4Bh8mD5o1gkMtnPr16uz6NdzMfngFQh0lDn5hJ_jKipgR_hceUZXAV-ixtVrlEKe1vZAcwNbMuAsuFzfoIYYDMceh-A9IzGz3IqHEaQ90q9Mld4GYj0QWlHklNU3fRrsqYxzG2cJDVNZD2UP4t59d0ZlNZ8wpH3zBSPuIldhvlxP3MY32955_38D22coGBO23AQ7vjssNJ3JbMc6ObjC14hnvLRUzzXDU76x5R9gX79_QdD-nIYi_OlvQKo5DOMK866BGPjh-F5pg0Soy0PY9YKkhXtI9SoUFB6JcWMTqipKNrqS8mQfA7LRJctFsg04rFkyNZHHquwTCTNT0
EOD;


        $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));

        /*
         NOTE: This will now be an object instead of an associative array. To get
         an associative array, you will need to cast it as such:
        */

        $decoded_array = (array) $decoded;
        echo "Decode:\n" . print_r($decoded_array, true) . "\n";
    }
    
}

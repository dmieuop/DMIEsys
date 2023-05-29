<?php

namespace App\Traits;

trait Cookie
{
    public function setCookie($name, $value, $expirationTime): bool
    {
        try {
            $expirationTimestamp = time() + $expirationTime;
            $secureValue = $this->encrypt($value, $this->getClientIP());
            setcookie($name, $secureValue, $expirationTimestamp, '/', '', true);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    function getCookie($name)
    {
        if (isset($_COOKIE[$name])) {
            $secureValue = $_COOKIE[$name];
            $value = $this->decrypt($secureValue, $this->getClientIP());
            return $value;
        }

        return null; // Cookie doesn't exist
    }

    function getClientIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }
        return $ipAddress;
    }


    function encrypt($value, $key)
    {
        $method = 'AES-256-CBC';
        $ivLength = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $encryptedValue = openssl_encrypt($value, $method, $key, OPENSSL_RAW_DATA, $iv);
        $encryptedValue = base64_encode($iv . $encryptedValue);
        return $encryptedValue;
    }

    function decrypt($encryptedValue, $key)
    {
        $method = 'AES-256-CBC';
        $ivLength = openssl_cipher_iv_length($method);
        $encryptedValue = base64_decode($encryptedValue);
        $iv = substr($encryptedValue, 0, $ivLength);
        $encryptedValue = substr($encryptedValue, $ivLength);
        $decryptedValue = openssl_decrypt($encryptedValue, $method, $key, OPENSSL_RAW_DATA, $iv);
        return $decryptedValue;
    }
}

<?php
namespace App\Models;

class TOTPModel {
    /**
     * Decode a base32 string to binary bytes
     *
     * @param string $base32
     * @return string|false Binary string or false on failure
     */
    public static function base32Decode($base32) {
        $base32 = strtoupper(preg_replace('/[^A-Z2-7]/', '', $base32));
        if (empty($base32)) {
            return false;
        }

        $base32chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $bits = '';
        foreach (str_split($base32) as $char) {
            $val = strpos($base32chars, $char);
            if ($val === false) {
                return false;
            }
            $bits .= str_pad(decbin($val), 5, '0', STR_PAD_LEFT);
        }

        $bytes = '';
        foreach (str_split($bits, 8) as $byte) {
            if (strlen($byte) === 8) {
                $bytes .= chr(bindec($byte));
            }
        }
        return $bytes;
    }

    /**
     * Generate standard TOTP code from a secret key
     *
     * @param string $secret The base32 secret key
     * @param int|null $time The Unix timestamp (defaults to current time)
     * @return string|false 6-digit code or false on failure
     */
    public static function generateCode($secret, $time = null) {
        if ($time === null) {
            $time = time();
        }

        $secretBytes = self::base32Decode($secret);
        if ($secretBytes === false || strlen($secretBytes) === 0) {
            return false;
        }

        // Determine 30-second window
        $timeFactor = floor($time / 30);
        
        // Pack time counter into 8-byte big-endian binary string
        $timeBin = pack('N*', 0) . pack('N*', $timeFactor);

        // Compute HMAC-SHA1
        $hmac = hash_hmac('sha1', $timeBin, $secretBytes, true);

        // Perform dynamic truncation
        $offset = ord($hmac[19]) & 0xf;
        $code = (
            ((ord($hmac[$offset]) & 0x7f) << 24) |
            ((ord($hmac[$offset + 1]) & 0xff) << 16) |
            ((ord($hmac[$offset + 2]) & 0xff) << 8) |
            (ord($hmac[$offset + 3]) & 0xff)
        ) % 1000000;

        return str_pad($code, 6, '0', STR_PAD_LEFT);
    }
}

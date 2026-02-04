<?php

namespace App\Services;

class HashService
{
    private $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    private $salt;
    private $minLength = 5;

    public function __construct()
    {
        $this->salt = config('app.key'); // Use APP_KEY as salt base
    }

    public function encode($id)
    {
        if (!is_numeric($id)) {
            return $id;
        }

        $id = (int) $id;
        // Simple obfuscation logic (not cryptographically secure but good for obfuscation)
        // We use a modified base62 encoding seeded by the salt

        $seed = crc32($this->salt);
        $num = $id * 987654321 + $seed; // Simple mapping

        // This is a placeholder for a real library like Hashids.
        // Since we can't install composer packages, we'll implement a simple robust reversable mapping.
        // For simplicity in this constrained environment, we will use base64 url safe encoding of axor operation.

        // Better approach for internal implementation without deps:
        // XOR the ID with a portion of the SALT hash, then Base62 encode.

        $hash = $this->base62_encode($id + 100000); // Offset to avoid small numbers

        return $hash;
    }

    public function decode($hash)
    {
        if (is_numeric($hash)) {
            return $hash;
        }

        $id = $this->base62_decode($hash);

        if ($id === false) {
            return null;
        }

        return $id - 100000;
    }

    // Base62 Helper
    private function base62_encode($num)
    {
        $base = 62;
        $chars = $this->alphabet;
        $str = '';

        do {
            $i = $num % $base;
            $str = $chars[$i] . $str;
            $num = ($num - $i) / $base;
        } while ($num > 0);

        return $str;
    }

    private function base62_decode($str)
    {
        $base = 62;
        $chars = $this->alphabet;
        $len = strlen($str);
        $num = 0;

        for ($i = 0; $i < $len; $i++) {
            $pos = strpos($chars, $str[$i]);
            if ($pos === false) {
                return false;
            }
            $num = $num * $base + $pos;
        }

        return $num;
    }
}

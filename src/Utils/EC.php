<?php

namespace Awuxtron\Web3\Utils;

use Exception;
use InvalidArgumentException;
use LogicException;

class EC
{
    /**
     * Recovers the account that signed the data.
     *
     * @param Hex|string $message
     * @param Hex|string $signature
     *
     * @throws Exception
     *
     * @return Hex
     */
    public static function recover(string|Hex $message, string|Hex $signature): Hex
    {
        if (!Hex::isValid($message, true)) {
            $message = Sha3::hash(sprintf("\x19Ethereum Signed Message:\n%s%s", strlen($message), $message));
        }

        $message = Hex::of($message ?? '');
        $signature = Hex::of($signature);

        $sign = [
            'r' => (string) $signature->slice(0, 32),
            's' => (string) $signature->slice(32, 32),
        ];

        $recId = ord((string) hex2bin($signature->slice(64, 1))) - 27;

        if ($recId !== ($recId & 1)) {
            throw new InvalidArgumentException('Invalid signature.');
        }

        $publicKey = (new \Elliptic\EC('secp256k1'))->recoverPubKey((string) $message, $sign, $recId);
        $result = Sha3::hash(substr((string) hex2bin($publicKey->encode('hex')), 1));

        if ($result == null) {
            throw new LogicException('Unable to recover this message.');
        }

        return $result->slice(12);
    }

    /**
     * @param Hex|string $message
     * @param Hex|string $signature
     * @param Hex|string $address
     *
     * @throws Exception
     *
     * @return bool
     */
    public static function verify(string|Hex $message, string|Hex $signature, string|Hex $address): bool
    {
        return static::recover($message, $signature)->isEqual($address);
    }
}

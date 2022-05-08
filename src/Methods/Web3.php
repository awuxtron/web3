<?php

namespace Awuxtron\Web3\Methods;

use Awuxtron\Web3\Methods\Web3\ClientVersion;
use Awuxtron\Web3\Methods\Web3\Sha3;
use Awuxtron\Web3\Utils\Hex;

/**
 * @property string $clientVersion Returns the current client version.
 *
 * @method ClientVersion clientVersion()                                                           Returns the current client version.
 * @method Sha3          sha3(Hex|string $data) Returns Keccak-256 (not the standardized SHA3-256) of the given data.
 */
class Web3 extends MethodNamespace
{
}

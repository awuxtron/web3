<?php

namespace Awuxtron\Web3\Methods;

use Awuxtron\Web3\Methods\Net\GetId;
use Awuxtron\Web3\Methods\Net\GetPeerCount;
use Awuxtron\Web3\Methods\Net\Id;
use Awuxtron\Web3\Methods\Net\IsListening;
use Awuxtron\Web3\Methods\Net\Listening;
use Awuxtron\Web3\Methods\Net\PeerCount;
use Awuxtron\Web3\Methods\Net\Version;
use Brick\Math\BigInteger;

/**
 * @property string     $getId        Returns the current network ID.
 * @property string     $version      Returns the current network ID.
 * @property BigInteger $getPeerCount Returns number of peers currently connected to the client.
 * @property BigInteger $peerCount    Returns number of peers currently connected to the client.
 * @property string     $id           Returns the current network ID.
 * @property bool       $isListening  Returns true if client is actively listening for network connections.
 * @property bool       $listening    Returns true if client is actively listening for network connections.
 *
 * @method GetId        getId()        Returns the current network ID.
 * @method Version      version()      Returns the current network ID.
 * @method GetPeerCount getPeerCount() Returns number of peers currently connected to the client.
 * @method PeerCount    peerCount()    Returns number of peers currently connected to the client.
 * @method Id           id()           Returns the current network ID.
 * @method IsListening  isListening()  Returns true if client is actively listening for network connections.
 * @method Listening    listening()    Returns true if client is actively listening for network connections.
 */
class Net extends MethodNamespace
{
}

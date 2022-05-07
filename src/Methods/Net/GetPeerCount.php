<?php

namespace Awuxtron\Web3\Methods\Net;

/**
 * @description Returns number of peers currently connected to the client.
 */
class GetPeerCount extends PeerCount
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'net_peerCount';
    }
}

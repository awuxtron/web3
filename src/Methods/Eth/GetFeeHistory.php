<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Transaction fee history Returns base fee per gas and transaction effective priority fee per gas history for the requested block range if available. The range between headBlock-4 and headBlock is guaranteed to be available while retrieving data from the pending block and older history are optional to support. For pre-EIP-1559 blocks the gas prices are returned as rewards and zeroes are returned for the base fee per gas.
 */
class GetFeeHistory extends FeeHistory
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'eth_feeHistory';
    }
}

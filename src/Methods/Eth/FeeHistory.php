<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Obj;

/**
 * @description Transaction fee history Returns base fee per gas and transaction effective priority fee per gas history for the requested block range if available. The range between headBlock-4 and headBlock is guaranteed to be available while retrieving data from the pending block and older history are optional to support. For pre-EIP-1559 blocks the gas prices are returned as rewards and zeroes are returned for the base fee per gas.
 */
class FeeHistory extends Method
{
    /**
     * Get the method result value.
     *
     * @return array<string, mixed>
     */
    public function value(): array
    {
        $structure = [
            'oldestBlock' => 'int',
            'baseFeePerGas' => 'int[]',
            'gasUsedRatio' => 'plain:float[]',
            'reward' => 'int[][]',
        ];

        return (new Obj($structure))->decode($this->raw());
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [
            'blockCount' => static::schema('int', description: 'Number of blocks in the requested range. Between 1 and 1024 blocks can be requested in a single query. Less than requested may be returned if not all blocks are available.'),
            'newestBlock' => static::schema('block', description: 'Highest number block of the requested range.'),
            'rewardPercentiles' => static::schema('plain:integer[]', description: 'A monotonically increasing list of percentile values to sample from each block’s effective priority fees per gas in ascending order, weighted by gas used. Example: [“0”, “25”, “50”, “75”, “100”] or [“0”, “0.5”, “1”, “1.5”, “3”, “80”].'),
        ];
    }
}

<?php

namespace Awuxtron\Web3\Methods;

use Awuxtron\Web3\Methods\Shh\AddToGroup;
use Awuxtron\Web3\Methods\Shh\GetFilterChanges;
use Awuxtron\Web3\Methods\Shh\GetMessages;
use Awuxtron\Web3\Methods\Shh\HasIdentity;
use Awuxtron\Web3\Methods\Shh\NewFilter;
use Awuxtron\Web3\Methods\Shh\NewGroup;
use Awuxtron\Web3\Methods\Shh\NewIdentity;
use Awuxtron\Web3\Methods\Shh\Post;
use Awuxtron\Web3\Methods\Shh\UninstallFilter;
use Awuxtron\Web3\Methods\Shh\Version;
use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;

/**
 * @property BigInteger $newFilter   Creates filter to notify, when client receives whisper message matching the filter options.
 * @property Hex        $newGroup
 * @property Hex        $newIdentity Creates new whisper identity in the client.
 * @property mixed      $version     Returns the current whisper protocol version.
 *
 * @method AddToGroup       addToGroup(Hex|string $identity)
 * @method GetFilterChanges getFilterChanges(mixed $id)       Polling method for whisper filters. Returns new messages since the last call of this method.
 * @method GetMessages      getMessages(mixed $id)            Get all messages matching a filter. Unlike shh_getFilterChanges this returns all messages.
 * @method HasIdentity      hasIdentity(Hex|string $identity) Checks if the client hold the private keys for a given identity.
 * @method NewFilter        newFilter(array $filter = [])     Creates filter to notify, when client receives whisper message matching the filter options.
 * @method NewGroup         newGroup()
 * @method NewIdentity      newIdentity()                     Creates new whisper identity in the client.
 * @method Post             post(array $whisper)              Sends a whisper message.
 * @method UninstallFilter  uninstallFilter(mixed $id)        Uninstalls a filter with given ID. Should always be called when watch is no longer needed.
 * @method Version          version()                         Returns the current whisper protocol version.
 */
class Shh extends MethodNamespace
{
}

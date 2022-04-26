<?php

namespace Awuxtron\Web3\Exceptions;

use Awuxtron\Web3\Providers\Provider;
use Exception;

/**
 * @template TProvider of Provider
 */
class ProviderException extends Exception
{
    /**
     * The provider instance.
     *
     * @var TProvider
     */
    protected Provider $provider;

    /**
     * Get the provider instance.
     *
     * @return TProvider
     */
    public function getProvider(): Provider
    {
        return $this->provider;
    }

    /**
     * Set the provider instance.
     *
     * @param TProvider $provider
     */
    public function setProvider(Provider $provider): static
    {
        $this->provider = $provider;

        return $this;
    }
}

<?php

namespace Awuxtron\Web3\Providers;

class InfuraProvider extends HttpProvider
{
    /**
     * Create a new HTTP provider instance.
     *
     * @param string       $projectId
     * @param array<mixed> $options
     */
    public function __construct(protected string $projectId, array $options = [])
    {
        if (!empty($options['secret']) && empty($options['auth'])) {
            $options['auth'] = ['', $options['secret']];
        }

        if (!empty($options['jwt'])) {
            $options['headers']['Authorization'] = 'Bearer ' . $options['jwt'];
        }

        parent::__construct($this->buildRpcUrl($projectId, $options), $options['guzzle'] ?? []);
    }

    /**
     * Create a new provider instance from array of options.
     *
     * @param array<mixed> $options
     *
     * @return static
     */
    public static function from(array $options): static
    {
        return new static($options['id'] ?? '', $options);
    }

    /**
     * Build the Infura rpc url.
     *
     * @param string       $projectId
     * @param array<mixed> $options
     *
     * @return string
     */
    protected function buildRpcUrl(string $projectId, array $options): string
    {
        $url = ($options['scheme'] ?? 'https') . '://';
        $url .= ($options['network'] ?? 'mainnet') . '.infura.io/';
        $url .= !empty($options['scheme']) && $options['scheme'] == 'wss' ? 'ws/' : '';
        $url .= ($options['version'] ?? 'v3') . '/' . $projectId;

        return $url;
    }
}

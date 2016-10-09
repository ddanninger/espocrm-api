<?php

namespace Drei\EspoCRM\Client;

use Drei\EspoCRM\Client\Authorization;

use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Client;

class EspoClient extends GuzzleClient {
    /**
     * {@inheritdoc}
     */
    public static function factory($config = []) {
        $required = ['url', 'username', 'token'];

        foreach ($required as $value) {
            if (!isset($config[$value]) || !$config[$value]) {
                throw new \InvalidArgumentException(sprintf('Argument "%s" is required.', $value));
            }
        }

        $url = $config['url'];
        $version = isset($config['version']) ? $config['version'] : 'v1';
        $url = rtrim($url,'/');

        static::validateUrl($url);

        
        $client = new Client([
            'base_url' => sprintf('%s/api/%s/', $url, $version),
            'defaults' => [
                'auth' => 'espo'
            ]
        ]);
        
        $client->getEmitter()->attach(new Authorization($config['username'],$config['token']));

        $contents    = file_get_contents(sprintf('%s/../Resources/config/%s/client.json', __DIR__, $version));
        $description = new Description(json_decode($contents, true));

        return new static($client, $description);
    }

    /**
     * @param string $url
     *
     * @throws \InvalidArgumentException
     */
    private static function validateUrl($url) {
        $url = filter_var($url, FILTER_SANITIZE_URL);

        if (!filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED) !== false) {
            throw new \InvalidArgumentException('Not a valid url - http://domain/');
        }
    }
}
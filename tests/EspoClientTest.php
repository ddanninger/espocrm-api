<?php

namespace EspoCRM\Api\Tests;

use EspoCRM\Api\Client\EspoClient;

class EspoClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $url
     * @param $username
     * @param $token
     *
     * @dataProvider provideConfigValues
     */
    public function testFactoryReturnsClient($url, $username, $token)
    {
        $config = [
            'url' => 'http://plus.dev/',
            'username' => 'admin',
            'token' => 'admin'
        ];
        
        $config = [
            'url' => $url,
            'username' => $username,
            'token' => $token
        ];

        $client = EspoClient::factory($config);
        $authOption = $client->getHttpClient()->getDefaultOption('auth');

        $this->assertInstanceOf('\\EspoCRM\\Api\\Client\\EspoClient', $client);
        $this->assertEquals('espo', $authOption);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFactoryReturnsExceptionOnNullArguments()
    {
        $config = [];

        EspoClient::factory($config);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFactoryReturnsExceptionOnBlankArguments()
    {
        $config = [
            'url'     => '',
            'username' => '',
            'token' => '',
        ];

        EspoClient::factory($config);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFactoryReturnsExceptionOnUrlSchemaMissing()
    {
        $config = [
            'url'     => 'www.example.com',
            'username' => 'notempty',
            'token' => 'notempty',
        ];

        EspoClient::factory($config);
    }

    public function provideConfigValues()
    {
        return [
            ['http://plus.dev/', 'admin', 'admin']
        ];
    }
}
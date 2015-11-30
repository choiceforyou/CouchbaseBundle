<?php

namespace Choiceforyou\CouchbaseBundle\Tests\DependencyInjection;

use Choiceforyou\CouchbaseBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getTestConfigTreeData
     */
    public function testConfigTree($options, $results)
    {
        $processor = new Processor();
        $configuration = new Configuration(array());
        $config = $processor->processConfiguration($configuration, array($options));

        $this->assertEquals($results, $config);
    }

    public function getTestConfigTreeData()
    {
        return array(
            // Empty config.
            array(
                array(
                ),
                array(
                    'connections' => array(),
                    'repositories' => array()
                ),
            ),
            // No specify host & port.
            array(
                array(
                    'connections' => array(
                        'conn1' => array(
                            'username' => 'user',
                            'password' => 'passw0rd',
                            'bucket'   => 'bucket1'
                        ),
                    ),
                ),
                array(
                    'connections' => array(
                        'conn1' => array(
                            'host'     => 'localhost',
                            'port'     => '8091',
                            'username' => 'user',
                            'password' => 'passw0rd',
                            'bucket'   => 'bucket1'
                        )
                    ),
                    'repositories' => array()
                ),
            ),
            // Specify everything
            array(
                array(
                    'connections' => array(
                        'conn1' => array(
                            'host'     => '10.0.0.4',
                            'port'     => '9191',
                            'username' => 'user',
                            'password' => 'passw0rd',
                            'bucket'   => 'bucket1'
                        )
                    )
                ),
                array(
                    'connections' => array(
                        'conn1' => array(
                            'host'     => '10.0.0.4',
                            'port'     => '9191',
                            'username' => 'user',
                            'password' => 'passw0rd',
                            'bucket'   => 'bucket1'
                        )
                    ),
                    'repositories' => array()
                ),
            ),
            // Specify everything with repositories
            array(
                array(
                    'connections' => array(
                        'conn1' => array(
                            'host'     => '10.0.0.4',
                            'port'     => '9191',
                            'username' => 'user',
                            'password' => 'passw0rd',
                            'bucket'   => 'bucket1'
                        )
                    ),
                    'repositories' => array(
                        'foo' => array(
                            'connection'    => 'conn1',
                        ),
                        'bar' => array(
                            'connection'      => 'conn1',
                            'serializer'      => 'bar_bundle.serializer',
                            'repositoryClass' => 'Acme\\Bundle\\BarBundle\\Repository\\BarRepository'
                        )
                    )
                ),
                array(
                    'connections' => array(
                        'conn1' => array(
                            'host'     => '10.0.0.4',
                            'port'     => '9191',
                            'username' => 'user',
                            'password' => 'passw0rd',
                            'bucket'   => 'bucket1'
                        )
                    ),
                    'repositories' => array(
                        'foo' => array(
                            'connection'      => 'conn1',
                            'serializer'      => 'jms_serializer',
                            'repositoryClass' => 'Choiceforyou\CouchbaseBundle\Repository\Repository'
                        ),
                        'bar' => array(
                            'connection'      => 'conn1',
                            'serializer'      => 'bar_bundle.serializer',
                            'repositoryClass' => 'Acme\\Bundle\\BarBundle\\Repository\\BarRepository'
                        )
                    )
                ),
            )
        );
    }
}

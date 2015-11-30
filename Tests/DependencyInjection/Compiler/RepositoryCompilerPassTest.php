<?php

namespace Choiceforyou\CouchbaseBundle\Tests\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Choiceforyou\CouchbaseBundle\DependencyInjection\Compiler\RepositoryCompilerPass;

class RepositoryCompilerPassTest extends CompilerPassTestCase
{
    public function testProcessHasBuiltAllServices()
    {
        $container = new ContainerBuilder();
        $container->setParameter('choiceforyou_couchbase.connections',  $this->getConnectionsParameters());
        $container->setParameter('choiceforyou_couchbase.repositories', $this->getRepositoriesParameters());

        $this->process($container);

        // Repository services
        $this->assertTrue($container->hasDefinition('choiceforyou_couchbase.repository.foo'));
        $def = $container->getDefinition('choiceforyou_couchbase.repository.foo');
        $this->assertEquals('Choiceforyou\CouchbaseBundle\Repository\Repository', $def->getClass());
        $this->assertEquals('choiceforyou_couchbase.document_manager.conn1', $def->getArgument(0));

        $this->assertTrue($container->hasDefinition('choiceforyou_couchbase.repository.bar'));
        $this->assertEquals('Vendor\\Bundle\\BarBundle\\epository\\BarRepository', $container->getDefinition('choiceforyou_couchbase.repository.bar')->getClass());
    }

    protected function process(ContainerBuilder $container)
    {
        parent::process($container);

        $pass = new RepositoryCompilerPass();
        $pass->process($container);
    }

    protected function getRepositoriesParameters()
    {
        return array(
            'foo' => array(
                'connection'    => 'conn1',
            ),
            'bar' => array(
                'connection'      => 'conn2',
                'serializer'      => 'bar_bundle.serializer',
                'repositoryClass' => 'Vendor\\Bundle\\BarBundle\\epository\\BarRepository',
            ),
        );
    }
}

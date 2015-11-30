<?php

namespace Choiceforyou\CouchbaseBundle\Tests\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Choiceforyou\CouchbaseBundle\DependencyInjection\Compiler\DocumentManagerCompilerPass;

class DocumentManagerCompilerPassTest extends CompilerPassTestCase
{
    public function testProcessHasBuiltAllServices()
    {
        $container = new ContainerBuilder();
        $container->setParameter('choiceforyou_couchbase.connections',  $this->getConnectionsParameters());

        $this->process($container);

        // DocumentManager services
        $this->assertTrue($container->hasDefinition('choiceforyou_couchbase.document_manager.conn1'));
        $this->assertTrue($container->hasDefinition('choiceforyou_couchbase.document_manager.conn2'));
    }

    protected function process(ContainerBuilder $container)
    {
        parent::process($container);

        $pass = new DocumentManagerCompilerPass();
        $pass->process($container);
    }
}

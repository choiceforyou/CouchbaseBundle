<?php

namespace Choiceforyou\CouchbaseBundle\Tests\DependencyInjection\Compiler;

use Choiceforyou\CouchbaseBundle\DependencyInjection\Compiler\AbstractCompilerPass;

class CompilerPass extends AbstractCompilerPass
{
    public function getServiceId($name)
    {
        return '';
    }

    public function getDefinition($name, array $params)
    {
        null;
    }
}

class AbstractCompilerPassTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->compiler = new CompilerPass();
    }

    /** @covers Choiceforyou\CouchbaseBundle\DependencyInjection\Compiler\AbstractCompilerPass::generateConnectionServiceId */
    public function testGenerateConnectionServiceId()
    {
        $serviceId = $this->compiler->generateConnectionServiceId('foo');
        $this->assertEquals('choiceforyou_couchbase.connection.foo', $serviceId);
    }

    /** @covers Choiceforyou\CouchbaseBundle\DependencyInjection\Compiler\AbstractCompilerPass::generateDocumentManagerServiceId */
    public function testGenerateDocumentManagerServiceId()
    {
        $serviceId = $this->compiler->generateDocumentManagerServiceId('foo');
        $this->assertEquals('choiceforyou_couchbase.document_manager.foo', $serviceId);
    }

    /** @covers Choiceforyou\CouchbaseBundle\DependencyInjection\Compiler\AbstractCompilerPass::generateRepositoryServiceId */
    public function testGenerateRepositoryServiceId()
    {
        $serviceId = $this->compiler->generateRepositoryServiceId('foo');
        $this->assertEquals('choiceforyou_couchbase.repository.foo', $serviceId);
    }
}

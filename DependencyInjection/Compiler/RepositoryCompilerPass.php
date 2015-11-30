<?php

namespace Choiceforyou\CouchbaseBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Create dynamically the choiceforyou_couchbase.repository.<connectionName> services using the configuration.
 */
class RepositoryCompilerPass extends AbstractCompilerPass implements CompilerPassInterface
{
    /** @{@inheritdoc} */
    protected function getParameterKey()
    {
        return 'choiceforyou_couchbase.repositories';
    }

    /** @{@inheritdoc} */
    public function getServiceId($name)
    {
        return $this->generateRepositoryServiceId($name);
    }

    /** @{@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getDefinition($name, array $params)
    {
        $serializerServiceId = isset($params['serializer'])? $params['serializer'] : null;
        $repositoryClass = isset($params['repositoryClass'])? $params['repositoryClass'] : 'Choiceforyou\CouchbaseBundle\Repository\Repository';

        $args = array(
            new Reference($this->generateDocumentManagerServiceId($params['connection'])),
            $serializerServiceId? new Reference($serializerServiceId):null
        );

        // Build definition
        $definition = new Definition($repositoryClass, $args);

        return $definition;
    }
}

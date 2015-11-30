<?php

namespace Choiceforyou\CouchbaseBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Choiceforyou\CouchbaseBundle\DependencyInjection\Compiler\CouchbaseCompilerPass;
use Choiceforyou\CouchbaseBundle\DependencyInjection\Compiler\ConnectionCompilerPass;
use Choiceforyou\CouchbaseBundle\DependencyInjection\Compiler\DocumentManagerCompilerPass;
use Choiceforyou\CouchbaseBundle\DependencyInjection\Compiler\RepositoryCompilerPass;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ChoiceforyouCouchbaseBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CouchbaseCompilerPass());
        $container->addCompilerPass(new ConnectionCompilerPass());
        $container->addCompilerPass(new DocumentManagerCompilerPass());
        $container->addCompilerPass(new RepositoryCompilerPass());
    }
}

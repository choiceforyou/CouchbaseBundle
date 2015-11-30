<?php

namespace Choiceforyou\CouchbaseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('choiceforyou_couchbase');

        $rootNode
            ->children()
                ->append($this->addConnectionNode())
            ->end()
            ->children()
                ->append($this->addRepositoryNode())
            ->end()
        ;
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        return $treeBuilder;
    }

    /**
     * {@inheritDoc}
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function addConnectionNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('connections');

        $node
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->scalarNode('host')
                        ->cannotBeEmpty()
                        ->defaultValue('localhost')
                    ->end()
                    ->scalarNode('port')
                        ->cannotBeEmpty()
                        ->defaultValue('8091')
                    ->end()
                    ->scalarNode('username')
                    ->end()
                    ->scalarNode('password')
                    ->end()
                    ->scalarNode('bucket')
                        ->isRequired()
                        ->cannotBeEmpty()
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }

    /**
     * {@inheritDoc}
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function addRepositoryNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('repositories');

        $node
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->scalarNode('connection')
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('serializer')
                        ->cannotBeEmpty()
                        ->defaultValue('jms_serializer')
                    ->end()
                    ->scalarNode('repositoryClass')
                        ->cannotBeEmpty()
                        ->defaultValue('Choiceforyou\CouchbaseBundle\Repository\Repository')
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}

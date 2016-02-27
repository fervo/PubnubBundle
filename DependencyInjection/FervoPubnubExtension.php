<?php

namespace Fervo\PubnubBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class FervoPubnubExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yml');

        $container->setParameter('fervo_pubnub.subscribe_key', $config['subscribe_key']);
        $container->setParameter('fervo_pubnub.publish_key', $config['publish_key']);
        $container->setParameter('fervo_pubnub.secret_key', $config['secret_key']);

        if (isset($config['uuid'])) {
            if ($config['uuid']['service']) {
                $container->setAlias('fervo_pubnub.uuid_provider', $config['uuid']['service']);
            } else {
                $def = $container->getDefinition('fervo_pubnub.property_path_uuid_provider');
                $def->replaceArgument(1, $config['uuid']['property_path']);
                $def->replaceArgument(2, $config['uuid']['unique_for_anonymous']);
                $container->setAlias('fervo_pubnub.uuid_provider', 'fervo_pubnub.property_path_uuid_provider');
            }

            $container->getDefinition('fervo_pubnub')
                ->addMethodCall('setUUID', [new Expression('service(\'fervo_pubnub.uuid_provider\').getSessionUUID()')])
            ;
        }
    }
}

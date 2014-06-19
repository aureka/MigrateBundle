<?php

namespace Aureka\MigrateBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AurekaMigrateExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);


        $connectorClass = $this->getConnectorClass($config['database']['connector']);
        $container->setParameter('aureka_migration.connection_class', $connectorClass);
        $container->setParameter('aureka_migration.migration_class', 'Aureka\MigrateBundle\Migrator\Migration');

        $container->setParameter('aureka_migration.host', $config['database']['host']);
        $container->setParameter('aureka_migration.user', $config['database']['user']);
        $container->setParameter('aureka_migration.password', $config['database']['password']);
        $container->setParameter('aureka_migration.database', $config['database']['database']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }


    private function getConnectorClass($connectorName)
    {
        switch($connectorName) {
            case 'mysqli':
                return 'Aureka\MigrateBundle\Service\Database\MysqliConnection';
        }
        throw new \Exception(sprintf('No connector defined for "%s"', $connectorName));
    }
}

<?php

namespace Aureka\MigrateBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Reference;

class MigratorPass implements CompilerPassInterface
{
    const MIGRATOR_INTERFACE = 'Aureka\MigrateBundle\Migrator\Migrator';
    const MIGRATOR_TAG       = 'aureka_migrate.migrator';

    public function process(ContainerBuilder $container)
    {
        $migrationDefinition = $container->getDefinition('aureka_migrate.migration');
        $migratorDefinitions = $container->findTaggedServiceIds(self::MIGRATOR_TAG);
        foreach (array_keys($migratorDefinitions) as $id) {
            $class =  $container->getDefinition($id)->getClass();
            if (!$this->implementsCorrectInterface($class, '')) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id, self::MIGRATOR_INTERFACE));
            }
            $migrationDefinition->addMethodCall('add', array(new Reference($id)));
        }
    }


    private function implementsCorrectInterface($class, $interface)
    {
        $refClass = new \ReflectionClass($class);
        return $refClass->implementsInterface(self::MIGRATOR_INTERFACE);
    }
}
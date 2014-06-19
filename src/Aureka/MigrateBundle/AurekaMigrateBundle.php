<?php

namespace Aureka\MigrateBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Aureka\MigrateBundle\DependencyInjection\Compiler\MigratorPass;


class AurekaMigrateBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MigratorPass());
    }
}

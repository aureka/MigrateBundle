<?php

namespace Aureka\MigrateBundle\Tests\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Aureka\MigrateBundle\Tests\Application\AppKernel;

class ServicesTest extends WebTestCase
{

    protected static function createKernel(array $options = array())
    {
        return new AppKernel('test', true);
    }


    /**
     * @test
     */
    public function itRegistersTheMigrationService()
    {
        $client = self::createClient();
        $container = $client->getKernel()->getContainer();

        $migration = $container->get('aureka_migrate.migration');

        $this->assertNotNull($migration);
        $this->assertInstanceOf('Aureka\MigrateBundle\Migrator\Migration', $migration);
    }
}

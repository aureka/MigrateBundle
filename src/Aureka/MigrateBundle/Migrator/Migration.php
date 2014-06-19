<?php

namespace Aureka\MigrateBundle\Migrator;

use Doctrine\Common\Persistence\ObjectManager;

class Migration
{

    private $migrators = [];


    public function add(Migrator $migrator)
    {
        $this->migrators[] = $migrator;
        return $this;
    }


    public function execute()
    {
        foreach ($this->migrators as $migrator) {
            $migrator->prepare()->migrate();
        }
        return $this;
    }
}

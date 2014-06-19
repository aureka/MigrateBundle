<?php

namespace Aureka\MigrateBundle\Migrator;

interface Migrator
{
    public function prepare();
    public function migrate();
}
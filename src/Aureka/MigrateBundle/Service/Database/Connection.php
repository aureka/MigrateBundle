<?php

namespace Aureka\MigrateBundle\Service\Database;

interface Connection
{
    public function execute($query);
    public function fetchAll($query);
    public function fetchOne($query);
}

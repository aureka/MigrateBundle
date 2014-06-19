MigrateBundle
=============
[![Build Status](https://travis-ci.org/aureka/MigrateBundle.png)](https://travis-ci.org/aureka/MigrateBundle)

Provides a little scaffolding for migrations.

## Configuration

1.- Add the bundle to your composer.json file and execute `composer update`.

```yaml
{
    "require": {
        "aureka/migrate-bundle": "*"
    }
}
```


2.- Modify your `AppKernel.php`

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Aureka\MigrateBundle\AurekaMigrateBundle(),
            );
        // ...
    }
}
```

3.- Configure your legacy database in `config.yml`

aureka_migrate:
    database:
        connector: 'mysqli'
        host: 'localhost'
        user: 'root'
        password: '123'
        database: 'my_database'


## Adding migrators

It is time for you to add your custom migrators. Declare each migrator as a service tagged by `aureka_migrate.migrator`.

```yml
services:
    your_migration_bundle.users_migrator:
            class: Your\MigrationBundle\Migrator\UsersMigrator
            arguments: ['@aureka_migrate.legacy_connection', '@doctrine.orm.entity_manager']
            tags:
                - { name: aureka_migrate.migrator }
```


A migrator could be something like this:

```php

use Doctrine\Common\Persistence\ObjectManager;

use Aureka\MigrateBundle\Migrator\Migrator,
    Aureka\MigrateBundle\Service\Database\Connection;

class UsersMigrator implements Migrator
{
    private $legacyConnection;
    private $om;

    public function __construct(Connection $legacyConnection, ObjectManager $om)
    {
        $this->legacyConnection = $legacyConnection;
        $this->om = $om;
    }

    public function prepare()
    {
        // Do whatever you need to prepare the migration, like cleaning the destination tables
        return $this;
    }

    public function migrate()
    {
        $users = $this->legacyConnection->fetchAll('SELECT * FROM users');
        foreach ($users as $legacy_user) {
            $user = new User;
            $user->name = $legacy_user['username'];
            // ...
            $this->om->persist($user);
        }
        $this->om->flush();
        return $this;
    }
```

## Running migrations

Now you can execute the following command:

```sh
php app/console aureka_migrate:migrate
```


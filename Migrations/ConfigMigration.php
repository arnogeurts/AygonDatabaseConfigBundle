<?php

namespace Aygon\DatabaseConfigBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Add a config item to the database
 * 
 * @author Arno Geurts
 */
abstract class ConfigMigration extends AbstractMigration
{    
    /**
     * Add SQL for adding a config item to the database
     * 
     * @param string $name
     * @param string $defaultValue 
     */
    protected function addConfig($name, $defaultValue = null) 
    {
        $this->addSQL("INSERT INTO config (name, default_value) VALUES ('" . mysql_real_escape_string($name) . "', '" . mysql_real_escape_string($defaultValue) . "')");
    }
    
    /**
     * Add SQL for removing a config item from the database
     * 
     * @param string $name 
     */
    protected function removeConfig($name) 
    {
        $this->addSQL("DELETE FROM config WHERE name = '" . mysql_real_escape_string($name) . "'");
    }
}

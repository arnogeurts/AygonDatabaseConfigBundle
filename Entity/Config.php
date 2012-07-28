<?php

namespace Aygon\DatabaseConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aygon\DatabaseConfigBundle\Entity\Config
 * 
 * @ORM\Table(name="config")
 * @ORM\Entity()
 */
class Config
{
    /**
     * @var integer $id    
     *  
     * @ORM\Column( name="id", type="integer" )
     * @ORM\Id
     * @ORM\GeneratedValue( strategy="AUTO" )
     */
    private $id;

    /**
     * @var string $name
     * 
     * @ORM\Column( name="name", type="string", length=255 )
     */
    private $name;

    /**
     * @var string $default_value
     * 
     * @ORM\Column( name="default_value", type="string", length=255, nullable=true )
     */
    private $default_value;

    /**
     * @var string $value
     * 
     * @ORM\Column( name="value", type="string", length=255, nullable=true )
     */
    private $value;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set default_value
     *
     * @param string $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        if ($this->getId()) {
            throw new \Exception('The default value of an existing parameter can not be changed');
        }
        
        $this->default_value = $defaultValue;
    }

    /**
     * Get default_value
     *
     * @return string 
     */
    public function getDefaultValue()
    {
        return $this->default_value;
    }

    /**
     * Set value
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * Get the working value of the config
     * 
     * @return string 
     */
    public function getWorkingValue()
    {
        if ( ! $this->getValue()) {
            return $this->getDefaultValue();
        }
        
        return $this->getValue();
    }
}
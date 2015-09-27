<?php

namespace Shawware\CodingChallenge\Model;

use Shawware\CodingChallenge\Util\Validator;
use Shawware\CodingChallenge\Persistence\PersistedEntity;

abstract class AbstractEntity extends PersistedEntity
{
    /**
     * This entity's name.
     * 
     * @var string
     */
    private $name;

    /**
     * Constructs a new entity based on the given information.
     * 
     * @param string $name
     */
    public function __construct($name)
    {
        $this->updateName($name);
    }

    /**
     * This entity's name.
     * 
     * @return string
     */
    public final function name()
    {
        return $this->name;
    }

    /**
     * Updates this entity's name.
     * 
     * @param string $name the new name
     */
    public final function updateName($name)
    {
        Validator::validateString($name, 'name');
        
        $this->name = $name;
    }
}
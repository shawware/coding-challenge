<?php

namespace Shawware\CodingChallenge\Model;

use Shawware\CodingChallenge\Util\Validator;
use Shawware\CodingChallenge\Model\Method;

/**
 * Models a particular challenge (puzzle).
 */
class Challenge
{
    /**
     * This challenge's name.
     * 
     * @var string
     */
    private $name;
    /**
     * This challenge's description.
     * 
     * @var string
     */
    private $description;
    /**
     * This name of the challenge's class.
     * 
     * @var string
     */
    private $className;
    /**
     * This challenge's method definition.
     * 
     * @var Method
     */
    private $method;

    /**
     * Constructs a new challenge based on the given information.
     * 
     * @param string $name
     * @param string $description
     * @param string $className
     * @param Method $method
     */
    public function __construct($name, $description, $className, Method $method)
    {
        Validator::validateString($name, 'name');
        Validator::validateString($description, 'description');
        Validator::validateString($className, 'class name');
        
        $this->name = $name;
        $this->description = $description;
        $this->className = $className;
        $this->method = $method;
    }

    /**
     * This challenge's name.
     * 
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * This challenge's description.
     * 
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * This challenge's class name.
     * 
     * @return string
     */
    public function className()
    {
        return $this->className;
    }

    /**
     * This challenge's method.
     * 
     * @return Method
     */
    public function method()
    {
        return $this->method;
    }

    /**
     * Converts this object to a human-readable string.
     */
    public function __toString()
    {
        $result = $this->name . ': ' . $this->className . '->' . $this->method;
        
        return $result;
    }
}
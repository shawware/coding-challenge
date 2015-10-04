<?php

namespace Shawware\CodingChallenge\Model;

use Shawware\CodingChallenge\Util\Validator;

/**
 * Models a particular challenge (puzzle).
 */
class Challenge extends AbstractEntity
{
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
     * This challenge's test cases.
     * 
     * @var array:TestCase
     */
    private $testCases;

    /**
     * Constructs a new challenge based on the given information.
     * 
     * @param string $name
     * @param string $description
     * @param string $className
     * @param Method $method
     * @param array $testCases
     */
    public function __construct($name, $description, $className, Method $method, $testCases)
    {
        parent::__construct($name);
        Validator::validateString($description, 'description');
        Validator::validateString($className, 'class name');
        Validator::validateTypedArray($testCases, 'Shawware\CodingChallenge\Model\TestCase', 'test cases');
        
        $this->name = $name;
        $this->description = $description;
        $this->className = $className;
        $this->method = $method;
        $this->testCases = $testCases;
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
     * This challenge's test cases.
     * 
     * @return array:TestCase
     */
    public function testCases()
    {
        return $this->testCases;
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
<?php

namespace Shawware\CodingChallenge\Model;

use Shawware\CodingChallenge\Util\Validator;

/**
 * Models a method in the context of a challenge.
 */
class Method extends AbstractEntity
{
    /**
     * The method's return type.
     * 
     * @var string
     */
    private $returnType;
    /**
     * The method's parameters.
     * 
     * @var array:Parameter
     */
    private $parameters;
    /**
     * A list of the method's constraint(s).
     * 
     * @var array:string
     */
    private $constraints;

    /**
     * Constructs a new method based on the given information.
     * 
     * @param string $name the new method's name
     * @param string $returnType the new method's return type
     * @param array $parameters the new method's parameters
     * @param array $constraints the new method's constraint(s)
     */
    public function __construct($name, $returnType, $parameters, $constraints)
    {
        parent::__construct($name);
        Validator::validateString($returnType, 'return type');
        Validator::validateTypedArray($parameters, 'Shawware\CodingChallenge\Model\Parameter', 'parameters');
        Validator::validateStringArray($constraints, 'constraints');
        
        $this->name = $name;
        $this->returnType = $returnType;
        $this->parameters = $parameters;
        $this->constraints = $constraints;
    }

    /**
     * This method's return type.
     * 
     * @return string
     */
    public function returnType()
    {
        return $this->returnType;
    }

    /**
     * This method's parameters.
     * 
     * @return array:Parameter
     */
    public function parameters()
    {
        return $this->parameters;
    }

    /**
     * This method's constraints.
     * 
     * @return array:string
     */
    public function constraints()
    {
        return $this->constraints;
    }

    /**
     * Converts this object to a human-readable string.
     */
    public function __toString()
    {
        $signature = $this->name . '(';
        $i = count($this->parameters);
        foreach ($this->parameters as $param) {
            $signature .= $param;
            $i--;
            if ($i > 0) {
                $signature .= ', ';
            }
        }
        $signature .= ')';
        $signature .= ' : ' . $this->returnType;
        
        return $signature;
    }
}
<?php

namespace Shawware\CodingChallenge\Model;

use Shawware\CodingChallenge\Util\Validator;

/**
 * Models a method's parameter in the context of a challenge.
 */
class Parameter extends AbstractEntity
{
    /**
     * Enumerate the scalar types supported by PHP.
     * 
     * @var array
     */
    private static $SCALARS = array(
            'bool',
            'int',
            'float',
            'string' 
    );
    
    /**
     * The parameter's type.
     * 
     * @var string
     */
    private $type;
    /**
     * A list of the parameter's constraint(s).
     * 
     * @var array:string
     */
    private $constraints;

    /**
     * Constructs a new parameter based on the given information.
     * 
     * @param string $name the new parameter's name
     * @param string $type the new parameter's return type
     * @param array:string $constraints the new parameter's constraint(s)
     */
    public function __construct($name, $type, $constraints)
    {
        parent::__construct($name);
        Validator::validateString($type, 'type');
        Validator::validateStringArray($constraints, 'constraints');
        
        $this->name = $name;
        $this->type = $type;
        $this->constraints = $constraints;
    }

    /**
     * This parameter's type.
     * 
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * This parameter's constraints.
     * 
     * @return array:string
     */
    public function constraints()
    {
        return $this->constraints;
    }

    /**
     * Whether this parameter is a scalar.
     * 
     * @return boolean
     */
    public function isScalar()
    {
        return in_array($this->type, self::$SCALARS);
    }

    /**
     * Converts this object to a human-readable string.
     */
    public function __toString()
    {
        $signature = $this->type . ' ' . $this->name;
        
        return $signature;
    }
}
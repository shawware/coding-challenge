<?php

namespace Shawware\CodingChallenge\Util;

use InvalidArgumentException;
use Prophecy\Exception\Doubler\ClassNotFoundException;

/**
 * A utility class with validation functions.
 */
class Validator
{

    /**
     * Validates that the given parameter is not null.
     * 
     * @param mixed $param the parameter to validate
     * @param string $name the name of the parameter
     * @throws InvalidArgumentException
     */
    public static function validateNotNull($param, $name)
    {
        if (is_null($param)) {
            throw new InvalidArgumentException($name . ' is null');
        }
    }

    /**
     * Validates that the given parameter is a boolean.
     * 
     * @param mixes $param the parameter to validate
     * @param string $name the name of the parameter
     * @throws InvalidArgumentException
     */
    public static function validateBoolean($param, $name)
    {
        if (!is_bool($param)) {
            throw new InvalidArgumentException($name . ' is not a boolean');
        }
    }

    /**
     * Validates the given string parameter is not empty.
     * 
     * @param string $param the parameter to validate
     * @param string $name the name of the parameter
     * @param string $mayBeEmpty whether the string may be empty (default: no)
     * @throws InvalidArgumentException
     */
    public static function validateString($param, $name, $mayBeEmpty = false)
    {
        self::validateNotNull($param, $name);
        if (!is_string($param)) {
            throw new InvalidArgumentException($name . ' is not a string: ' . $param);
        }
        if (!$mayBeEmpty && empty($param)) {
            throw new InvalidArgumentException($name . ' is an empty string: ' . $param);
        }
    }

    /**
     * Validates the given parameter is a non-null array.
     * 
     * @param array $param the parameter to validate
     * @param string $name the name of the parameter
     * @param boolean $mayBeEmpty whether the array can be empty
     * @throws InvalidArgumentException
     */
    public static function validateArray($param, $name, $mayBeEmpty = false)
    {
        self::validateNotNull($param, $name);
        if (!is_array($param)) {
            throw new InvalidArgumentException($name . ' is not an array');
        }
        if (!$mayBeEmpty && (count($param) == 0)) {
            throw new InvalidArgumentException($name . ' has no elements');
        }
    }

    /**
     * Validates the given array of strings is not-null and contains non-empty strings.
     * 
     * @param array $param the array parameter to validate
     * @param string $name the name of the array parameter
     * @param boolean $mayBeEmpty whether the array can be empty
     * @throws InvalidArgumentException
     */
    public static function validateStringArray($param, $name, $mayBeEmpty = false)
    {
        self::validateArray($param, $name, $mayBeEmpty);
        $numElements = count($param);
        for($i = 0; $i < $numElements; $i++) {
            self::validateString($param [$i], $name . '[' . $i . ']');
        }
    }

    /**
     * Validates the given array of strings is not-null and contains non-null elements of the given type.
     * 
     * @param array $param the array parameter to validate
     * @param string $type the type of the elements in the array
     * @param string $name the name of the array parameter
     * @param boolean $mayBeEmpty whether the array can be empty
     * @throws InvalidArgumentException
     */
    public static function validateTypedArray($param, $type, $name, $mayBeEmpty = false)
    {
        self::validateArray($param, $name, $mayBeEmpty);
        $numElements = count($param);
        for($i = 0; $i < $numElements; $i++) {
            $elt = $param [$i];
            $eltName = $name . '[' . $i . ']';
            self::validateNotNull($elt, $eltName);
            $actualType = gettype($elt);
            if ($actualType == 'object') {
                $actualType = get_class($elt);
            }
            if ($type !== $actualType) {
                throw new InvalidArgumentException($eltName . ' is not a ' . $type . ' found ' . $actualType);
            }
        }
    }
}

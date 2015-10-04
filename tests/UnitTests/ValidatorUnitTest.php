<?php

namespace Shawware\CodingChallenge\UnitTests;

require_once __DIR__ . '/../../vendor/autoload.php';

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use Shawware\CodingChallenge\Util\Validator;

/**
 * Unit Tests for Validator. Yes, this is probably overkill, but I needed a simple test to work on while I figured out how to integrate PHPUnit and Eclipse.
 */
class ValidatorUnitTest extends PHPUnit_Framework_TestCase
{

    /**
     * Exercises Validator->validateNotNull() @dataProvider nullFixture
     */
    public function testNotNull($param, $name, $valid)
    {
        try {
            Validator::validateNotNull($param, $name);
            $this->assertTrue($valid, __FUNCTION__ . ': no exception thrown when it should have been: ' . $name);
        }
        catch (InvalidArgumentException $e) {
            $this->assertFalse($valid, __FUNCTION__ . ': exception thrown when it should not have been: ' . $name . '. Exception is: ' . $e->getMessage());
        }
    }

    /**
     * The test data for testNotNull().
     * 
     * @return multitype:multitype:string boolean
     */
    public function nullFixture()
    {
        return array(
                array(
                        'okay',
                        'test 1',
                        true 
                ),
                array(
                        '',
                        'test 2',
                        true 
                ),
                array(
                        3,
                        'test 3',
                        true 
                ),
                array(
                        null,
                        'test 4',
                        false 
                ) 
        );
    }

    /**
     * Exercises Validator->validateBoolean() @dataProvider booleanFixture
     */
    public function testBoolean($param, $name, $valid)
    {
        try {
            Validator::validateBoolean($param, $name);
            $this->assertTrue($valid, __FUNCTION__ . ': no exception thrown when it should have been: ' . $name);
        }
        catch (InvalidArgumentException $e) {
            $this->assertFalse($valid, __FUNCTION__ . ': exception thrown when it should not have been: ' . $name . '. Exception is: ' . $e->getMessage());
        }
    }

    /**
     * The test data for testBoolean().
     * 
     * @return array:array:mixed
     */
    public function booleanFixture()
    {
        return array(
                array(
                        null,
                        'test 1',
                        false 
                ),
                array(
                        true,
                        'test 2',
                        true 
                ),
                array(
                        false,
                        'test 3',
                        true 
                ),
                array(
                        3,
                        'test 4',
                        false 
                ),
                array(
                        'fail',
                        'test 5',
                        false 
                ) 
        );
    }

    /**
     * Exercises Validator->validateString() @dataProvider stringFixture
     */
    public function testString($param, $name, $mayBeEmpty, $valid)
    {
        try {
            if (!$mayBeEmpty) {
                Validator::validateString($param, $name);
            }
            Validator::validateString($param, $name, $mayBeEmpty);
            $this->assertTrue($valid, __FUNCTION__ . ': no exception thrown when it should have been: ' . $name);
        }
        catch (InvalidArgumentException $e) {
            $this->assertFalse($valid, __FUNCTION__ . ': exception thrown when it should not have been: ' . $name . '. Exception is: ' . $e->getMessage());
        }
    }

    /**
     * The test data for testString().
     * 
     * @return multitype:multitype:string boolean boolean
     */
    public function stringFixture()
    {
        return array(
                array(
                        'okay',
                        'test 1a',
                        false,
                        true 
                ),
                array(
                        'okay',
                        'test 1b',
                        true,
                        true 
                ),
                array(
                        '',
                        'test 2a',
                        false,
                        false 
                ),
                array(
                        '',
                        'test 2b',
                        true,
                        true 
                ),
                array(
                        3,
                        'test 3a',
                        false,
                        false 
                ),
                array(
                        3,
                        'test 3b',
                        true,
                        false 
                ),
                array(
                        null,
                        'test 4a',
                        false,
                        false 
                ),
                array(
                        null,
                        'test 4b',
                        true,
                        false 
                ) 
        );
    }

    /**
     * Exercises Validator->validateArray() @dataProvider arrayFixture
     */
    public function testArray($param, $name, $mayBeEmpty, $valid)
    {
        try {
            Validator::validateArray($param, $name, $mayBeEmpty);
            $this->assertTrue($valid, __FUNCTION__ . ': no exception thrown when it should have been: ' . $name);
            if (!$mayBeEmpty) {
                Validator::validateArray($param, $name);
                $this->assertTrue($valid, __FUNCTION__ . ': no exception thrown when it should have been: ' . $name);
            }
        }
        catch (InvalidArgumentException $e) {
            $this->assertFalse($valid, __FUNCTION__ . ': exception thrown when it should not have been: ' . $name . '. Exception is: ' . $e->getMessage());
        }
    }

    /**
     * The test data for testArray().
     * 
     * @return multitype:multitype:NULL string boolean multitype:multitype: string boolean multitype:string boolean multitype:number string boolean multitype:string boolean \stdClass multitype:string boolean multitype:string number
     */
    public function arrayFixture()
    {
        return array(
                array(
                        null,
                        'test 1',
                        false,
                        false 
                ),
                array(
                        array(),
                        'test 2a',
                        false,
                        false 
                ),
                array(
                        array(),
                        'test 2b',
                        true,
                        true 
                ),
                array(
                        new \stdClass(),
                        'test 3',
                        false,
                        false 
                ),
                array(
                        'hello',
                        'test 4',
                        false,
                        false 
                ),
                array(
                        3,
                        'test 5',
                        false,
                        false 
                ),
                array(
                        array(
                                'hello',
                                3 
                        ),
                        'test 6a',
                        false,
                        true 
                ),
                array(
                        array(
                                'hello',
                                3 
                        ),
                        'test 6a',
                        true,
                        true 
                ) 
        );
    }

    /**
     * Exercises Validator->validateStringArray() @dataProvider stringArrayFixture
     */
    public function testStringArray($param, $name, $mayBeEmpty, $valid)
    {
        try {
            Validator::validateStringArray($param, $name, $mayBeEmpty);
            $this->assertTrue($valid, __FUNCTION__ . ': no exception thrown when it should have been: ' . $name);
        }
        catch (InvalidArgumentException $e) {
            $this->assertFalse($valid, __FUNCTION__ . ': exception thrown when it should not have been: ' . $name . '. Exception is: ' . $e->getMessage());
        }
    }

    /**
     * The test data for stringArrayFixture().
     * 
     * @return multitype:multitype:string boolean multitype:string multitype:string boolean multitype:string NULL multitype:string boolean multitype:string number multitype:string boolean multitype:string boolean
     */
    public function stringArrayFixture()
    {
        return array(
                array(
                        array(
                                'okay' 
                        ),
                        'test 1a',
                        false,
                        true 
                ),
                array(
                        array(
                                'okay' 
                        ),
                        'test 1b',
                        false,
                        true 
                ),
                array(
                        array(
                                'okay' 
                        ),
                        'test 2',
                        false,
                        true 
                ),
                array(
                        array(
                                'okay',
                                '' 
                        ),
                        'test 3',
                        false,
                        false 
                ),
                array(
                        array(
                                'okay',
                                null 
                        ),
                        'test 4',
                        false,
                        false 
                ),
                array(
                        array(
                                'okay',
                                'ok',
                                'nice',
                                'sweet' 
                        ),
                        'test 5a',
                        false,
                        true 
                ),
                array(
                        array(
                                'okay',
                                'ok',
                                'nice',
                                'sweet' 
                        ),
                        'test 5b',
                        true,
                        true 
                ),
                array(
                        array(
                                'okay',
                                'ok',
                                3,
                                'sweet' 
                        ),
                        'test 6',
                        false,
                        false 
                ),
                array(
                        array(
                                'okay',
                                'ok',
                                'nice',
                                true 
                        ),
                        'test 7',
                        false,
                        false 
                ) 
        );
    }

    /**
     * Exercises Validator->validateTypedArray() @dataProvider typedArrayFixture
     */
    public function testTypedArray($param, $type, $name, $mayBeEmpty, $valid)
    {
        try {
            Validator::validateTypedArray($param, $type, $name, $mayBeEmpty);
            $this->assertTrue($valid, __FUNCTION__ . ': no exception thrown when it should have been: ' . $name);
        }
        catch (InvalidArgumentException $e) {
            $this->assertFalse($valid, __FUNCTION__ . ': exception thrown when it should not have been: ' . $name . '. Exception is: ' . $e->getMessage());
        }
    }

    /**
     * The test data for typedArrayFixture().
     * 
     * @return multitype:multitype:string boolean multitype:string multitype:string boolean multitype:string NULL multitype:string boolean multitype:number multitype:string boolean multitype:\Shawware\CodingChallenge\Util\Validator
     */
    public function typedArrayFixture()
    {
        $v = new Validator();
        return array(
                array(
                        array(),
                        'string',
                        'test 1a',
                        false,
                        false 
                ),
                array(
                        array(),
                        'string',
                        'test 1b',
                        true,
                        true 
                ),
                array(
                        array(
                                '' 
                        ),
                        'string',
                        'test 2',
                        false,
                        true 
                ),
                array(
                        array(
                                'okay' 
                        ),
                        'string',
                        'test 3a',
                        false,
                        true 
                ),
                array(
                        array(
                                'okay' 
                        ),
                        'string',
                        'test 3b',
                        true,
                        true 
                ),
                array(
                        array(
                                'okay',
                                '' 
                        ),
                        'string',
                        'test 4',
                        false,
                        true 
                ),
                array(
                        array(
                                'okay',
                                null 
                        ),
                        'string',
                        'test 5',
                        false,
                        false 
                ),
                array(
                        array(
                                1,
                                2,
                                3 
                        ),
                        'string',
                        'test 6',
                        false,
                        false 
                ),
                array(
                        array(
                                1,
                                2,
                                3 
                        ),
                        'integer',
                        'test 7a',
                        false,
                        true 
                ),
                array(
                        array(
                                1,
                                2,
                                3 
                        ),
                        'integer',
                        'test 7b',
                        true,
                        true 
                ),
                array(
                        array(
                                $v 
                        ),
                        'Shawware\CodingChallenge\Util\Validator',
                        'test 8',
                        false,
                        true 
                ) 
        );
    }
}

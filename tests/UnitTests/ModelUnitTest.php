<?php

namespace Shawware\CodingChallenge\UnitTests;

require_once __DIR__ . '/../../vendor/autoload.php';

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use Shawware\CodingChallenge\Util\Validator;
use Shawware\CodingChallenge\Model\Parameter;
use Shawware\CodingChallenge\Model\Method;
use Shawware\CodingChallenge\Model\Challenge;
use Shawware\CodingChallenge\Model\TestCase;

/**
 * Unit Tests for the Model classes.
 */
class ModelUnitTest extends PHPUnit_Framework_TestCase
{

    /**
     * Exercise the Parameter constructor for invalid arguments. @dataProvider parameterFailureFixture
     * 
     * @param string $name the parameter name to test with
     * @param string $type the parameter name to test with
     * @param array $constraints the parameter constraints to test with
     */
    public function testParameterConstructionFailure($name, $type, $constraints)
    {
        try {
            $p = new Parameter($name, $type, $constraints);
            $this->fail('Construction succeeded when it should have failed');
        }
        catch (InvalidArgumentException $e) {
            // This is to be expected :)
        }
    }

    /**
     * The attributes are: name, type, constraints
     * 
     * @return multitype:multitype:
     */
    public function parameterFailureFixture()
    {
        $c1 = 'test is in range [0..50]';
        $c = array(
                $c1 
        );
        
        return array(
                array(
                        null,
                        'int',
                        null 
                ),
                array(
                        'test',
                        null,
                        null 
                ),
                array(
                        '',
                        null,
                        $c 
                ),
                array(
                        '',
                        '',
                        $c 
                ),
                array(
                        'test',
                        '',
                        $c 
                ),
                array(
                        '',
                        'int',
                        $c 
                ),
                array(
                        'test',
                        'int',
                        null 
                ),
                array(
                        'test',
                        'int',
                        array() 
                ),
                array(
                        'test',
                        'int',
                        $c1 
                ) 
        );
    }

    /**
     * Exercise the Parameter constructor for valid arguments. @dataProvider parameterSuccessFixture
     * 
     * @param string $name the parameter name to test with
     * @param string $type the parameter name to test with
     * @param array $constraints the parameter name to test with
     * @param boolean $isScalar whether the parameter is scalar
     * @param string $str the expected string representation
     */
    public function testSuccessfulParameterConstruction($name, $type, $constraints, $isScalar, $str)
    {
        try {
            $p = new Parameter($name, $type, $constraints);
            $this->assertEquals($name, $p->name(), 'mis-matched name');
            $this->assertEquals($type, $p->type(), 'mis-matched type');
            $actualConstraints = $p->constraints();
            $count = count($constraints);
            $this->assertCount($count, $actualConstraints, 'wrong number of contraints');
            for($i = 0; $i < $count; $i++) {
                $this->assertEquals($constraints [$i], $actualConstraints [$i], 'mismatched constraint: ' . $i);
            }
            $this->assertEquals($isScalar, $p->isScalar(), 'mis-matched scalar values');
            $this->assertEquals($str, $p->__toString(), 'mis-matched string representations');
        }
        catch (InvalidArgumentException $e) {
            $this->fail('Construction failed when it should have succeeded: ' . $e->getMessage());
        }
    }

    /**
     * The attributes are: name, type, constraints, is scalar, string representation
     * 
     * @return multitype:multitype:
     */
    public function parameterSuccessFixture()
    {
        $c1 = 'test is in range [0..50]';
        $c2 = 'test is a non-empty string';
        $c3 = 'test is a non-empty array of strings';
        $c4 = 'each element of test is a string of length 10';
        $c = array(
                $c1 
        );
        
        return array(
                array(
                        'test-1',
                        'int',
                        $c,
                        true,
                        'int test-1' 
                ),
                array(
                        'test-2',
                        'string',
                        array(
                                $c2 
                        ),
                        true,
                        'string test-2' 
                ),
                array(
                        'test-3',
                        'array',
                        array(
                                $c3,
                                $c4 
                        ),
                        false,
                        'array test-3' 
                ) 
        );
    }

    /**
     * Exercise the Method constructor for invalid arguments. @dataProvider methodFailureFixture
     * 
     * @param string $name the method name to test with
     * @param string $returnType the method return type to test with
     * @param array $parameters the method parameters to test with
     * @param array $constraints the method constraints to test with
     */
    public function testMethodConstructionFailure($name, $returnType, $parameters, $constraints)
    {
        try {
            $m = new Method($name, $returnType, $parameters, $constraints);
            $this->fail('Construction succeeded when it should have failed');
        }
        catch (InvalidArgumentException $e) {
            // This is to be expected :)
        }
    }

    /**
     * The attributes are: name, type, constraints
     * 
     * @return multitype:multitype:
     */
    public function methodFailureFixture()
    {
        $c1 = 'test is in range [0..50]';
        $c = array(
                $c1 
        );
        $p = new Parameter('test', 'int', $c);
        
        return array(
                array(
                        null,
                        null,
                        null,
                        null 
                ),
                array(
                        'test',
                        null,
                        null,
                        null 
                ),
                array(
                        null,
                        'int',
                        null,
                        null 
                ),
                array(
                        null,
                        null,
                        $p,
                        null 
                ),
                array(
                        null,
                        null,
                        null,
                        $c 
                ),
                array(
                        'test',
                        'int',
                        null,
                        null 
                ),
                array(
                        'test',
                        'int',
                        $p,
                        null 
                ),
                array(
                        'test',
                        'int',
                        $p,
                        array() 
                ),
                array(
                        'test',
                        'int',
                        array(),
                        $c 
                ),
                array(
                        'test',
                        'int',
                        $c,
                        $p 
                ),
                array(
                        'test',
                        'int',
                        $p,
                        $p 
                ) 
        );
    }

    /**
     * Exercise the Method constructor for valid arguments. @dataProvider methodSuccessFixture
     */
    public function testSuccessfulMethodConstruction($name, $returnType, $parameters, $constraints, $str)
    {
        try {
            $m = new Method($name, $returnType, $parameters, $constraints);
            $this->assertEquals($name, $m->name(), 'mis-matched name');
            $this->assertEquals($returnType, $m->returnType(), 'mis-matched return type');
            $actualConstraints = $m->constraints();
            $count = count($constraints);
            $this->assertCount($count, $actualConstraints, 'wrong number of contraints');
            for($i = 0; $i < $count; $i++) {
                $this->assertEquals($constraints [$i], $actualConstraints [$i], 'mismatched constraint: ' . $i);
            }
            $this->assertEquals($str, $m->__toString(), 'mis-matched string representations');
        }
        catch (InvalidArgumentException $e) {
            $this->fail('Construction failed when it should have succeeded: ' . $e . getMessage());
        }
    }

    /**
     * The attributes are: name, type, parameters, constraints, string representation
     * 
     * @return multitype:multitype:
     */
    public function methodSuccessFixture()
    {
        $c1 = 'test is in range [0..50]';
        $c2 = 'test is a non-empty string';
        $c3 = 'test is a non-empty array of strings';
        $c4 = 'each element of test is a string of length 10';
        $p1 = new Parameter('row', 'string', array(
                $c2 
        ));
        $p2 = new Parameter('col', 'int', array(
                $c1 
        ));
        
        return array(
                array(
                        'test-1',
                        'string',
                        array(
                                $p1 
                        ),
                        array(
                                $c2 
                        ),
                        'test-1(string row) : string' 
                ),
                array(
                        'test-2',
                        'string',
                        array(
                                $p1,
                                $p2 
                        ),
                        array(
                                $c1,
                                $c2 
                        ),
                        'test-2(string row, int col) : string' 
                ) 
        );
    }

    /**
     * Exercise the TestCase constructor for valid and invalid arguments. @dataProvider testCaseFixture
     */
    public function testTestCaseConstruction($isExample, $inputs, $expectedOutput, $explanation, $success, $str = null)
    {
        try {
            $tc = new TestCase($isExample, $inputs, $expectedOutput, $explanation);
            $this->assertTrue($success, 'Construction succeeded when it should have failed');
            $this->assertEquals($isExample, $tc->isExample(), 'mis-matched is example');
            $actualInputs = $tc->inputs();
            $count = count($inputs);
            $this->assertCount($count, $actualInputs);
            for($i = 0; $i < $count; $i++) {
                $this->assertEquals($inputs [$i], $actualInputs [$i], 'mismatched input: ' . $i);
            }
            $this->assertEquals($expectedOutput, $tc->expectedOutput(), 'mis-matched expected output');
            $this->assertEquals($explanation, $tc->explanation(), 'mis-matched explanation');
            $this->assertEquals($str, $tc->__toString(), 'mis-matched string representations');
        }
        catch (InvalidArgumentException $e) {
            $this->assertFalse($success, 'Construction failed when it should have succeeded');
        }
    }

    /**
     * The attributes are: is example, inputs, expected output, explanation, success, string representation
     * 
     * @return multitype
     */
    public function testCaseFixture()
    {
        $inputs = array(
                1,
                2,
                3 
        );
        $output = 7;
        $str = '(1, 2, 3) : 7';
        return array(
                array(
                        null,
                        null,
                        null,
                        null,
                        false 
                ),
                array(
                        false,
                        null,
                        null,
                        null,
                        false 
                ),
                array(
                        true,
                        null,
                        null,
                        null,
                        false 
                ),
                array(
                        false,
                        $inputs,
                        null,
                        null,
                        false 
                ),
                array(
                        true,
                        $inputs,
                        null,
                        null,
                        false 
                ),
                array(
                        false,
                        $inputs,
                        7,
                        null,
                        false 
                ),
                array(
                        true,
                        $inputs,
                        7,
                        null,
                        false 
                ),
                array(
                        false,
                        $inputs,
                        null,
                        '',
                        false 
                ),
                array(
                        true,
                        $inputs,
                        null,
                        '',
                        false 
                ),
                array(
                        false,
                        $inputs,
                        7,
                        '',
                        true,
                        $str 
                ),
                array(
                        true,
                        $inputs,
                        7,
                        'okay',
                        true,
                        $str 
                ) 
        );
    }

    /**
     * Exercise the Challenge constructor for valid and invalid arguments. @dataProvider challengeFixture
     * 
     * @param string $name the challenge name to test with
     * @param string $description the challenge's description to test with
     * @param string $className the challenge class name to test with
     * @param Method $method the challenge's method to test with
     * @param array $testCases the challenge's test cases
     * @param boolean $success whether construction should succeed
     * @param string $str the string representation (if successful)
     */
    public function testChallengeConstruction($name, $description, $className, Method $method, $testCases, $success, $str = null)
    {
        try {
            $c = new Challenge($name, $description, $className, $method, $testCases);
            $this->assertTrue($success, 'Construction succeeded when it should have failed');
            $this->assertEquals($name, $c->name(), 'mis-matched name');
            $this->assertEquals($description, $c->description(), 'mis-matched description');
            $this->assertEquals($className, $c->className(), 'mis-matched class name');
            $this->assertEquals($method->__toString(), $c->method()->__toString(), 'mis-matched method representations');
            $actualTestCases = $c->testCases();
            $count = count($testCases);
            $this->assertCount($count, $actualTestCases);
            for($i = 0; $i < $count; $i++) {
                $this->assertEquals($testCases [$i]->__toString(), $actualTestCases [$i]->__toString(), 'mismatched test case: ' . $i);
            }
            $this->assertEquals($str, $c->__toString(), 'mis-matched string representations');
        }
        catch (InvalidArgumentException $e) {
            $this->assertFalse($success, 'Construction failed when it should have succeeded');
        }
    }

    /**
     * The attributes are: name, description, class name, method, success
     * 
     * @return multitype:multitype:
     */
    public function challengeFixture()
    {
        $c1 = 'test-p is in range [0..50]';
        $c2 = 'test-m is in range [0.0..9.99]';
        $c = array(
                $c1 
        );
        $d = 'A description of a very tricky problem';
        $p = new Parameter('test-p', 'int', $c);
        $m = new Method('test-m', 'float', array(
                $p 
        ), array(
                $c2 
        ));
        $tc1 = new TestCase(true, array(
                1,
                2,
                3 
        ), 7);
        $tc2 = new TestCase(true, array(
                1,
                2,
                4 
        ), 8);
        $tc = array(
                $tc1,
                $tc2 
        );
        
        return array(
                array(
                        null,
                        null,
                        null,
                        $m,
                        null,
                        false 
                ),
                array(
                        'Boggle',
                        null,
                        null,
                        $m,
                        null,
                        false 
                ),
                array(
                        null,
                        $d,
                        null,
                        $m,
                        null,
                        false 
                ),
                array(
                        null,
                        null,
                        'BoggleTest',
                        $m,
                        null,
                        false 
                ),
                array(
                        null,
                        null,
                        null,
                        $m,
                        null,
                        false 
                ),
                array(
                        null,
                        null,
                        null,
                        $m,
                        $tc,
                        false 
                ),
                array(
                        'Boggle',
                        $d,
                        null,
                        $m,
                        null,
                        false 
                ),
                array(
                        'Boggle',
                        $d,
                        'BoggleTest',
                        $m,
                        $tc,
                        true,
                        'Boggle: BoggleTest->test-m(int test-p) : float' 
                ) 
        );
    }
}

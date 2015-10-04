<?php

namespace Shawware\CodingChallenge\Model;

use Shawware\CodingChallenge\Util\Validator;
use Symfony\Component\Config\Definition\Builder\ValidationBuilder;

/**
 * Models a method's test cases in the context of a challenge.
 */
class TestCase extends AbstractEntity
{
    /**
     * Whether this test case is an example, ie. shown to competitor.
     * 
     * @var boolean
     */
    private $isExample;
    /**
     * The inputs.
     * 
     * @var array
     */
    private $inputs;
    /**
     * The expected output for the given inputs.
     * 
     * @var mixed
     */
    private $expectedOutput;
    /**
     * An optional explanation for the exepcted output.
     * 
     * @var string
     */
    private $explanation;

    /**
     * Constructs a new test case.
     * 
     * @param boolean $isExample whether this test case is an example
     * @param array $inputs the inputs for this test case
     * @param mixed $expectedOutput the expected output
     * @param string $explanation optional explanation of the expected output
     */
    public function __construct($isExample, $inputs, $expectedOutput, $explanation = '')
    {
        parent::__construct('test case');
        Validator::validateBoolean($isExample, 'is example');
        Validator::validateArray($inputs, 'inputs');
        Validator::validateNotNull($expectedOutput, 'expected output');
        Validator::validateString($explanation, 'explanation', true);
        
        $this->isExample = $isExample;
        $this->inputs = $inputs;
        $this->expectedOutput = $expectedOutput;
        $this->explanation = $explanation;
    }

    /**
     * Whether this test case is an example.
     * 
     * @return boolean
     */
    public function isExample()
    {
        return $this->isExample;
    }

    /**
     * The inputs to this test case.
     * 
     * @return multitype:
     */
    public function inputs()
    {
        return $this->inputs;
    }

    /**
     * The expected output.
     * 
     * @return mixed
     */
    public function expectedOutput()
    {
        return $this->expectedOutput;
    }

    /**
     * The optional explanation for this test case.
     * 
     * @return string
     */
    public function explanation()
    {
        return $this->explanation;
    }

    /**
     * Converts this object to a human-readable string.
     */
    public function __toString()
    {
        $str = '(' . implode(', ', $this->inputs) . ') : ' . $this->expectedOutput;
        
        return $str;
    }
}

<?php

namespace Shawware\CodingChallenge\UnitTests;

require_once __DIR__ . '/../../vendor/autoload.php';

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use Shawware\CodingChallenge\Util\Validator;
use Shawware\CodingChallenge\Model\Parameter;
use Shawware\CodingChallenge\Model\Method;
use Shawware\CodingChallenge\Model\Challenge;
use Shawware\CodingChallenge\Persistence\IEntityPersistence;
use Shawware\CodingChallenge\Persistence\PersistenceFactory;
use Shawware\CodingChallenge\Persistence\PersistenceException;

/**
 * Unit Tests for Serialisation persistence.
 */
class SerialisationUnitTest extends PHPUnit_Framework_TestCase
{
    /**
     * The store to use for all the tests.
     * 
     * @var IEntityPersistence
     */
    private static $store;
    
    /**
     * A test fixture.
     * 
     * @var Challenge
     */
    private $challenge;

    /**
     * Create the persistence store once to be used in all tests. (non-PHPdoc)
     * 
     * @see PHPUnit_Framework_TestCase::setUpBeforeClass()
     */
    public static function setUpBeforeClass()
    {
        self::$store = PersistenceFactory::getPersistenceStore();
    }

    /**
     * Create a challenge for use in the tests. (non-PHPdoc)
     * 
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        $p1 = new Parameter('test-1', 'string[]', array(
                'test-1 has a number of strings from [1..50]',
                'test-1 elements are all exactly 8 characters in length' 
        ));
        $m = new Method('test-m', 'int', array(
                $p1 
        ), array(
                'max memory is 100' 
        ));
        $this->challenge = new Challenge('Boggle', 'The Boggle test', 'BoggleTest', $m);
    }

    /**
     * Test the serialisation persistence store handles error conditions correctly.
     */
    public function testErrorConditions()
    {
        // Try and load an entity that does not exist.
        try {
            self::$store->load(1);
            $this->fail('Load succeeded where it should have failed.');
        }
        catch (InvalidArgumentException $e) {
            // This is to be expected.
        }
        
        // Try and delete an entity that does not exist.
        try {
            self::$store->delete(1);
            $this->fail('Delete succeeded where it should have failed.');
        }
        catch (InvalidArgumentException $e) {
            // This is to be expected.
        }
        
        // Try and update an entity without an ID (ie. not created yet).
        try {
            self::$store->update($this->challenge);
            $this->fail('Update succeeded where it should have failed.');
        }
        catch (InvalidArgumentException $e) {
            // This is to be expected.
        }
        
        // Try and update an entity that has not yet been created (even though it has an ID).
        $this->challenge->setID(1);
        try {
            self::$store->update($this->challenge);
            $this->fail('Update succeeded where it should have failed.');
        }
        catch (InvalidArgumentException $e) {
            // This is to be expected.
        }
    }

    /**
     * Exercise the store functions.
     */
    public function testStore()
    {
        // Store an entity.
        self::$store->create($this->challenge);
        
        // Load that entity back from store.
        $c2 = self::$store->load($this->challenge->id());
        $this->assertEquals($c2->id(), $this->challenge->id(), 'ID of loaded entity did not match saved entity');
        $this->assertEquals($c2->__toString(), $this->challenge->__toString(), 'Entity string representations did not match');
        
        // Modify the entity.
        $c2->updateName('Boggler');
        // Store the update.
        self::$store->update($c2);
        
        // Load the entity again.
        $c3 = self::$store->load($c2->id());
        $this->assertEquals($c3->id(), $c2->id(), 'ID of loaded entity did not match saved entity');
        $this->assertEquals($c3->name(), 'Boggler', 'Name of loaded entity did not match expected');
        $this->assertEquals($c3->__toString(), $c2->__toString(), 'Entity string representations did not match');
        
        // Delete the entity.
        self::$store->delete($c2->id());
    }
}
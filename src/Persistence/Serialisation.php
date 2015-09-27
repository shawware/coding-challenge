<?php

namespace Shawware\CodingChallenge\Persistence;

use Exception;
use InvalidArgumentException;
use Shawware\CodingChallenge\Util\Validator;

class Serialisation implements IEntityPersistence
{
    /**
     * Defines the name of the file where we store key data, eg. the next ID.
     * 
     * @var string
     */
    const LOCK_FILE = 'iep.lock';
    
    /**
     * The directory to persist data in.
     * 
     * @var string
     */
    private $dir;
    /**
     * The full path to the lock file (cached for performance).
     * 
     * @var string
     */
    private $lockFile;

    /**
     * Constructs a new serialisation-based persistence store in the given directory.
     * 
     * @param string $dir the name of the directory to use
     * @throws InvalidArgumentException the directory name is invalid
     */
    public function __construct($dir)
    {
        Validator::validateString($dir, 'directory');
        if (!is_dir($dir)) {
            throw new InvalidArgumentException('The given directory store is not a directory: ' . $dir);
        }
        $this->dir = $dir;
        $this->lockFile = $dir . '/' . self::LOCK_FILE;
    }

    /*
     * (non-PHPdoc) @see \Shawware\CodingChallenge\Persistence\IEntityPersistence::create()
     */
    public function create(PersistedEntity $entity)
    {
        $id = $this->getNextID();
        $entity->setId($id);
        $fp = $this->open($id, 'w');
        $this->store($fp, $entity);
        fclose($fp);
    }

    /*
     * (non-PHPdoc) @see \Shawware\CodingChallenge\Persistence\IEntityPersistence::load()
     */
    public function load($id)
    {
        $fp = $this->open($id, 'r');
        $str = fgets($fp);
        fclose($fp);
        if ($str === false) {
            throw new PersistenceException('error restoring entity: ' . $id);
        }
        $entity = unserialize($str);
        return $entity;
    }

    /*
     * (non-PHPdoc) @see \Shawware\CodingChallenge\Persistence\IEntityPersistence::update()
     */
    public function update(PersistedEntity $entity)
    {
        $id = $entity->id();
        if (!$id) {
            throw new InvalidArgumentException('entity to update does not have an ID');
        }
        if (!file_exists($this->getFilename($id))) {
            throw new InvalidArgumentException('entity does not exist: ' . $id);
        }
        $fp = $this->open($id, 'w');
        $this->store($fp, $entity);
        fclose($fp);
    }

    /*
     * (non-PHPdoc) @see \Shawware\CodingChallenge\Persistence\IEntityPersistence::delete()
     */
    public function delete($id)
    {
        $fileName = $this->getFilename($id);
        if (!file_exists($fileName)) {
            throw new InvalidArgumentException('entity does not exist: ' . $id);
        }
        if (!unlink($fileName)) {
            throw new PersistenceException('error deleting entity: ' . $id);
        }
    }

    /**
     * Opens the file for the given ID.
     * 
     * @param int $id the ID of the entity
     * @param string $mode the mode to open the file under
     * @throws PersistenceException error opening file
     * @return resource the open file
     */
    private function open($id, $mode)
    {
        try {
            if (($fp = fopen($this->getFilename($id), $mode)) === false) {
                throw new PersistenceException("unable to access entity: " . $id);
            }
            return $fp;
        }
        catch (Exception $e) {
            throw new InvalidArgumentException("unable to find entity: " . $id);
        }
    }

    /**
     * Stores the given entity in the given file.
     * 
     * @param resource $fp the file store in
     * @param PersistedEntity $entity the entity to store
     * @throws PersistenceException error storing entity in file
     */
    private function store($fp, $entity)
    {
        if (!fprintf($fp, "%s\n", serialize($entity))) {
            throw new PersistenceException("error storing entity: " . $entity->getID());
        }
    }

    /**
     * Gets a new unique ID for an entity.
     * 
     * @return int
     *
     * @throws PersistenceException error access the lock file
     */
    private function getNextID()
    {
        if (($fp = fopen($this->lockFile, "c+")) === false) {
            throw new PersistenceException("unable to open persistence lock file: " . $this->lockFile);
        }
        $id = 1;
        if (fscanf($fp, "%d\n", $id)) {
            $id++;
        }
        if (!rewind($fp) || !fprintf($fp, "%d\n", $id) || !fclose($fp)) {
            throw new PersistenceException("error processing persistence lock file: " . $this->lockFile);
        }
        return $id;
    }

    /**
     * Calculate a file name for the given ID.
     * 
     * @param int $id the ID to use
     */
    private function getFilename($id)
    {
        $fileName = $this->dir . '/' . $id . '.ser';
        
        return $fileName;
    }
}
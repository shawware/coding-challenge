<?php

namespace Shawware\CodingChallenge\Persistence;

/**
 * An abstract base class for entities to be persisted.
 */
abstract class PersistedEntity
{
    /**
     * Unique identifier for the entity.
     * 
     * @var int
     */
    private $id;

    /**
     * This entity's unqiue ID.
     * 
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Sets this entity's unique ID.
     * 
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
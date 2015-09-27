<?php

namespace Shawware\CodingChallenge\Persistence;

use InvalidArgumentException;

/**
 * Defines the persistence layer for entities.
 */
interface IEntityPersistence
{

    /**
     * Persists the given challenge.
     * 
     * @param PersistedEntity $entity the $entity to create
     * @throws InvalidArgumentException invalid argument, eg. entity name is already in use
     * @throws PersistenceException error in the persistence layer
     */
    public function create(PersistedEntity $entity);

    /**
     * Loads the entity identified by the given ID.
     * 
     * @param int $id the ID of the entity to load
     * @throws InvalidArgumentException invalid argument, eg. entity ID does not exist
     * @throws PersistenceException error in the persistence layer
     * @return PersistedEntity
     */
    public function load($id);

    /**
     * Updates the given entity.
     * 
     * @param PersistedEntity $entity the entity to update
     * @throws InvalidArgumentException invalid argument, eg. entity ID does not exist
     * @throws PersistenceException error in the persistence layer
     */
    public function update(PersistedEntity $entity);

    /**
     * Deletes the given entity.
     * 
     * @param int $id the entity to delete
     * @throws InvalidArgumentException invalid argument, eg. entity ID does not exist
     * @throws PersistenceException error in the persistence layer
     */
    public function delete($id);
}
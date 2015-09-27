<?php

namespace Shawware\CodingChallenge\Persistence;

/**
 * Factory for persistence instances.
 */
class PersistenceFactory
{

    /**
     * This class should not be instantiated.
     */
    private function __construct()
    {
        // Do nothing.
    }

    /**
     * Constructs and configures a persistence store.
     * 
     * @return IEntityPersistence
     */
    public static function getPersistenceStore()
    {
        // TODO: specify a config interface of some sort to:
        // (a) select the type of persistence
        // (b) configure the persistence
        return new Serialisation('/tmp/cc');
    }
}
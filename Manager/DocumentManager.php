<?php

namespace Choiceforyou\CouchbaseBundle\Manager;

use Choiceforyou\CouchbaseBundle\Entity\Document;
use Choiceforyou\CouchbaseBundle\Connection\ConnectionInterface;

/**
 * Get/Set/Delete Document objects through a connection to a Couchbase bucket.
 */
class DocumentManager
{
    /**
     * Connection to a couchbase bucket
     * @var Couchbase
     */
    protected $connection;

    /**
     * Constructor.
     *
     * @param Couchbase $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Get a Document by it's key.
     *
     * @param string $key
     *
     * @return Document
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function get($key)
    {
        $rawDocument = $this->connection->get($key);

        if (!$rawDocument) {
            return null;
        }

        return new Document($key, $rawDocument);
    }

    /**
     * Push a Document to Couchbase.
     *
     * @param Document $document
     */
    public function set(Document $document)
    {
        $this->connection->set($document->getKey(), $document->getValue());
    }

    /**
     * Delete a Document from Couchbase.
     *
     * @param Document $document
     */
    public function delete(Document $document)
    {
        $this->connection->delete($document->getKey());
    }

    /**
     * Return an array of Document from a Couchbase view.
     *
     * @see Couchbase::view
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function view($document, $view = '', $options = array(), $returnErrors = false)
    {
        $cbResults = $this->connection->view($document, $view, $options, $returnErrors);

        if (0 == $cbResults['total_rows']) {
            return array();
        }

        // Convert couchbase raw results to Document collection
        $func = function ($rawResult) {
            return new Document($rawResult['id'], $rawResult['value']);
        };

        return array_map($func, $cbResults['rows']);
    }
}

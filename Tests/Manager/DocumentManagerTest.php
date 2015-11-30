<?php

namespace Choiceforyou\CouchbaseBundle\Tests\Manager;

use Choiceforyou\CouchbaseBundle\Manager\DocumentManager;
use Choiceforyou\CouchbaseBundle\Tests\Connection\ConnectionMock;
use Choiceforyou\CouchbaseBundle\Entity\Document;

class DocumentManagerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->documents = array('key1' =>
            '{
                "k": "val"
            }'
        );

        $connection = new ConnectionMock($this->documents);
        $this->manager = new DocumentManager($connection);
    }

    /** covers Choiceforyou\CouchbaseBundle\Manager\DocumentManager::get */
    public function testGet()
    {
        $document = $this->manager->get('key1');

        $this->assertInstanceOf('Choiceforyou\CouchbaseBundle\Entity\Document', $document);
        $this->assertNull($this->manager->get('wrongKey'));
    }

    /** covers Choiceforyou\CouchbaseBundle\Manager\DocumentManager::set */
    public function testSet()
    {
        $doc = new Document('key3', array('value3'));
        $this->manager->set($doc);

        $this->assertEquals($doc, $this->manager->get('key3'));
    }

    /** covers Choiceforyou\CouchbaseBundle\Manager\DocumentManager::set */
    public function testDelete()
    {
        $doc = new Document('key1', array('value1'));
        $this->manager->delete($doc);

        $this->assertNull($this->manager->get('key1'));
    }
}

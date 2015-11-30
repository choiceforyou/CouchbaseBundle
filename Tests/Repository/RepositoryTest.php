<?php

namespace Choiceforyou\CouchbaseBundle\Tests\Repository;

use Choiceforyou\CouchbaseBundle\Repository\Repository;
use JMS\Serializer\SerializerBuilder;
use Choiceforyou\CouchbaseBundle\Serializer\Serializer;
use Choiceforyou\CouchbaseBundle\Tests\Connection\ConnectionMock;
use Choiceforyou\CouchbaseBundle\Entity\Document;
use Choiceforyou\CouchbaseBundle\Manager\DocumentManager;

class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @covers Choiceforyou\CouchbaseBundle\Repository\Repository::__construct */
    public function setUp()
    {
        $this->documents = array(
            'john-smith' => '
            {
                "name": "Smith",
                "firstname": "John"
            }
            '
        );

        $connection = new ConnectionMock($this->documents);
        $documentManager = new DocumentManager($connection);
        $jmsSerializer = SerializerBuilder::create()
            ->addMetadataDir(dirname(__FILE__))
            ->build()
        ;
        $serializer = new Serializer($jmsSerializer, 'Choiceforyou\CouchbaseBundle\Tests\Repository\FakeUserDocument');

        $this->repository = new Repository($documentManager, $serializer);
    }

    /** @covers Choiceforyou\CouchbaseBundle\Repository\Repository::findOneByKey */
    public function testFindOneByKeyWithNonExistentKey()
    {
        $doc = $this->repository->findOneByKey('not existent key');

        $this->assertNull($doc);
    }

    /** @covers Choiceforyou\CouchbaseBundle\Repository\Repository::findOneByKey */
    public function testFindOneByKey()
    {
        $doc = $this->repository->findOneByKey('john-smith');

        $this->assertInstanceOf('Choiceforyou\CouchbaseBundle\Tests\Repository\FakeUserDocument', $doc);
        $this->assertEquals('Smith', $doc->name);
        $this->assertEquals('John', $doc->firstname);
    }

    /** @covers Choiceforyou\CouchbaseBundle\Repository\Repository::getDocument */
    public function testGetDocumentWithDocument()
    {
        $doc = new Document();

        $this->assertSame($doc, $this->repository->getDocument($doc));
    }

    /** @covers Choiceforyou\CouchbaseBundle\Repository\Repository::getDocument */
    public function testGetDocumentWithDocumentInterface()
    {
        $entity = new FakeUserDocument('Paul','Anderson');

        $document = $this->repository->getDocument($entity);
        $this->assertInstanceOf('Choiceforyou\CouchbaseBundle\Entity\Document', $document);
        $this->assertEquals('paul-anderson', $document->getKey());
        $this->assertEquals('{"firstname":"Paul","name":"Anderson"}', $document->getValue());
    }

    /** @covers Choiceforyou\CouchbaseBundle\Repository\Repository::persist */
    public function testPersist()
    {
        $entity = new FakeUserDocument('Yolanda','Jenkins');

        $this->repository->persist($entity);
        $doc = $this->repository->findOneByKey('yolanda-jenkins');

        $this->assertEquals($entity, $doc);
    }
}

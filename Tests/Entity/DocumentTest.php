<?php

namespace Choiceforyou\CouchbaseBundle\Tests\Entity;

use Choiceforyou\CouchbaseBundle\Entity\Document;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Choiceforyou\CouchbaseBundle\Entity\Document::__construct()
     */
    public function testConstructor()
    {
        $doc = new Document('key', 'value');
        $this->assertEquals('key', $doc->getKey());
        $this->assertEquals('value', $doc->getValue());
    }
}

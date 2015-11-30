<?php

namespace Choiceforyou\CouchbaseBundle\Tests\Connection;

use Choiceforyou\CouchbaseBundle\Connection\Connection;

require_once 'Phake.php';
use \Phake;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    /** @covers Choiceforyou\CouchbaseBundle\Connection\Connection::__construct */
    public function setUp()
    {
        if (!extension_loaded('couchbase')) {
            $this->couchbase = $this->getMockBuilder('CouchbaseMock')
                ->setMockClassname('Couchbase')
                ->setMethods(array('get', 'set', 'delete', 'view'))
                ->getMock()
            ;
        }

        $this->couchbase = Phake::mock('Couchbase');
        $this->connection = new Connection($this->couchbase);
    }

    /** @covers Choiceforyou\CouchbaseBundle\Connection\Connection::get */
    public function testGet()
    {
        $this->connection->get('key');

        Phake::verify($this->couchbase)->get('key');
    }

    /** @covers Choiceforyou\CouchbaseBundle\Connection\Connection::set */
    public function testSet()
    {
        $this->connection->set('key', array('value'));

        Phake::verify($this->couchbase)->set('key', array('value'));
    }

    /** @covers Choiceforyou\CouchbaseBundle\Connection\Connection::delete */
    public function testDelete()
    {
        $this->connection->delete('key');

        Phake::verify($this->couchbase)->delete('key');
    }

    /** @covers Choiceforyou\CouchbaseBundle\Connection\Connection::view */
    public function testView()
    {
        $this->connection->view('designDocument', 'viewName', array('opt1' => 'val'), true);

        Phake::verify($this->couchbase)->view('designDocument', 'viewName', array('opt1' => 'val'), true);
    }
}

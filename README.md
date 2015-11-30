CouchbaseBundle
===============

Symfony2 bundle to manipulate Couchbase Documents.

[![Build Status](https://travis-ci.org/choiceforyou/CouchbaseBundle.png?branch=master)](https://travis-ci.org/choiceforyou/CouchbaseBundle) [![Build Status](https://travis-ci.org/choiceforyou/CouchbaseBundle.png?branch=develop)](https://travis-ci.org/choiceforyou/CouchbaseBundle) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/aed516f2-7cab-4fcb-a93a-e435a126a0a9/mini.png)](https://insight.sensiolabs.com/projects/aed516f2-7cab-4fcb-a93a-e435a126a0a9)

## Installation

Installing the bundle via packagist is the quickest and simplest method of installing the bundle. Here are the steps:

### Step 1: Composer require

    $ php composer.phar require "choiceforyou/couchbasebundle":"dev-master"

### Step 2: Enable the bundle in the kernel
```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Choiceforyou\CouchbaseBundle\ChoiceforyouCouchbaseBundle(),
        // ...
    );
}
```

## Configuration

There is a sample configuration file in Resources/config/couchbase.yml.dist

```yml
connections:
  conn1:
    # default is "localhost"
    # host:
    # default is 8091
    # port:
    username: admin
    password: admin
    bucket: default
  conn2:
    host: couchbase.tld
    port: 8092
    username: couchbase
    password: cOuchb4s3
    bucket: bucket2
```

## Services
A compiler pass will generate services according to the configuration file

```bash
php app/console container:debug | grep couchbase
```

| Service name        | Class           |
| ------------- | ------------- |
| choiceforyou_couchbase.conn1 | Couchbase |
| choiceforyou_couchbase.conn2 | Couchbase |

You can use choiceforyou_couchbase.\<connectionName\> services to manipulate you documents.

NB: documentation on other services will come soon.

## Usage

```php
<?php

namespace Acme\HelloBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class DocController
{
    public function getDocumentAction($key)
    {
        $couchbase = $this->get('choiceforyou_couchbase.conn1');
        
        // Get a doc from couchbase
        $doc = $couchbase->get($key);
        
        // Push a doc to couchbase
        $couchbase->set($key, $doc);
        
        // Delete a doc from couchbase
        $couchbase->delete($key);
        
        ...
    }
}
```

## TODO
  - add a profiling panel in the web debug toolbar : see the calls and the time they took
  - integrate Jms Serializer : manipulate Entities through Couchbase the same way as Doctrine EntityManager

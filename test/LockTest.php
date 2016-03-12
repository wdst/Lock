
<?php
require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../Lock.php';

class LockTest extends PHPUnit_Framework_TestCase {

    public function testLock()
    {
        $lockfile = '/tmp/lock.file';
        $lock = new wdst\lock\Lock($lockfile);
        $this->assertTrue($lock->lock(), "Don't lock");
    }

    public function testUnlock()
    {
        $lockfile = '/tmp/lock.file';
        $lock = new wdst\lock\Lock($lockfile);
        $this->assertTrue($lock->unlock(), "Don't unlock");
    }

    public function testIsLock()
    {
        $lockfile = '/tmp/lock.file';
        $lock = new wdst\lock\Lock($lockfile);
        $lock->lock();
        $this->assertTrue($lock->is_lock());
        $lock->unlock();
        $this->assertFalse($lock->is_lock());
    }

    public function testInfo()
    {
        $lockfile = '/tmp/lock.file';
        $lock = new wdst\lock\Lock($lockfile);
        $lock->lock();
        $this->assertTrue(strlen($lock->time()) > 0);
    }
    
    public function testTime()
    {
        $lockfile = '/tmp/lock.file';
        $lock = new wdst\lock\Lock($lockfile);
        $lock->lock();
        $this->assertTrue(date('d-m-Y H:i:s') === $lock->time());
    }
}
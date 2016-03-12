<?php

namespace wdst\lock;

Class Lock {

    private $lockfile;

    public function __construct($lockfile)
    {
        $this->lockfile = $lockfile;
        $this->check();
    }

    public function check()
    {
        if(!realpath(dirname($this->lockfile))){
            throw new LockException("Lockfile folder don't exists: " . $this->lockfile);
        }

        if(!is_writable(dirname($this->lockfile))){
            throw new LockException("Lockfile folder don't writable: " . $this->lockfile);
        }
    }

    public function is_lock()
    {
        return file_exists($this->lockfile);
    }

    public function lock()
    {
        $this->check();
        if(file_exists($this->lockfile) && !is_writable($this->lockfile)){
            throw new LockException("Lockfile don't writable: " . $this->lockfile);
            return false;
        }
        file_put_contents($this->lockfile, $this->getInfo());
        if(!file_exists($this->lockfile)){
            throw new LockException("Do not create lockfile: " . $this->lockfile);
            return false;
        }
        return true;
    }

    public function unlock()
    {
        if($this->is_lock()){
            unlink($this->lockfile);
        }
        return true;
    }

    public function time()
    {
        if($this->is_lock()){
            $info = file_get_contents($this->lockfile);
            return $info;
        }
        return false;
    }

    /**
     * Text for writing into lockfile
     * use date
     *
     * @return string
     */

    private function getInfo()
    {
        return date('d-m-Y H:i:s');
    }
}

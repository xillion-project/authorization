<?php

namespace Xillion\Authorization;

class Principal
{
    private $type;
    private $keys = array();
    
    public function __construct($type, $keys = array())
    {
        $this->type = $type;
        $this->keys = $keys;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    
    public function getKeys()
    {
        return $this->keys;
    }
    
    public function addKey($key)
    {
        $this->keys[] = $key;
        return $this;
    }
}

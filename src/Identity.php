<?php

namespace Xillion\Authorization;

class Identity
{
    private $type;
    private $key;
    
    public function __construct($type, $key)
    {
        $this->type = $type;
        $this->key = $key;
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
    
    public function getKey()
    {
        return $this->key;
    }
    
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }
    
    public function __toString()
    {
        return $this->type . '#' . $this->key;
    }
}

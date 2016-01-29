<?php

namespace Xillion\Authorization;

class Action
{
    private $service;
    private $name;
    
    public function __construct($service, $name = null)
    {
        if ($name) {
            $this->service = $service;
            $this->name = $name;
        } else {
            $part = explode(':', $service);
            $this->service = $part[0];
            $this->name = $part[1];
        }
    }
    
    public function getService()
    {
        return $this->service;
    }
    
    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function __toString()
    {
        return $this->service . ':' . $this->name;
    }
}

<?php

namespace Xillion\Authorization;

use Xillion\Core\Resource;

class Statement
{
    private $id;
    private $actions = array();
    private $resources = array();
    private $principal;
    private $effect = 'Allow';
    
    public function __construct()
    {
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    
    public function getEffect()
    {
        return $this->effect;
    }
    
    public function setEffect($effect)
    {
        $this->effect = $effect;
        return $this;
    }
    
    
    public function addAction(Action $action)
    {
        return $this->actions[] = $action;
    }
    
    public function getActions()
    {
        return $this->actions;
    }

    public function addResource(Resource $resource)
    {
        return $this->resources[] = $resource;
    }
    
    public function getResources()
    {
        return $this->resources;
    }
    
    public function setPrincipal(Principal $principal)
    {
        return $this->principal = $principal;
    }
    
    public function getPrincipal()
    {
        return $this->principal;
    }
}

<?php

namespace Xillion\Authorization;

class Policy
{
    private $id;
    private $statements;
    private $version = '2012-10-17';
    
    public function __construct()
    {
        $this->statements = array();
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
    
    
    public function addStatement(Statement $statement)
    {
        return $this->statements[] = $statement;
    }
    
    public function getStatements()
    {
        return $this->statements;
    }
    
    public function getVersion()
    {
        return $this->version;
    }
    
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }
    
}

<?php

namespace Xillion\Authorization;

use Xillion\Core\Resource;

class Context
{
    private $resourcePolicies = array();
    public function addResourcePolicy(Resource $resource, Policy $policy)
    {
        if (!isset($this->resourcePolicies[(string)$resource])) {
            $this->resourcePolicies[(string)$resource] = array();
        }
        $this->resourcePolicies[(string)$resource][] = $policy;
    }
    
    private $identityPolicies = array();
    public function addIdentityPolicy(Identity $identity, Policy $policy)
    {
        if (!isset($this->identityPolicies[(string)$identity])) {
            $this->identityPolicies[(string)$identity] = array();
        }
        $this->identityPolicies[(string)$identity][] = $policy;
    }
    
    public function getResourcePolicies(Resource $resource)
    {
        if (!isset($this->resourcePolicies[(string)$resource])) {
            return array();
        }
        return $this->resourcePolicies[(string)$resource];
    }
    
    public function getIdentityPolicies(Identity $identity)
    {
        if (!isset($this->identityPolicies[(string)$identity])) {
            return array();
        }
        return $this->identityPolicies[(string)$identity];
    }
    
    public function isAllowed(Identity $identity, Resource $resource, Action $action)
    {
        // First check identity based policies
        foreach ($this->getIdentityPolicies($identity) as $policy) {
            foreach ($policy->getStatements() as $statement) {
                if ($this->matchActions($action, $statement->getActions())) {
                    if ($this->matchResources($resource, $statement->getResources())) {
                        return true;
                    }
                }
            }
        }
        
        // Check resource based policies
        foreach ($this->getResourcePolicies($resource) as $policy) {
            foreach ($policy->getStatements() as $statement) {
                if ($this->matchActions($action, $statement->getActions())) {
                    if ($this->matchPrincipal($identity, $statement->getPrincipal())) {
                        return true;
                    }
                }
            }
        }
        
        return false;
    }
    
    public function matchString($string1, $string2)
    {
        if (fnmatch($string2, $string1)) {
            return true;
        }
        return false;
    }

    private function matchResources(Resource $resource1, $resources)
    {
        foreach ($resources as $resource2) {
            if ($this->matchResource($resource1, $resource2)) {
                return true;
            }
        }
        return false;
    }
    
    private function matchResource(Resource $resource1, Resource $resource2)
    {
        if (!$this->matchString($resource1->getPartition(), $resource2->getPartition())) {
            return false;
        }
        
        if (!$this->matchString($resource1->getService(), $resource2->getService())) {
            return false;
        }

        if (!$this->matchString($resource1->getRegion(), $resource2->getRegion())) {
            return false;
        }

        if (!$this->matchString($resource1->getAccount(), $resource2->getAccount())) {
            return false;
        }

        if (!$this->matchString($resource1->getResourceType(), $resource2->getResourceType())) {
            return false;
        }

        if (!$this->matchString($resource1->getResourceKey(), $resource2->getResourceKey())) {
            return false;
        }
        
        return true;
    }
    
    private function matchActions(Action $action1, $actions)
    {
        foreach ($actions as $action2) {
            if ($this->matchAction($action1, $action2)) {
                return true;
            }
        }
        return false;
    }
    
    private function matchAction(Action $action1, Action $action2)
    {
        if (!$this->matchString($action1->getService(), $action2->getService())) {
            return false;
        }

        if (!$this->matchString($action1->getName(), $action2->getName())) {
            return false;
        }
        
        return true;
    }
    
    private function matchPrincipal(Identity $identity, Principal $principal)
    {
        if (!$this->matchString($identity->getType(), $principal->getType())) {
            return false;
        }

        foreach ($principal->getKeys() as $key) {
            if ($this->matchString($identity->getKey(), $key)) {
                return true;
            }
        }
        
        return false;
    }
}

<?php

namespace Xillion\Authorization\PolicySerializer;

use Xillion\Authorization\Policy;

class JsonPolicySerializer
{
    public function serialize(Policy $policy)
    {
        $data = array();
        
        $data['Version'] = $policy->getVersion();
        $data['Statement'] = array();
        
        foreach ($policy->getStatements() as $statement) {
            $sData = array();
            if ($statement->getId()) {
                $sData['Sid'] = $statement->getId();
            }
            $sData['Effect'] = $statement->getEffect();
            $sData['Action'] = array();
            foreach ($statement->getActions() as $action) {
                $sData['Action'][] = (string)$action;
            }
            foreach ($statement->getResources() as $resource) {
                $sData['Resource'][] = (string)$resource;
            }
            
            $principal = $statement->getPrincipal();
            if ($principal) {
                $sData['Principal'] = array($principal->getType() => $principal->getKeys());
            }
            
            $data['Statement'][] = $sData;
        }
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}

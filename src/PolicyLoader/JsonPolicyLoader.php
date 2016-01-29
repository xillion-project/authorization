<?php

namespace Xillion\Authorization\PolicyLoader;

use Xillion\Core\Resource;
use Xillion\Authorization\Policy;
use Xillion\Authorization\Principal;
use Xillion\Authorization\Action;
use Xillion\Authorization\Statement;

class JsonPolicyLoader
{
    public function load($filename)
    {
        $json = file_get_contents($filename);
        $data = json_decode($json, true);
        
        $policy = new Policy();
        if (isset($data['Version'])) {
            $policy->setVersion($data['Version']);
        }
        foreach ($data['Statement'] as $sData) {
            $statement = new Statement();
            
            if (isset($sData['Sid'])) {
                $statement->setId($sData['Sid']);
            }
            $statement->setEffect($sData['Effect']);

            foreach ($sData['Action'] as $aData) {
                $action = new Action($aData);
                $statement->addAction($action);
            }

            if (isset($sData['Resource'])) {
                foreach ($sData['Resource'] as $rData) {
                    $resource = new Resource($rData);
                    $statement->addResource($resource);
                }
            }
            
            if (isset($sData['Principal'])) {
                $pData = $sData['Principal'];
                foreach ($pData as $key => $value) {
                    $principal = new Principal($key, $value);
                    $statement->setPrincipal($principal);
                }
            }
            

            $policy->addStatement($statement);
        }
        return $policy;
    }
}

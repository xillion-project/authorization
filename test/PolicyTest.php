<?php

namespace Xillion\Authorization;

use Xillion\Core\Resource;
use Xillion\Authorization\Principal;
use Xillion\Authorization\Action;
use Xillion\Authorization\PolicySerializer\JsonPolicySerializer;
use Xillion\Authorization\PolicyLoader\JsonPolicyLoader;

use PHPUnit_Framework_TestCase;

class PolicyTest extends PHPUnit_Framework_TestCase
{
    public function testPolicies()
    {
        $policy = new Policy();
        $statement = new Statement();

        $action = new Action('s3', 'Get*');
        $statement->addAction($action);
        
        $action = new Action('s3', 'List*');
        $statement->addAction($action);
        
        $resource = new Resource('xrn:aws:s3:eu-west-1::some-bucket');
        $statement->addResource($resource);
        
        $principal = new Principal('AWS');
        $principal->addKey('xrn:aws:iam::AWS-account-ID:user/bob');
        $principal->addKey('xrn:aws:iam::AWS-account-ID:user/alice');
        $statement->setPrincipal($principal);
        
        $policy->addStatement($statement);
        
        $serializer = new JsonPolicySerializer();
        $json = $serializer->serialize($policy);
        
        //echo $json;
    }
    
    
    public function testLoading()
    {
        $loader = new JsonPolicyLoader();
        $policy = $loader->load(__DIR__ . '/identity-policy1.json');
        $policy = $loader->load(__DIR__ . '/resource-policy1.json');
        //print_r($policy);
    }
    
    public function testIdentityPermissions()
    {
        $context = new Context();
        
        $identity = new Identity('AWS', 'xrn:aws:iam::AWS-account-ID:user/bob');
        $loader = new JsonPolicyLoader();
        $policy = $loader->load(__DIR__ . '/identity-policy1.json');
        $context->addIdentityPolicy($identity, $policy);

        $resource = new Resource('xrn:aws:s3:eu-west-1:12345:some-bucket');
        $action = new Action('s3', 'ListBucket');
        
        $this->assertTrue($context->isAllowed($identity, $resource, $action));
    }

    public function testResourcePermissions()
    {
        $context = new Context();
        
        $identity = new Identity('AWS', 'xrn:aws:iam::AWS-account-ID:user/bob');
        $resource = new Resource('xrn:aws:s3:eu-west-1:12345:some-bucket');

        $loader = new JsonPolicyLoader();
        $policy = $loader->load(__DIR__ . '/resource-policy1.json');
        $context->addResourcePolicy($resource, $policy);

        $action = new Action('s3', 'ListBucket');
        
        $this->assertTrue($context->isAllowed($identity, $resource, $action));
    }
}

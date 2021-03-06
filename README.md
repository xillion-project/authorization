# Xillion Authorization Policy Framework

<img src="https://s.yimg.com/ea/img/-/150604/cynic_1amv8id-1amv8jf.jpg" style="width: 100%" />

## What is Xillion Authorization?

Xillion Authorization is an Authorization Policy Framework based on Amazon's IAM and Resource policies.

It allows for decentralized, highly flexible security access control.

This is work in progress. See `test/` for examples of usage.

## Example usage:

```php
use Xillion\Core\Resource;
use Xillion\Authorization\Action;
use Xillion\Authorization\PolicySerializer\JsonPolicySerializer;
use Xillion\Authorization\PolicyLoader\JsonPolicyLoader;


// The authorization context keeps track of policies, and can perform authorization checks
$context = new Context();

// What action is going to be performed?
$action = new Action('s3', 'ListBucket');

// Who is going to perform the action?
$identity = new Identity('AWS', 'xrn:aws:iam::AWS-account-ID:user/bob');

// What resource is the action going to be performed on?
$resource = new Resource('xrn:aws:s3:eu-west-1:12345:some-bucket');


// Load policies from a file
$loader = new JsonPolicyLoader();
$policy = $loader->load(__DIR__ . '/resource-policy1.json');

// Add the loaded policy to the context
$context->addResourcePolicy($resource, $policy);

// Check if the identity is allowed to perform the action on the resource
if ($context->isAllowed($identity, $resource, $action))) {
    echo "Action is allowed on this resource by this identity";
} else {
    echo "Action is denied on this resource by this identity";
}
```

## License

MIT (see [LICENSE](LICENSE))

## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [linkorb.com/engineering](http://www.linkorb.com/engineering).

Btw, we're hiring!

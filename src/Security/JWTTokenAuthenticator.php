<?php


namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator as BaseAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTTokenAuthenticator extends BaseAuthenticator
{

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(
        JWTTokenManagerInterface $jwtManager,
        EventDispatcherInterface $dispatcher,
        TokenExtractorInterface $tokenExtractor,
        RequestStack $requestStack
    )
    {
        parent::__construct($jwtManager, $dispatcher, $tokenExtractor);
        $this->requestStack = $requestStack;
    }

    public function getTokenExtractor()
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request->get('token')) {
            return new JWTTokenExtractor('Bearer', 'Authorization');
        }

        return parent::getTokenExtractor();
    }
}
<?php


namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\Request;

class JWTTokenExtractor extends AuthorizationHeaderTokenExtractor
{

    public function __construct($prefix, $name)
    {
        parent::__construct($prefix, $name);
    }

    public function extract(Request $request)
    {
        return $request->get('token');
    }

}
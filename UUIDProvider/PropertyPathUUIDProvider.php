<?php

namespace Fervo\PubnubBundle\UUIDProvider;

use Pubnub\Pubnub;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
* 
*/
class PropertyPathUUIDProvider implements UUIDProviderInterface
{
    protected $propertyAccessor;
    protected $tokenStorage;
    protected $propertyPath;
    protected $uniqueForAnonymous = true;

    public function __construct(TokenStorageInterface $tokenStorage, $propertyPath, $uniqueForAnonymous = true)
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->tokenStorage = $tokenStorage;
        $this->propertyPath = $propertyPath;
        $this->uniqueForAnonymous = $uniqueForAnonymous;
    }

    public function getSessionUUID()
    {
        $token = $this->tokenStorage->getToken();

        if ($token->getUser() instanceOf UserInterface)
        {
            return $this->propertyAccessor->getValue($token->getUser(), $this->propertyPath);
        } elseif ($this->uniqueForAnonymous) {
            return Pubnub::uuid();
        } else {
            return (string)$token->getUser();
        }
    }
}

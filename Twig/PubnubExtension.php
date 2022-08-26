<?php

namespace Fervo\PubnubBundle\Twig;

use Fervo\PubnubBundle\UUIDProvider\UUIDProviderInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFunction;

class PubnubExtension extends AbstractExtension implements GlobalsInterface
{
    protected $subscribeKey;
    protected $publishKey;
    protected $uuidProvider;

    public function __construct($subscribeKey, $publishKey, UUIDProviderInterface $uuidProvider = null)
    {
        $this->subscribeKey = $subscribeKey;
        $this->publishKey = $publishKey;
        $this->uuidProvider = $uuidProvider;
    }

    public function uuid()
    {
        if ($this->uuidProvider) {
            return $this->uuidProvider->getSessionUUID();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('pubnub_uuid', array($this, 'uuid')),
        );
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals(): array
    {
        return [
            'pubnub_subscribe_key' => $this->subscribeKey,
            'pubnub_publish_key' => $this->publishKey,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pubnub';
    }
}

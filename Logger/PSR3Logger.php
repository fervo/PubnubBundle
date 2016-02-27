<?php

namespace Fervo\PubnubBundle\Logger;

use Pubnub\PubnubLoggerInterface;
use Psr\Log\LoggerInterface;

/**
* 
*/
class PSR3Logger implements PubnubLoggerInterface
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function debug($message)
    {
        $this->logger->debug($message);
    }
}

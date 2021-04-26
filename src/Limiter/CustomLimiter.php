<?php

namespace App\Limiter;

use Symfony\Component\HttpFoundation\RateLimiter\RequestRateLimiterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\RateLimiter\LimiterInterface;
use Symfony\Component\RateLimiter\RateLimit;
use Symfony\Component\RateLimiter\RateLimiterFactory;

class CustomLimiter implements RequestRateLimiterInterface
{
    /**
     * @var LimiterInterface
     */
    private $limiter;

    public function __construct(RateLimiterFactory $factory)
    {
        $this->limiter = $factory->create('a_unique_identifier');
    }

    public function consume(Request $request): RateLimit
    {
        return $this->limiter->consume();
    }

    public function reset(Request $request): void
    {
        $this->limiter->reset();
    }
}

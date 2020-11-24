<?php

declare(strict_types=1);

namespace Guidance\Tests\Base;

class RuntimeContainer
{
    public const DEVELOPMENT_ENVIRONMENT = 'development';
    public const STAGING_ENVIRONMENT     = 'staging';
    public const PRODUCTION_ENVIRONMENT  = 'production';

    /** @var \DI\Container */
    private static $di = null;

    /** @var \Guidance\Tests\Base\Actor\BaseAbstract */
    private static $actor = null;

    /** @var string */
    private static $suite = null;

    /** @var array */
    private static $options = null;

    /** @var string */
    private static $environment = null;

    /** @var string */
    private static $website = null;

    /** @var string */
    private static $country = null;

    // ########################################

    public static function setActor(\Guidance\Tests\Base\Actor\BaseAbstract $actor): void
    {
        self::$actor = $actor;
    }

    public static function getActor(): \Guidance\Tests\Base\Actor\BaseAbstract
    {
        return self::$actor;
    }

    // ########################################

    public static function setDi(\DI\Container $di): void
    {
        self::$di = $di;
    }

    public static function getDi(): \DI\Container
    {
        return self::$di;
    }

    // ########################################

    public static function setOptions(array $options): void
    {
        self::$options = $options;
    }

    public static function getOptions(): array
    {
        return self::$options;
    }

    // ########################################

    public static function setSuite(string $suite): void
    {
        self::$suite = $suite;
    }

    public static function getSuite(): string
    {
        return self::$suite;
    }

    // ########################################

    public static function setEnvironment(string $environment): void
    {
        $availableEnvironments = [self::DEVELOPMENT_ENVIRONMENT, self::STAGING_ENVIRONMENT, self::PRODUCTION_ENVIRONMENT];

        if ( ! in_array($environment, $availableEnvironments )) {
            throw new \LogicException("Environment '{$environment}' is not acceptable.");
        }

        self::$environment = $environment;
    }

    public static function getEnvironment(): string
    {
        if (is_null(self::$environment)) {
            throw new \LogicException("Environment is not set yet.");
        }

        return self::$environment;
    }

    // ########################################

    public static function setWebsite(string $website): void
    {
        self::$website = $website;
    }

    public static function getWebsite(): ? string
    {
        return self::$website;
    }

    // ########################################

    public static function setCountry(string $country): void
    {
        self::$country = $country;
    }

    public static function getCountry(): ? string
    {
        return self::$country;
    }

    // ########################################
}

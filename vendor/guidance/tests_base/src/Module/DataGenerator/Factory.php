<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\DataGenerator;

use \Guidance\Tests\Base\RuntimeContainer;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\ProjectConfig\Factory
     */
    private $projectConfigFactory = null;

    // ########################################

    public function create(string $country = null): \Guidance\Tests\Base\Module\DataGenerator
    {
        $projectConfig = $this->projectConfigFactory->create();

        if (is_null($country)) {

            $configRegions = $projectConfig->get('/website/' . RuntimeContainer::getWebsite() . '/country/');

            if (is_null(RuntimeContainer::getCountry())) {
                RuntimeContainer::setCountry(array_key_first($configRegions));
            }

            $country = \Guidance\Tests\Base\RuntimeContainer::getCountry();
        }

        try {
            $fakerLocale = $projectConfig->get('/website/' . RuntimeContainer::getWebsite() . '/country/' . $country . '/faker_locale/');

        } catch (\Throwable $e) {
            throw new \LogicException("Country {$country} not found in the config file.");
        }

        return $this->di->make(
            \Guidance\Tests\Base\Module\DataGenerator::class,
            [
                'faker' => \Faker\Factory::create($fakerLocale)
            ]
        );
    }

    // ########################################
}

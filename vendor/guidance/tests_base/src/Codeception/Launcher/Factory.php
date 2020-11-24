<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Codeception\Launcher;

use \Guidance\Tests\Base\RuntimeContainer;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\FoldersStructure
     */
    private $foldersStructure = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\FileSystem\File\Php\Factory
     */
    private $phpFileFactory = null;

    // ########################################

    public function create(string $configFilePath, string $suite, string $test = null, array $launchOptions = []): \Guidance\Tests\Base\Codeception\Launcher
    {
        $this->getStringValidator()->assertNotEmpty($configFilePath);
        $this->getStringValidator()->assertNotEmpty($suite);

        // ----------------------------------------
        RuntimeContainer::setEnvironment(basename($configFilePath, ".yml"));
        // ----------------------------------------
        RuntimeContainer::setSuite($suite);
        // ----------------------------------------

        $options = $this->mergeWithDefaultOptions($launchOptions);

        if (isset($options['website'])) {

            $configFilePath = str_replace(
                'codecept' . DIRECTORY_SEPARATOR,
                'codecept' . DIRECTORY_SEPARATOR . 'website' . DIRECTORY_SEPARATOR . $options['website'] . DIRECTORY_SEPARATOR,
                $configFilePath
            );

            $website = $options['website'];
            unset($options['website']);

        } else {
            $website = 'default';
        }

        // ----------------------------------------
        RuntimeContainer::setWebsite($website);
        // ----------------------------------------
        RuntimeContainer::setOptions($options);
        // ----------------------------------------

        return $this->di->make(
            \Guidance\Tests\Base\Codeception\Launcher::class,
            [
                'configFilePath' => $configFilePath,
                'suite'          => $suite,
                'test'           => $test
            ]
        );
    }

    // ########################################

    private function mergeWithDefaultOptions(array $launchOptions): array
    {
        $launchOptions = $this->formatOptions($launchOptions);

        $defaultParamsConfigFilePath = $this->foldersStructure->getProjectConfigsPath() . 'codecept'
            . DIRECTORY_SEPARATOR .  'default_options.php';

        $defaultParams = $this->phpFileFactory->create($defaultParamsConfigFilePath)->interpret();

        return array_merge($defaultParams[\Guidance\Tests\Base\RuntimeContainer::getEnvironment()], $launchOptions);
    }

    private function formatOptions(array $optionsFromInput): array
    {
        $i=0;
        $options = [];
        foreach ($optionsFromInput as $inputOption) {

            if ($inputOption[0] !== '-') {
                $i++;
                continue;

            } elseif (isset($optionsFromInput[$i+1]) && $optionsFromInput[$i+1][0] !== '-')  {

                $options[] = $inputOption . '=' . $optionsFromInput[$i+1];
            } else {
                $options[] = $inputOption;
            }
            $i++;
        }

        $result = [];
        foreach ($options as $option) {

            $option = ltrim($option, '--');

            if (strpos($option, "=") !== false) {

                $keyValuePair = explode('=', $option);
                $result[$keyValuePair[0]] = trim($keyValuePair[1], '"\'');
            } else {
                $result[$option] = true;
            }
        }
        return $result;
    }

    // ########################################
}

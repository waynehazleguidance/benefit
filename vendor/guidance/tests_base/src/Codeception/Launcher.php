<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Codeception;

class Launcher
{
    /** @var string */
    private static $configFilePath = null;

    /** @var bool */
    private $isCodeceptionConfigured = false;

    /** @var string */
    private $suite = null;

    /** @var string|null */
    private $test = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\FoldersStructure
     */
    private $foldersStructure = null;

    // ########################################

    public function __construct(string $configFilePath, string $suite, $test)
    {
        self::$configFilePath = $configFilePath;
        $this->suite          = $suite;
        $this->test           = $test;
    }

    // ########################################

    public static function getConfigFilePath()
    {
        return self::$configFilePath;
    }

    // ########################################

    public function prepareCodeception(): self
    {
        // Require Autoload
        require_once $this->foldersStructure->getProjectRootPath()
            . 'vendor'      . DIRECTORY_SEPARATOR
            . 'codeception' . DIRECTORY_SEPARATOR
            . 'codeception' . DIRECTORY_SEPARATOR
            . 'autoload.php';

        // Register Namespaces
        \Codeception\Util\Autoload::addNamespace(
            \Guidance\Tests\Base\ProjectInfo::NAMESPACE_PREFIX,
            $this->foldersStructure->getBaseRootPath() . 'src' . DIRECTORY_SEPARATOR
        );

        \Codeception\Util\Autoload::addNamespace(
            \Guidance\Tests\Base\ProjectInfo::CHILD_NAMESPACE_PREFIX,
            $this->foldersStructure->getProjectRootPath() . 'src' . DIRECTORY_SEPARATOR
        );

        try {
            // Load Config
            \Codeception\Configuration::config(self::$configFilePath);

        } catch (\Throwable $e) {
            throw new \LogicException($e->getMessage(), $e->getCode(), $e);
        }

        $this->isCodeceptionConfigured = true;

        return $this;
    }

    public function launch(): void
    {
        if ( ! $this->isCodeceptionConfigured) {
            throw new \LogicException("You need to prepare Codeception before launch.");
        }

        $options = \Guidance\Tests\Base\RuntimeContainer::getOptions();

        $options['groups'] = $this->getGroupOptions($options);
        $options['seed'] = isset($options['seed']) ? intval($options['seed']) : rand();

        $codecept = new \Codeception\Codecept($options);

        $settings = $this->getSettings($this->suite);

        $codecept->runSuite($settings, $this->suite, $this->test);

        $codecept->printResult();
    }

    // ########################################

    private function getGroupOptions(array &$options): array
    {
        $groupOptions = [];
        foreach ($options as $optionName => $optionValue) {

            if ($optionName === 'g' || $optionName === 'group') {
                $groupOptions[] = $optionValue;
                unset($options[$optionName]);
            }
        }
        return $groupOptions;
    }

    private function getSettings(string $suite): array
    {
        $environments = \Codeception\Configuration::suiteEnvironments($suite);

        $suiteSettings = $environments[\Guidance\Tests\Base\RuntimeContainer::getEnvironment()];

        $suiteSettings['path'] = $this->foldersStructure->getProjectRootPath()
            . 'src' . DIRECTORY_SEPARATOR . $suite . DIRECTORY_SEPARATOR;

        // Manually set namespace because Codeception does NOT understand if Actor class is set with namespace in config.yml
        $suiteSettings['namespace'] = \Guidance\Tests\Base\ProjectInfo::CHILD_NAMESPACE_PREFIX;

        return $suiteSettings;
    }

    // ########################################
}

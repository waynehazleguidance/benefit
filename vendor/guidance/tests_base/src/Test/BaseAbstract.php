<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Test;

abstract class BaseAbstract
{
    /** @var bool */
    private $isTestFailed = false;

    /** @var bool */
    private $isFirstTestMethodRan = false;

    /** @var \Guidance\Tests\Base\Test\Scenario\Describer\Factory */
    private $scenarioFactory = null;

    /** @var \Guidance\Tests\Base\Test\Describer */
    private $testDescriber = null;

    /** @var \Guidance\Tests\Base\Module\DataSetProvider\General */
    protected $dataSetProviderGeneral = null;

    /** @var \Guidance\Tests\Base\Module\DataSetProvider\Individual */
    protected $dataSetProviderIndividual = null;

    /** @var \Guidance\Tests\Base\Module\DataGenerator */
    protected $dataGenerator = null;

    /** @var \Guidance\Tests\Base\ProjectConfig */
    protected $projectConfig = null;

    //########################################

    public function __construct()
    {
        $di = \Guidance\Tests\Base\RuntimeContainer::getDi();

        $di->injectOn($this);

        $this->dataSetProviderIndividual = $di->get(\Guidance\Tests\Base\Module\DataSetProvider\Individual\Factory::class)->create($this);
        $this->dataSetProviderGeneral    = $di->get(\Guidance\Tests\Base\Module\DataSetProvider\General\Factory::class)->create();
        $this->dataGenerator             = $di->get(\Guidance\Tests\Base\Module\DataGenerator\Factory::class)->create();
        $this->testDescriber             = $di->get(\Guidance\Tests\Base\Test\Describer\Factory::class)->create($this);
        $this->projectConfig             = $di->get(\Guidance\Tests\Base\ProjectConfig\Factory::class)->create();
        $this->scenarioFactory           = $di->get(\Guidance\Tests\Base\Test\Scenario\Describer\Factory::class);
    }

    //########################################

    /** Own magic method */
    protected function _beforeClass(): void {}

    /** Own magic method */
    protected function _afterClass(): void {}

    /** Own magic method */
    protected function _beforeMethod(): void {}

    /** Own magic method */
    protected function _afterMethod(): void {}

    /** Own magic method */
    protected function _fail(): void {}

    // ########################################

    final protected function getActor()
    {
        return \Guidance\Tests\Base\RuntimeContainer::getActor();
    }

    final protected function getPage(string $pageObjectClass, $createNewPageObject = false)
    {
        $di = \Guidance\Tests\Base\RuntimeContainer::getDi();

        if ($di->has($pageObjectClass) && ! $createNewPageObject) {
            return $di->get($pageObjectClass);
        }

        $page = $di->make($pageObjectClass);
        $di->set($pageObjectClass, $page);
        return $page;
    }

    //########################################

    /** Codeception magic method */
    final public function _before(\Codeception\Scenario $scenario): void
    {
        /** @var string $currentTestMethod */
        $currentTestMethod = $this->scenarioFactory->create($scenario)->getCurrentTestMethod();

        /** @var string|null $firstTestMethod */
        $firstTestMethod = $this->testDescriber->getFirstMethod();

        /**
         *  Also check on $isFirstMethodRan field condition in case when first test method can be executed several times with dynamic @dataProvider annotation
         */
        if ($currentTestMethod === $firstTestMethod && ! $this->isFirstTestMethodRan) {

            $this->isFirstTestMethodRan = true;

            $this->_beforeClass();
        }

        $this->_beforeMethod();
    }

    /** Codeception magic method */
    final public function _after(\Codeception\Scenario $scenario): void
    {
        if ($this->isTestFailed) {
            return;
        }

        /** @var string $currentTestMethod */
        $currentTestMethod = $this->scenarioFactory->create($scenario)->getCurrentTestMethod();

        $this->_afterMethod();

        /** @var string|null $firstTestMethod */
        $lastTestMethod = $this->testDescriber->getLastMethod();

        if ($currentTestMethod === $lastTestMethod) {
            $this->_afterClass();
        }
    }

    /** Codeception magic method */
    final public function _failed(): void
    {
        $this->isTestFailed = true;
        $this->_fail();
    }

    //########################################
}

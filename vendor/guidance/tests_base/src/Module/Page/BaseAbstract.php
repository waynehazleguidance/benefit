<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\Page;

abstract class BaseAbstract
{
    /** @var string */
    protected $path = null;

    /** @var string */
    protected $title = null;

    /** @var \Guidance\Tests\Base\Module\DataGenerator */
    protected $dataGenerator = null;

    /** @var \Guidance\Tests\Base\Module\Page\Uimap */
    protected $uimap = null;

    // ########################################

    public function __construct()
    {
        $di = \Guidance\Tests\Base\RuntimeContainer::getDi();

        $di->injectOn($this);

        /** @var \Guidance\Tests\Base\Module\DataGenerator\Factory $dataGeneratorFactory */
        $dataGeneratorFactory = $di->make(\Guidance\Tests\Base\Module\DataGenerator\Factory::class);
        $this->dataGenerator = $dataGeneratorFactory->create();

        /** @var \Guidance\Tests\Base\Module\Page\Uimap\Factory $uimapFactory */
        $uimapFactory = $di->make(\Guidance\Tests\Base\Module\Page\Uimap\Factory::class);
        $this->uimap = $uimapFactory->create($this);

        $this->path  = $this->uimap->getPath();
        $this->title = $this->uimap->getTitle();
    }

    // ########################################

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    // ########################################

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    // ########################################

    /**
     *  Method provides selector from uimap configuration '.yml' file.
     */
    public function selector(string $key = null)
    {
        try {
            return $this->uimap->getSelector($key);
        } catch ( \Exception $e) {
            throw new \LogicException('Page Object "' . get_called_class() . '" doesn\'t have "' . $key . '" selector.');
        }
    }

    public function route(string $param = ''): self
    {
        $I = $this->getActor();
        
        $I->amOnPage($this->path . $param);

        // Loadable Component pattern implementation. You can add this method in any Trait for PO class.
        if (method_exists($this, 'waitForObjectPageLoad')) {
            $this->waitForObjectPageLoad();
        }

        if ( ! is_null($this->title)) {

            if (is_string($this->title)) {
                $I->see($this->title);
                return $this;
            }

            $i = 0;
            foreach ($this->title as $titleValue) {

                if ($I->tryToSee($titleValue)) {
                    break;
                }

                if (count($this->title) > $i++) {
                    throw new \RuntimeException('Can\'t find one of the Page titles on the routed page.');
                }
            }
        }
        return $this;
    }

    public function waitForObjectPageLoad()
    {
        $I = $this->getActor();

        $I->waitForPageLoad();
    }

    // ########################################

    protected function getActor()
    {
        return \Guidance\Tests\Base\RuntimeContainer::getActor();
    }
    
    // ########################################

    private function isRouteParamPresentInUrl(): bool
    {
        return preg_match('(%.+?%)', $this->path) == true;
    }

    // ########################################
}

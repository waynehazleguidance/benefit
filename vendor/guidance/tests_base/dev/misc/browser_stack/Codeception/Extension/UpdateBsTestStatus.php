<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Codeception\Extension;

class UpdateBsTestStatus extends BaseAbstract
{
    /**
     * @Inject
     * @var \Guidance\Tests\Base\Module\BrowserStack\Api
     */
    private $browserStackApi = null;

    /** @var bool */
    private $isTestFiled = false;

    /** @var array */
    public static $events = [
        \Codeception\Events::TEST_FAIL_PRINT    => 'setTestStatusAsFailed',
        \Codeception\Events::TEST_SUCCESS       => 'updateBsTestStatusOnSuccess',
        \Codeception\Events::RESULT_PRINT_AFTER => 'updateBsTestStatusOnFail'
    ];

    //########################################

    public function setTestStatusAsFailed(\Codeception\Event\FailEvent $e)
    {
        $this->isTestFiled = true;
    }

    public function updateBsTestStatusOnFail(\Codeception\Event\PrintResultEvent $e)
    {
        if ( ! $this->isTestFiled) {
            return;
        }

        $options = \Guidance\Tests\Base\RuntimeContainer::getOptions();

        if (isset($options['browserstack-driver']) && $options['browserstack-driver']) {

            /** var \PHPUnit\Framework\TestFailure[] $errors  */
            $errors = $e->getResult()->errors();

            $fullExceptionMessage = '';
            foreach ($errors as $error) {
                $fullExceptionMessage .= $error->exceptionMessage() . PHP_EOL;
            }

            $this->browserStackApi->markTestAsFailed($this->getLastSessionId(), $fullExceptionMessage);
        }
    }

    public function updateBsTestStatusOnSuccess(\Codeception\Event\TestEvent $e)
    {
        $options = \Guidance\Tests\Base\RuntimeContainer::getOptions();
        
        if (isset($options['browserstack-driver']) && $options['browserstack-driver']) {

            $this->browserStackApi->markTestAsPassed($this->getLastSessionId());
        }
    }

    //########################################
    
    private function getLastSessionId(): string 
    {
        $builds      = $this->browserStackApi->getBuilds();
        $lastBuildId = $builds[0]['automation_build']['hashed_id'];
        $sessions    = $this->browserStackApi->getSessions($lastBuildId);
        
        return $sessions[0]['automation_session']['hashed_id'];
    }

    //########################################
}
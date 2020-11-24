<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\BrowserStack;

use \Guidance\Tests\Base\Lib\System;

class Local
{
    /** @var string */
    private $credentialKey = null;

    /** @var array */
    private $bsLocalArgs = null;

    /** @var string  */
    private $pid = null;

    /** @var \Guidance\Tests\Base\Module\BrowserStack\Local\Binary */
    private $localBinary = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\DataManipulation\Json
     */
    private $json = null;

    // ########################################

    public function __construct(
        string $credentialKey,
        array $bsLocalArgs,
        \Guidance\Tests\Base\Module\BrowserStack\Local\Binary\Factory $localBinaryFactory
    ) {
        $this->credentialKey = $credentialKey;
        $this->bsLocalArgs   = $bsLocalArgs;
        $this->localBinary   = $localBinaryFactory->create();
    }

    // ########################################

    public function start(): void
    {
        if ( ! $this->localBinary->isFileExist()) {
            $this->localBinary->download();
        }

        $returnMessage = shell_exec($this->getStartCommand() . " 2>&1");

        if ( ! $returnMessage) {
            throw new \RuntimeException('Error while trying to execute Start Local command');
        }

        $data = $this->json->decode($returnMessage);

        if ($data["state"] != "connected") {
            throw new \RuntimeException($data['message']['message']);
        }

        $this->pid = $data['pid'];
    }

    public function stop(): void
    {
        shell_exec($this->getStopCommand());
        $this->pid = null;
    }

    public function isRunning(): bool
    {
        if (System::getOS() == System::OS_WIN) {

            $processes = explode("\n", shell_exec("tasklist.exe"));
            sort($processes);

            $localBrowserStackProcessName = $this->localBinary->getFile()->getFullName();

            foreach ($processes as $process) {

                if (strpos($process, $localBrowserStackProcessName) === false) {
                    continue;
                }

                if (is_null($this->pid)) {
                    preg_match("/(.*?)\s+(\d+).*$/", $process, $matches);
                    $this->pid = $matches[2];
                }
                return true;
            }
            return false;

        } else {

            $localBrowserStackProcessID = shell_exec('pgrep ' . $this->localBinary->getFile()->getFullName());

            if (is_null($this->pid) && ! is_null($localBrowserStackProcessID)) {
                $this->pid = trim($localBrowserStackProcessID);
            }

            return ! is_null($localBrowserStackProcessID);
        }
    }

    // ########################################

    private function getStartCommand()
    {
        $command = $this->getExecPrefix() . $this->localBinary->getFile()->getPath() . " -d start " . $this->credentialKey . ' ' . $this->formatStartArgs();
        return preg_replace('/\s+/S', " ", $command);
    }

    private function getStopCommand()
    {
        $localIdentifier = isset($this->bsLocalArgs['localIdentifier'])
            ? '-localIdentifier ' . $this->bsLocalArgs['localIdentifier']
            : '';

        $command = $this->getExecPrefix() . $this->localBinary->getFile()->getPath() . ' -d stop ' . $localIdentifier;
        return preg_replace('/\s+/S', " ", $command);
    }

    // ########################################

    private function formatStartArgs(): string
    {
        $lineArgs = '';

        foreach($this->bsLocalArgs as $key => $value)

            switch ($key) {
                case 'v'              : $lineArgs .= '-vvv';                    break;
                case 'force'          : $lineArgs .= '-force';                  break;
                case 'only'           : $lineArgs .= '-only';                   break;
                case 'onlyAutomate'   : $lineArgs .= '-onlyAutomate';           break;
                case 'forcelocal'     : $lineArgs .= '-forcelocal';             break;
                case 'localIdentifier': $lineArgs .= "-localIdentifier $value"; break;
                case 'proxyHost'      : $lineArgs .= "-proxyHost $value";       break;
                case 'proxyUser'      : $lineArgs .= "-proxyUser $value";       break;
                case 'proxyPass'      : $lineArgs .= "-proxyPass $value";       break;
                case 'forceproxy'     : $lineArgs .= '-forceproxy';             break;
                case 'hosts'          : $lineArgs .= $value;                    break;
                case 'f'              : $lineArgs .= "-f $value";               break;

                default:
                    $lineArgs .= strtolower($value) == "true" ? "-$key" : "-$key '$value'";
            }

        return $lineArgs;
    }

    private function getExecPrefix()
    {
        return System::getOS() == System::OS_WIN ? 'call ' : 'exec ';
    }

    // ########################################
}

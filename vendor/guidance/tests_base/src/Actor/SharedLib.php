<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Actor;

trait SharedLib
{
    /**
     * @return \Codeception\Scenario
     */
    abstract protected function getScenario();

// ########################################

    public function writeCase(string $description)
    {
        $maxLineLength = 100;
        $lines = preg_split('/\r\n|\r|\n/', $description);

        array_walk($lines, function (&$line) use ($maxLineLength) {

            $line = preg_replace('!\s+!', ' ', $line);

            $lineLength = strlen($line) + 1;

            $line = $lineLength < $maxLineLength
                ? '<case> ' . $line . str_repeat(' ', $maxLineLength - $lineLength) . '</>'
                : '<case>' . $line . '</>';
        });

        $description = implode(PHP_EOL, $lines);

        $consoleOutput = new \Codeception\Lib\Console\Output([]);

        $caseOutputStyle = new \Symfony\Component\Console\Formatter\OutputFormatterStyle(
            'yellow', 'blue', ['bold']
        );

        $consoleOutput->getFormatter()->setStyle('case', $caseOutputStyle);

        $divider = '<case>' . str_repeat('=', $maxLineLength) . '</>';

        $consoleOutput->writeln(PHP_EOL . PHP_EOL . $divider
            . PHP_EOL . $description
            . PHP_EOL . $divider . PHP_EOL
        );
    }

    //########################################
}

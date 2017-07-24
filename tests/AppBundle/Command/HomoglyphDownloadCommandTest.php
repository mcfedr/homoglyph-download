<?php

namespace Tests\AppBundle\Command;

use AppBundle\Command\HomoglyphDownloadCommand;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class HomoglyphDownloadCommandTest extends KernelTestCase
{
    public function testCommand()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new HomoglyphDownloadCommand(new Client(), self::$kernel->getContainer()->getParameter('default_url')));

        $command = $application->find('download');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),
        ));

        $output = $commandTester->getDisplay();
        eval("\$x = $output;");
        $this->assertInternalType('array', $x);
    }
}

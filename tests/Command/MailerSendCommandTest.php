<?php

namespace Tests\App\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use App\Command\MailerSendCommand;

class MailerSendCommandTest extends KernelTestCase
{
	public function testExecute()
	{
		$kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new MailerSendCommand());

        $command = $application->find('mailer:send');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName()
        ));

        $output = $commandTester->getDisplay();

        $this->assertContains('Success', $output);
	}
}
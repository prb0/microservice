<?php

namespace App\Command;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Command\Command;
use Monolog\Handler\StreamHandler;
use App\Entity\Message;
use Monolog\Logger;

class MailerSendCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected function configure()
    {
        $this
            ->setName('mailer:send')
            ->setDescription('Sending messages from db table')
            ->setHelp('This command sending messages from db table')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io             = new SymfonyStyle($input, $output);
        $logger         = new Logger('mail');
        $doctrine       = $this->container->get('doctrine');
        $repository     = $doctrine->getRepository(Message::class);
        $messages       = $repository->findAll();
        $entityManager  = $doctrine->getManager();

        $logger->pushHandler(new StreamHandler(__DIR__ . '/mail.log', Logger::INFO));

        foreach ($messages as $message) {
            $messenger = $message->getSubscriber()->getMessenger()->getName();
            $subscriberName = $message->getSubscriber()->getName();
            switch ($messenger) {
                case 'WhatsApp':
                    $this->sendMessageToWhatsApp();
                    break;

                case 'Viber':
                    $this->sendMessageToViber();
                    break;

                case 'Telegram':
                    $this->sendMessageToTelegram();
                    break;
                
                default:
                    throw new \Exception("Некорректное значение имени мессенджера.");
            }

            $logger->info("Сообщение пользователю '$subscriberName' отправлено в мессенджер $messenger");
            $entityManager->remove($message);
        }

        $entityManager->flush();

        $io->success('Success! you can watch logs in /src/Command/mail.log file');
    }

    private function sendMessageToWhatsApp() {}

    private function sendMessageToViber() {}

    private function sendMessageToTelegram() {}
}

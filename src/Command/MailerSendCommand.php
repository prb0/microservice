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
    /**
     * I have to realize ContainerAwareInterface by this trait.
     * I do it because i have to call doctrine in this command.
     */
    use ContainerAwareTrait;

    protected function configure()
    {
        /**
         * Configurations of command
         */
        $this
            ->setName('mailer:send')
            ->setDescription('Sending messages from db table')
            ->setHelp('This command sending messages from db table')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /**
         * Sending all messages from queue and removing them from she after send.
         * Logging in /var/log/mail.log file.
         * To add this command in crontab u have to add in your crontabfile next string ->
         * '* * * * * php %PATH_TO_PROJECT%/bin/console mailer:send'
         * without apostrophs of course, and change %PATH_TO_PROJECT% on real path to project,
         * it will be send messages each minute.
         * Or u can use this command manually, just open console in root project directory,
         * type php bin/console mailer:send and press 'enter' on keyboard
         */
        $io             = new SymfonyStyle($input, $output);
        $logger         = new Logger('mail');
        $doctrine       = $this->container->get('doctrine');
        $repository     = $doctrine->getRepository(Message::class);
        $messages       = $repository->findAll();
        $entityManager  = $doctrine->getManager();

        $logger->pushHandler(new StreamHandler(__DIR__ . '/../../var/log/mail.log', Logger::INFO));

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

        $io->success('Success! you can watch logs in /var/log/mail.log file');
    }

    private function sendMessageToWhatsApp() { /* TODO */ }

    private function sendMessageToViber() { /* TODO */ }

    private function sendMessageToTelegram() { /* TODO */ }
}

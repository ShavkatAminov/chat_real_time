<?php

namespace App\Command;

use App\Chat\Chat;
use App\service\MessageService;
use App\service\UserActiveTimeService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// Include ratchet libs
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

// Change the namespace according to your bundle

class SocketCommand extends Command
{
    public function __construct(string $name = null,
                                private MessageService $messageService,
                                private UserActiveTimeService $activeTimeService,
    )
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('start-chat')
            // the short description shown while running "php bin/console list"
            ->setHelp("Starts the chat socket demo")
            // the full command description shown when running the command with
            ->setDescription('Starts the chat socket demo')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Starting chat, open your browser.',// Empty line
        ]);

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat($this->messageService, $this->activeTimeService)
                )
            ),
            8080
        );

        $server->run();
    }
}

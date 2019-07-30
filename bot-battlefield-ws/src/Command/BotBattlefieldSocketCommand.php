<?php

namespace App\Command;

use Ratchet\App;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Controller\FrontController;

/**
 * Class BotBattlefieldSocketCommand
 * @package App\Command
 */
final class BotBattlefieldSocketCommand extends ContainerAwareCommand
{

    protected
        /**
         * @var string
         */
    static $defaultName = 'bot-battlefield:socket';

    private
        /**
         * @var FrontController
         */
        $frontController;

    /**
     * BotBattlefieldSocketCommand constructor.
     * @param FrontController $frontController
     */
    public function __construct(FrontController $frontController)
    {
        parent::__construct();
        $this->frontController = $frontController;
    }

    /**
     * Add arguments
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Bot Battlefield Server Socket')
            ->addArgument(
                'state',
                InputArgument::OPTIONAL,
                '[start|stop] Switch server socket state'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);
        if ('start' === $input->getArgument('state')) {
            $io->success('Bot Battlefield Server Socket is running');
            $app = new App('localhost', 8080);
            $app->route('/players', $this->frontController, ['*']);
            $app->run();
            return;
        }
        if ('stop' === $input->getArgument('state')) {
            $io->error('Bot Battlefield Server Socket is stopped');
            return;
        }
    }

}

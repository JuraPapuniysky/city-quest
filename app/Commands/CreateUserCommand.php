<?php

declare(strict_types=1);

namespace App\Commands;

use App\Entities\Request\UserRequestEntity;
use App\Services\UserService;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user-command';

    private UserService $userService;

    public function __construct(private ContainerInterface $container, $name = null)
    {
        $this->userService = $this->container->get(UserService::class);
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addArgument('fullName', InputArgument::REQUIRED, 'User full name');
        $this->addArgument('email', InputArgument::REQUIRED, 'User email');
        $this->addArgument('password', InputArgument::REQUIRED, 'Password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $requestEntity = new UserRequestEntity();
        $requestEntity->fullName = $input->getArgument('fullName');
        $requestEntity->email = $input->getArgument('email');
        $requestEntity->password = $input->getArgument('password');
        $requestEntity->confirmPassword = $input->getArgument('password');

        try {
            $userEntity = $this->userService->create($requestEntity);

            $userEntity = $this->userService->confirmUser($userEntity->getRegistrationConfirmToken());

            $output->writeln([
                'User created',
                'Email ' . $userEntity->getEmail(),
                'Full name ' . $userEntity->getFullName(),
            ]);

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln([
                'error ' . $e->getMessage(),
            ]);

            return Command::FAILURE;
        }
    }
}

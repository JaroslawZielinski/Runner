<?php

require __DIR__ . '/app/bootstrap.php';

use JaroslawZielinski\Runner\Command\UserDetailCommand;
use JaroslawZielinski\Runner\Model\UserRepository;
use Symfony\Component\Console\Output\OutputInterface;

$app = new Silly\Application();
$myApp = Application::create();

$app->useContainer($myApp->getContainer(), $injectWithTypeHint = true);

$app->command('users', function (OutputInterface $output, UserRepository $repository) {
    $output->writeln('<comment>Here are users in the data base:</comment>');
    $users = $repository->getUsers();
    /** @var News $user */
    foreach ($users as $user) {
        $output->writeln(sprintf(
            'User #%d %s is_active <info>%s</info>',
            $user->getUserId(),
            $user->__toString(),
            $user->getisActive()
        ));
    }
});

$app->command('user [id]', UserDetailCommand::class);

$app->run();

<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Command;

use JaroslawZielinski\Runner\Model\UserRepository;
use Symfony\Component\Console\Output\OutputInterface;

class UserDetailCommand
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(int $id, OutputInterface $output): int
    {
        $output->writeln('Information...');

        if (empty($id)) {
            $output->writeln('User id is needed.');

            return 1;
        }

        try {
            $article = $this->repository->getUserById($id);
            $output->writeln(sprintf("User:\t\t<info>%s %s <%s></info>", $article->getFirstName(), $article->getLastName(), $article->getEmail()));
            $output->writeln(sprintf("is active:\t<info>%s</info>", $article->getisActive()));
            $output->writeln(sprintf("gender:\t\t<info>%s</info>", $article->getGender()));

        } catch (\Exception $e) {
            $output->writeln('Not succeded because of: ' . $e->getMessage());
        }

        // If everything is fine, we should return 0 to allow pipeline calls
        return 0;
    }
}

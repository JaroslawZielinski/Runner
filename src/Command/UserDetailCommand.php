<?php

namespace JaroslawZielinski\Runner\Command;

use Exception;
use JaroslawZielinski\Runner\Model\UserRepository;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UserDetailCommand
 * @package JaroslawZielinski\Runner\Command
 */
class UserDetailCommand
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * UserDetailCommand constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @param OutputInterface $output
     * @return int
     */
    public function __invoke($id, OutputInterface $output)
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

        } catch (Exception $e) {
            $output->writeln('Not succeded because of: ' + $e->getMessage());
        }

        // If everything is fine, we should return 0 to allow pipeline calls
        return 0;
    }
}

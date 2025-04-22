<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'app:user:create',
    description: 'Add a short description for your command',
)]
class UserCreateCommand extends Command
{
    public function __construct(
        protected readonly ValidatorInterface $validator,
        protected readonly UserPasswordHasherInterface $userPasswordHasher,
        protected readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $email = $io->ask(
            'What is your user\'s email address?',
            validator: Validation::createCallable(
                new Assert\NotBlank(),
                new Assert\NotNull(),
                new Assert\Email(),
            ),
        );

        $password = $io->askHidden(
            'What is your user\'s password?',
            validator: Validation::createCallable(
                new Assert\NotBlank(),
                new Assert\NotNull(),
                new Assert\PasswordStrength([
                    'minScore' => Assert\PasswordStrength::STRENGTH_VERY_STRONG
                ]),
                new Assert\NotCompromisedPassword(),
            ),
        );

        $user = new User();
        $user
            ->setEmail($email)
            ->setPassword(
                $this->userPasswordHasher->hashPassword($user, $password)
            )
        ;

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        if (null !== $user->getId()) {
            $io->success('Your user has been successfully saved!');
            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}

<?php
namespace boxiweb\UserBundle\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\UserBundle\Command\CreateUserCommand as BaseCommand;

class CreateUserCommand extends BaseCommand{
    /**
     * @see Command
     */
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('boxiweb:user:create')
            ->getDefinition()->addArguments(array(
                new InputArgument('nom', InputArgument::REQUIRED, 'The lastname'),
                new InputArgument('prenom', InputArgument::REQUIRED, 'The firstname')
            ))
        ;
        $this->setHelp(<<<EOT
// L'aide qui va bien
EOT
            );
    }
  
    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    { 
        $username   = $input->getArgument('username');
        $email      = $input->getArgument('email');
        $password   = $input->getArgument('password');
        $prenom  = $input->getArgument('prenom');
        $nom  = $input->getArgument('nom');
//         $firstname  = $input->getArgument('firstname');
//        $lastname   = $input->getArgument('lastname');
        $inactive   = $input->getOption('inactive');
        $superadmin = $input->getOption('super-admin');
 
        /** @var \FOS\UserBundle\Model\UserManager $user_manager */
        $user_manager = $this->getContainer()->get('fos_user.user_manager');
 
        /** @var \Acme\AcmeUserBundle\Entity\User $user */
        $user = $user_manager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled((Boolean) !$inactive);
        $user->setSuperAdmin((Boolean) $superadmin);
//        $user->setFirstName($firstname);
//        $user->setLastName($lastname);
        $user->setPrenom($prenom);
        $user->setNom($nom);
 
        $user_manager->updateUser($user);
 
        $output->writeln(sprintf('Created user <comment>%s</comment>', $username));
    }
 
    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        parent::interact($input, $output);
        if (!$input->getArgument('prenom')) {
            $prenom = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a lastname:',
                function($prenom) {
                    if (empty($prenom)) {
                        throw new \Exception('lastname can not be empty');
                    }
 
                    return $prenom;
                }
            );
            $input->setArgument('prenom', $prenom);
        }
        if (!$input->getArgument('nom')) {
            $nom = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a firstname:',
                function($nom) {
                    if (empty($nom)) {
                        throw new \Exception('firstname can not be empty');
                    }
  
                    return $nom;
                }
            );
            $input->setArgument('nom', $nom);
        }
    }
}

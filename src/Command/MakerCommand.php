<?php

namespace Bwlab\BwModuleSetup\Command;

use Nette\PhpGenerator\PhpFile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;

class MakerCommand extends Command
{
    protected Filesystem $filesystem;
    protected string $base_controller_folder;
    protected string $base_folder;
    private Environment $twig;
    
    public function __construct(Environment $environment)
    {
        parent::__construct('bwlab:module:setup');
        $this->twig = $environment;
        $this->filesystem = new Filesystem();
        $this->base_folder = _PS_MODULE_DIR_.'bwmodulesetup/views/templates/module';
        $this->base_controller_folder = $this->base_folder.'/controller';
    }
    
    protected function configure(): void
    {
        // The name of the command (the part after "bin/console")
        $this->setName('bwlab:module:setup')
            ->addArgument('modulename', InputArgument::REQUIRED)
            ->addArgument('namespace', InputArgument::REQUIRED);
    }
    
    protected function createControllerTemplate($modulename, $templatename)
    {
        
        $module_view_path = _PS_MODULE_DIR_
            .$modulename.DIRECTORY_SEPARATOR
            .'views'
            .DIRECTORY_SEPARATOR
            .'templates'.DIRECTORY_SEPARATOR
            .'admin'.DIRECTORY_SEPARATOR
            .'controller';
        
        $this->filesystem->mkdir(
            $module_view_path
        );
        $this->filesystem->copy(
            $this->base_controller_folder.DIRECTORY_SEPARATOR.'template_controller.twig',
            $module_view_path
            .DIRECTORY_SEPARATOR.'admin_configuration.html.twig'
        );
        
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $modulename = $input->getArgument('modulename');
        $namespace = $input->getArgument('namespace');
    
        $output->writeln('create module folder');
        $this->createModule($modulename);
        $output->writeln('create main file');
        $this->createMain($modulename, $namespace);
        $output->writeln('create composer.json');
        $this->creteComposerJson($modulename, $namespace);
        $output->writeln('create config');
        $this->createConfig($modulename);
        $output->writeln('create routes');
        $this->createRoute($modulename, $namespace);
        $output->writeln('create configuration controller');
        $this->createController($modulename, $namespace);
        $output->writeln('create form ');
        $this->createControllerForm($modulename, $namespace);
        $output->writeln('create configuration controller template');
        $this->createControllerTemplate($modulename, $namespace);
        $output->writeln('....');
        $output->writeln('OK! Now you can run "composer install" inside the module.');
        $output->writeln('');
    }
    
    private function createConfig($modulename)
    {
        $module_config_path = _PS_MODULE_DIR_
            .$modulename.DIRECTORY_SEPARATOR
            .'config'
            .DIRECTORY_SEPARATOR
            .'admin';
        $this->filesystem->mkdir(
            $module_config_path
        );
        $this->filesystem->copy(
            $this->base_controller_folder.DIRECTORY_SEPARATOR.'services.yml',
            $module_config_path
            .DIRECTORY_SEPARATOR.'services.yml'
        );
        
    }
    
    private function createController($modulename, $namespace)
    {
        
        $controller_code = $this->twig->render(
            $this->base_controller_folder.DIRECTORY_SEPARATOR.'configuration.php.twig',
            [
                'class_name' => 'ConfigurationController',
                'module_name' => $modulename,
                'name_space' => $namespace,
            ]
        );
        
        $file = PhpFile::fromCode($controller_code);
        
        
        $this->filesystem->dumpFile(
            _PS_MODULE_DIR_
            .$modulename.DIRECTORY_SEPARATOR
            .'src'
            .DIRECTORY_SEPARATOR
            .'Controller'
            .DIRECTORY_SEPARATOR.'ConfigurationController.php',
            $file->__toString()
        );
        
    }
    
    private function createControllerForm($modulename, $namespace)
    {
        $controller_code = $this->twig->render(
            $this->base_controller_folder.DIRECTORY_SEPARATOR.'form.php.twig',
            [
                'class_name' => 'ConfigurationType',
                'module_name' => $modulename,
                'name_space' => $namespace,
            ]
        );
    
        $file = PhpFile::fromCode($controller_code);
    
    
        $this->filesystem->dumpFile(
            _PS_MODULE_DIR_
            .$modulename.DIRECTORY_SEPARATOR
            .'src'
            .DIRECTORY_SEPARATOR
            .'Form'
            .DIRECTORY_SEPARATOR
            .'Type'
            .DIRECTORY_SEPARATOR
            .'ConfigurationController.php',
            $file->__toString()
        );
    }
    
    private function createMain($modulename, $namespace)
    {
        
        $controller_code = $this->twig->render(
            $this->base_folder.DIRECTORY_SEPARATOR.'main.php.twig',
            [
                'module_name' => $modulename,
            ]
        );
        
        $file = PhpFile::fromCode($controller_code);
        
        
        $this->filesystem->dumpFile(
            _PS_MODULE_DIR_
            .$modulename
            .DIRECTORY_SEPARATOR.$modulename.'.php',
            $file->__toString()
        );
        
    }
    
    private function createModule($modulename)
    {
        $this->filesystem->mkdir(_PS_MODULE_DIR_.$modulename);
        
    }
    
    private function createRoute($modulename, $namespace)
    {
        $module_route_path = _PS_MODULE_DIR_
            .$modulename.DIRECTORY_SEPARATOR
            .'config';
        if ($this->filesystem->exists($module_route_path) === false) {
            $this->filesystem->mkdir(
                $module_route_path
            );
        }
        $route_code = $this->twig->render(
            $this->base_controller_folder.DIRECTORY_SEPARATOR.'routes.yml.twig',
            [
                'module_name' => $modulename,
                'name_space' => $namespace,
            ]
        );
        
        
        $this->filesystem->dumpFile(
            $module_route_path
            .DIRECTORY_SEPARATOR.'routes.yml',
            $route_code
        );
        
    }
    
    private function creteComposerJson($modulename, $namespace)
    {
        $composer_code = $this->twig->render(
            $this->base_folder.DIRECTORY_SEPARATOR.'composer.json.twig',
            [
                'module_name' => $modulename,
                'name_space_psr4' => str_replace('\\', '\\\\', $namespace),
            ]
        );
        
        $this->filesystem->dumpFile(
            _PS_MODULE_DIR_
            .$modulename
            .DIRECTORY_SEPARATOR.'composer.json',
            $composer_code
        );
    }
    
}

<?php
/**
 * Core module for extending and testing functionality across Magento 2
 *
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Core\Console\Command;

use Iods\Core\Api\Environment\ConfigValuesProvider;
use Iods\Core\Model\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EnvironmentConfigurationCommand extends Command
{
    const COMMAND_NAME = 'environment:configure';

    private Config $_config;

    private ConfigValuesProvider $_configValuesProvider;

    public function __construct(
        Config $config,
        ConfigValuesProvider $configValuesProvider,
        string $name = null
    ) {
        $this->_config = $config;
        $this->_configValuesProvider = $configValuesProvider;
        parent::__construct($name);
    }

    protected function configure()
    {
        parent::configure();

        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Applies non-sensitive environment information to config values.');
        $this->addArgument(
            'environment',
            InputArgument::REQUIRED,
            'The environment you wish to configure.'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $environment = $input->getArgument('environment');
        $values = $this->_configValuesProvider->getValues()->getConfigValuesByEnvironment($environment);

        foreach ($values as $v) {
            $this->_config->save($v);
        }

        if ($values->isEmpty()) {
            $output->writeln('No config found for environment ' . $environment);
        } else {
            $output->writeln(sprintf(
                'Updated config values for %s environment.',
                $environment
            ));
        }
        return 0;
    }
}
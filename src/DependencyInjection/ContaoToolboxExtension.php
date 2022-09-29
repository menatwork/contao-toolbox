<?php

/**
 * Copyright (c) 2022 by MEN AT WORK Werbeagentur GmbH
 * All rights reserved
 *
 * @copyright  MEN AT WORK Werbeagentur GmbH 2022
 * @author     Stefan Heimes <heimes@men-at-work.de>
 */

namespace MenAtWork\ContaoToolbox\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ContaoToolboxExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        try {
//            $loader->load('commands.yml');
        } catch (\Exception $e) {
            // Nothing to see here.
        }
    }
}

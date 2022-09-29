<?php

/**
 * Copyright (c) 2022 by MEN AT WORK Werbeagentur GmbH
 * All rights reserved
 *
 * @copyright  MEN AT WORK Werbeagentur GmbH 2022
 * @author     Stefan Heimes <heimes@men-at-work.de>
 */


namespace MenAtWork\ContaoToolbox;

use MenAtWork\ContaoToolbox\DependencyInjection\ContaoToolboxExtension;
use Symfony\Component\Console\Application;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class MultiColumnWizardBundle
 *
 * @package MenAtWork\MultiColumnWizardBundle
 */
class ContaoToolboxBundle extends Bundle
{
    public const SCOPE_BACKEND = 'backend';
    public const SCOPE_FRONTEND = 'frontend';

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new ContaoToolboxExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function registerCommands(Application $application)
    {
        // disable automatic command registration
    }
}

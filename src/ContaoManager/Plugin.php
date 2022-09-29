<?php

/**
 * Copyright (c) 2022 by MEN AT WORK Werbeagentur GmbH
 * All rights reserved
 *
 * @copyright  MEN AT WORK Werbeagentur GmbH 2022
 * @author     Stefan Heimes <heimes@men-at-work.de>
 */

namespace MenAtWork\ContaoToolbox\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerBundle\ContaoManagerBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use MenAtWork\ContaoToolbox\ContaoToolboxBundle;

/**
 * Class Plugin
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ContaoToolboxBundle::class)
                ->setLoadAfter(
                    [
                        ContaoCoreBundle::class,
                        ContaoManagerBundle::class,
                    ]
                ),
        ];
    }
}

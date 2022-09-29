<?php

/**
 * Copyright (c) 2022 by MEN AT WORK Werbeagentur GmbH
 * All rights reserved
 *
 * @copyright  MEN AT WORK Werbeagentur GmbH 2022
 * @author     Stefan Heimes <heimes@men-at-work.de>
 */

use \Contao\Controller;
use \Contao\FilesModel;
use \Contao\FrontendTemplate;
use \Contao\StringUtil;
use \Contao\Validator;

if (!function_exists('mawImageTransform')) {

    /**
     * Little helper to perform picture transformations.
     *
     * @param string      $pathUUid     The uuid or the path.
     *
     * @param string|int  $formatName   The name or the id of the format to use.
     *
     * @param string|null $alt          The alternative text or null for a default handling.
     *
     * @param string|null $title        The title to be used or null for default handling.
     *
     * @param string|null $lang         Nullable. The lang to use for meta. If null it will use the globale one.
     *
     * @param string      $fallbackLang Fallback language for meta.
     *
     * @param string|null $css          A additional css class or null
     *
     * @return string HTML Comment with error or the image tag.
     */
    function mawImageTransform(
        string $pathUUid,
        $formatName,
        ?string $alt = null,
        ?string $title = null,
        ?string $lang = null,
        string $fallbackLang = 'en',
        ?string $css = null
    ): string {
        try {
            // No path no run.
            if (empty($pathUUid)) {
                return '<!-- IMAGE-TRANSFORM-ERROR: EMPTY UUID OR PATH  -->';
            }

            // Path or UUID this is the question.
            if (Validator::isUuid($pathUUid)) {
                if (!Validator::isBinaryUuid($pathUUid)) {
                    $pathUUid = StringUtil::uuidToBin($pathUUid);
                }

                $filesModel = FilesModel::findByUuid($pathUUid);
            } else {
                $filesModel = FilesModel::findByPath($pathUUid);
            }

            // Empty e.g. no result in the dbafs so file is missing.
            if (empty($filesModel)) {
                return '<!-- IMAGE-TRANSFORM-ERROR: FILE NOT FOUND  -->';
            }

            // If no lang set try the default handling.
            if ($lang === null) {
                $lang = $GLOBALS['TL_LANGUAGE'];
            }

            // Get the image ID's
            static $sizes;
            if (empty($sizes)) {
                $imageResult = \Contao\Database::getInstance()
                    ->prepare('SELECT id, name FROM tl_image_size')
                    ->execute()
                    ->fetchAllAssoc();
                foreach ($imageResult as $row) {
                    $sizes[$row['name']] = $row['id'];
                }
            }

            // Catch the meta.
            $meta     = \unserialize($filesModel->meta);
            $metaLang = $meta[$lang] ?? $meta[$fallbackLang] ?? '';// Check which size type we have, the name, the id or nothing.

            // Try to fetch the right size id or
            switch (true) {
                case !empty($sizes[$formatName]):
                    $size = (int)$sizes[$formatName];
                    break;

                case is_numeric($formatName):
                    $size = (int)$formatName;
                    break;

                default:
                    $size = '';
                    break;
            }

            // Basic setup.
            $config = [
                'singleSRC' => $filesModel->path,
                'alt'       => $alt ?? $metaLang->alt ?? '',
                'title'     => $title ?? $metaLang->title ?? '',
                'size'      => $size,
            ];

            // There is no direct access to the css class, so we use the floating and set it to none and
            // add the wished css class behind it.
            if (!empty($css)) {
                $config['floating'] = 'none ' . $css;
            }

            // Build the data.
            $tpl = new FrontendTemplate('image');
            Controller::addImageToTemplate(
                $tpl,
                $config,
                null,
                null,
                $filesModel
            );

            return $tpl->parse();
        } catch (Exception $e) {
            return '<!-- IMAGE-TRANSFORM-ERROR: ' . strip_tags($e->getMessage()) . '  -->';
        }
    }
}

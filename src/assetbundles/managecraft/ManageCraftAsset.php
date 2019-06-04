<?php
/**
 * ManageCraft plugin for Craft CMS 3.x
 *
 * This is a description
 *
 * @link      https://jfd.co.uk
 * @copyright Copyright (c) 2019 JFD
 */

namespace jfd\managecraft\assetbundles\ManageCraft;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    JFD
 * @package   ManageCraft
 * @since     1.0.0
 */
class ManageCraftAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@jfd/managecraft/assetbundles/managecraft/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/ManageCraft.js',
        ];

        $this->css = [
            'css/ManageCraft.css',
        ];

        parent::init();
    }
}

<?php
/**
 * ManageCraft plugin for Craft CMS 3.x
 *
 * Expose info about available Craft CMS and plugin updates
 *
 * @link      https://jfd.co.uk
 * @copyright Copyright (c) 2019 JFD
 */

namespace jfd\managecraft;

use jfd\managecraft\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class ManageCraft
 *
 * @author    JFD
 * @package   ManageCraft
 * @since     1.0.0
 *
 */
class ManageCraft extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var ManageCraft
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) { }
            }
        );

        Craft::info(
            Craft::t(
                'manage-craft',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'manage-craft/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}

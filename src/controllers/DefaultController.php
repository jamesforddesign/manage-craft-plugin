<?php
/**
 * ManageCraft plugin for Craft CMS 3.x
 *
 * Expose info about available Craft CMS and plugin updates
 *
 * @link      https://jfd.co.uk
 * @copyright Copyright (c) 2019 JFD
 */

namespace jfd\managecraft\controllers;

use jfd\managecraft\ManageCraft;

use Craft;
use craft\models\Update;
use craft\web\Controller;

use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;

/**
 * @author    JFD
 * @package   ManageCraft
 * @since     1.0.0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $settings = ManageCraft::$plugin->getSettings();

        // If access key exists then require it
        if ($settings->accessKey) {
            $this->requireAccessKey($settings->accessKey);
        }

        $forceRefresh = true;
        $allowUpdates = false;

        // Get updates (force refresh)
        $updates = Craft::$app->getUpdates()->getUpdates($forceRefresh);

        $res = [];

        $res['cms'] = $this->_transformUpdate($allowUpdates, $updates->cms, 'craft', 'Craft CMS', Craft::$app->getVersion());
        $res['plugins'] = [];

        $pluginsService = Craft::$app->getPlugins();

        foreach ($updates->plugins as $handle => $update) {
            $plugin = $pluginsService->getPlugin($handle);

            if ($plugin !== null) {

                if ($update->hasReleases) {
                    $res['plugins'][] = $this->_transformUpdate($allowUpdates, $update, $handle, $plugin->name, $plugin->version);
                }
            }
        }

        return $this->asJson($res);
    }

    // Private Methods
    // =========================================================================

    private function requireAccessKey($accessKey = null)
    {
        $headers = Craft::$app->request->headers;
        $auth = $headers->get('Access-Key');
        if ($auth !== $accessKey) {
            throw new BadRequestHttpException('Invalid access key.');
        }
    }

    private function _transformUpdate(bool $allowUpdates, Update $update, string $handle, string $name, string $currentVersion): array
    {
        $arr = $update->toArray();

        $arr['handle'] = $handle;
        $arr['name'] = $name;
        $arr['currentVersion'] = $currentVersion;
        $arr['latestVersion'] = $update->getLatest()->version ?? null;

        if ($update->status === Update::STATUS_EXPIRED) {

            $arr['statusText'] = Craft::t('app', '<strong>Your license has expired!</strong> Renew your {name} license for another year of updates.', [
                'name' => $name
            ]);

            $arr['ctaText'] = Craft::t('app', 'Renew for {price}', [
                'price' => Craft::$app->getFormatter()->asCurrency($update->renewalPrice, $update->renewalCurrency)
            ]);

            $arr['ctaUrl'] = UrlHelper::url($update->renewalUrl);
        } else {

            if ($update->status === Update::STATUS_BREAKPOINT) {
                $arr['statusText'] = Craft::t('app', '<strong>You’ve reached a breakpoint!</strong> More updates will become available after you install {update}.</p>', [
                    'update' => $name . ' ' . ($update->getLatest()->version ?? '')
                ]);
            }

            if ($allowUpdates) {
                $arr['ctaText'] = Craft::t('app', 'Update');
            }
        }

        return $arr;
    }
}

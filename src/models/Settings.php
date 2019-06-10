<?php
/**
 * ManageCraft plugin for Craft CMS 3.x
 *
 * Expose info about available Craft CMS and plugin updates
 *
 * @link      https://jfd.co.uk
 * @copyright Copyright (c) 2019 JFD
 */

namespace jfd\managecraft\models;

use jfd\managecraft\ManageCraft;

use Craft;
use craft\base\Model;

/**
 * @author    JFD
 * @package   ManageCraft
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $accessKey;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['accessKey', 'string']
        ];
    }
}

<?php
/**
* 2007-2019 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2019 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

namespace PrestaShop\Module\PrestashopCheckout;

use PrestaShop\Module\PrestashopCheckout\Translations\OrderStatesTranslations;

class OrderStates
{
    const MODULE_NAME = 'ps_checkout';
    const ORDER_STATE_TEMPLATE = 'payment';
    const ORDER_STATE_TABLE = 'order_state';
    const ORDER_STATE_LANG_TABLE = 'order_state_lang';
    const BLUE_HEXA_COLOR = '#4169E1';
    const YELLOW_HEXA_COLOR = '#C7BA19';
    const ORDER_STATES = array(
        'PS_CHECKOUT_STATE_WAITING_PAYPAL_PAYMENT' => self::BLUE_HEXA_COLOR,
        'PS_CHECKOUT_STATE_WAITING_CREDIT_CARD_PAYMENT' => self::BLUE_HEXA_COLOR,
        'PS_CHECKOUT_STATE_WAITING_LOCAL_PAYMENT' => self::BLUE_HEXA_COLOR,
        'PS_CHECKOUT_STATE_AUTHORIZED' => self::BLUE_HEXA_COLOR,
        'PS_CHECKOUT_STATE_PARTIAL_REFUND' => self::YELLOW_HEXA_COLOR,
        'PS_CHECKOUT_STATE_WAITING_CAPTURE' => self::BLUE_HEXA_COLOR,
    );

    /**
     * Insert the new paypal states if it does not exists
     * Create a new order state for each ps_checkout new order states
     *
     * @return bool
     */
    public function installPaypalStates()
    {
        foreach (self::ORDER_STATES as $state => $color) {
            $orderStateId = $this->getPaypalStateId($state, $color);
            $this->createPaypalStateLangs($state, $orderStateId);
        }

        return true;
    }

    /**
     * Get the paypal state id if it already exist.
     * Get the paypal state id if it doesn't exist by creating it
     *
     * @param string $state
     *
     * @return int
     */
    private function getPaypalStateId($state, $color)
    {
        $stateId = \Configuration::get($state);

        // Is state ID already existing in the Configuration table ?
        if (false === $stateId) {
            return $this->createPaypalStateId($state, $color);
        }

        return (int) $stateId;
    }

    /**
     * Create the Paypal State id
     *
     * @param string $state
     *
     * @return int orderStateId
     */
    private function createPaypalStateId($state, $color)
    {
        $data = array(
            'module_name' => self::MODULE_NAME,
            'color' => $color,
            'unremovable' => 1,
        );

        if (true === \Db::getInstance()->insert(self::ORDER_STATE_TABLE, $data)) {
            $insertedId = (int) \Db::getInstance()->Insert_ID();
            \Configuration::updateValue($state, $insertedId);

            return $insertedId;
        }

        throw new \PrestaShopException('Not able to insert the new order state');
    }

    /**
     * Create the Paypal States Lang
     *
     * @param string $state
     * @param int $orderStateId
     */
    private function createPaypalStateLangs($state, $orderStateId)
    {
        $languagesList = \Language::getLanguages();
        $orderStatesTranslations = new OrderStatesTranslations();

        // For each languages in the shop, we insert a new order state name
        foreach ($languagesList as $key => $lang) {
            if (true === $this->stateLangAlreadyExists($orderStateId, (int) $lang['id_lang'])) {
                continue;
            }

            $statesTranslations = $orderStatesTranslations->getTranslations($lang['iso_code']);
            $this->insertNewStateLang($orderStateId, $statesTranslations[$state], (int) $lang['id_lang']);
        }
    }

    /**
     * Check if Paypal State language already exists in the table ORDEr_STATE_LANG_TABLE
     *
     * @param int $orderStateId
     * @param int $langId
     *
     * @return bool
     */
    private function stateLangAlreadyExists($orderStateId, $langId)
    {
        return (bool) \Db::getInstance()->getValue(
            'SELECT id_order_state
            FROM  `' . _DB_PREFIX_ . self::ORDER_STATE_LANG_TABLE . '`
            WHERE
                id_order_state = ' . $orderStateId . '
                AND id_lang = ' . $langId
        );
    }

    /**
     * Create the Paypal States Lang
     *
     * @param int $orderStateId
     * @param string $translations
     * @param int $langId
     */
    private function insertNewStateLang($orderStateId, $translations, $langId)
    {
        $data = array(
            'id_order_state' => $orderStateId,
            'id_lang' => (int) $langId,
            'name' => pSQL($translations),
            'template' => self::ORDER_STATE_TEMPLATE,
        );

        if (false === \Db::getInstance()->insert(self::ORDER_STATE_LANG_TABLE, $data)) {
            throw new \PrestaShopException('Not able to insert the new order state language');
        }
    }

    /**
     * updateOrderState
     *
     * @param  string $eventType
     * @param  int $resource
     *
     * @return void
     */
    public function updateOrderState($eventType, $orderId)
    {
        $paypalOrderRepository = new PaypalOrderRepository();



    }
}

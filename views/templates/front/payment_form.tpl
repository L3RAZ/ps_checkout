{*
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2019 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<section class="additional-information">

    <script id="paypalSdk" src="https://www.paypal.com/sdk/js?components=hosted-fields&client-id=<client_id>"></script>

    <form action="{$action}" id="payment-form">

        <div class="form-group row">
            <div class="col-md-8">
                <label for="card-number" class="form-control-label required">{l s='Card number' mod='prestashoppayments'}</label>
                <div id="card-number"></div>
            </div>
            {* <div class="col-md-3 form-control-comment"></div> *}
        </div>

        <div class="form-group row">
            <div class="col-md-4">
                <label for="expiration-date" class="form-control-label required">{l s='Expiry date' mod='prestashoppayments'}</label>
                <div id="expiration-date"></div>
            </div>
            <div class="col-md-4">
                <label for="cvv" class="form-control-label required">{l s='CVC' mod='prestashoppayments'}</label>
                <div id="cvv"></div>
            </div>
            {* <div class="col-md-3 form-control-comment"></div> *}
        </div>

    </form>

</section>

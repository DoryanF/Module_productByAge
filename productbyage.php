<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class ProductByAge extends Module
{
    public function __construct()
    {
        $this->name = 'productbyage';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Doryan Fourrichon';
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
        
        //récupération du fonctionnement du constructeur de la méthode __construct de Module
        parent::__construct();
        $this->bootstrap = true;

        $this->displayName = $this->l('Product by age');
        $this->description = $this->l('Le module qui permet d\'ajouter l\'âge recommandé à vos produits');

        $this->confirmUninstall = $this->l('Do you want to delete this module');
    }

    public function install()
    {
        if (!parent::install() ||
        !Configuration::updateValue('ACTIVATEAGE',0) ||
        !Configuration::updateValue('AGEPRODUCTLIST',0) ||
        !Configuration::updateValue('AGEPRODUCTPAGE',0) ||
        !Configuration::updateValue('AGEHOMEACTIVE',0) ||
        !$this->registerHook('displayAdminProductsExtra') ||
        !$this->registerHook('actionProductUpdate') ||
        !$this->createTable()
        
        ) {
            return false;
        }
            return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall() ||
        !Configuration::deleteByName('ACTIVATEAGE') ||
        !Configuration::deleteByName('AGEPRODUCTLIST') ||
        !Configuration::deleteByName('AGEPRODUCTPAGE') ||
        !Configuration::deleteByName('AGEHOMEACTIVE') ||
        !$this->unregisterHook('displayAdminProductsExtra') ||
        !$this->unregisterHook('actionProductUpdate') ||
        !$this->deleteTable()
        
        ) {
            return false;
        }
            return true;
    }

    public function getContent()
    {
        return $this->postProcess().$this->renderForm();
    }

    public function renderForm()
    {
        $field_form[0]['form'] = [
            'legend' => [
                'title' => $this->l('Settings'),
            ],
            'input' => [
                [
                    'type' => 'switch',
                        'label' => $this->l('Active module ?'),
                        'name' => 'ACTIVATEAGE',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        )
                ],
                [
                    'type' => 'switch',
                        'label' => $this->l('Display on productlist ?'),
                        'name' => 'AGEPRODUCTLIST',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        )
                ],
                [
                    'type' => 'switch',
                        'label' => $this->l('Display on product page ?'),
                        'name' => 'AGEPRODUCTPAGE',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        )
                ],
                [
                    'type' => 'switch',
                        'label' => $this->l('Display carrousel homepage ?'),
                        'name' => 'AGEHOMEACTIVE',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        )
                ],
            ],
            'submit' => [
                'title' => $this->l('save'),
                'class' => 'btn btn-primary',
                'name' => 'saving'
            ]
        ];

        $helper = new HelperForm();
        $helper->module  = $this;
        $helper->name_controller = $this->name;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->fields_value['ACTIVATEAGE'] = Configuration::get('ACTIVATEAGE');
        $helper->fields_value['AGEPRODUCTLIST'] = Configuration::get('AGEPRODUCTLIST');
        $helper->fields_value['AGEPRODUCTPAGE'] = Configuration::get('AGEPRODUCTPAGE');
        $helper->fields_value['AGEHOMEACTIVE'] = Configuration::get('AGEHOMEACTIVE');

        return $helper->generateForm($field_form);
    }

    public function postProcess()
    {
        if(Tools::isSubmit('saving'))
        {
            if(Validate::isBool(Tools::getValue('ACTIVATEAGE')) && Validate::isBool(Tools::getValue('AGEPRODUCTLIST')) 
            && Validate::isBool(Tools::getValue('AGEPRODUCTPAGE')) && Validate::isBool(Tools::getValue('AGEHOMEACTIVE')) )
            {
                Configuration::updateValue('ACTIVATEAGE',Tools::getValue('ACTIVATEAGE'));
                Configuration::updateValue('AGEPRODUCTLIST',Tools::getValue('AGEPRODUCTLIST'));
                Configuration::updateValue('AGEPRODUCTPAGE',Tools::getValue('AGEPRODUCTPAGE'));
                Configuration::updateValue('AGEHOMEACTIVE',Tools::getValue('AGEHOMEACTIVE'));

                return $this->displayConfirmation('Bien enregistré !');
            }
        }
    }


    public function createTable()
    {
        return DB::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'product_age(
                id_product_age INT UNSIGNED NOT NULL,
                id_product INT UNSIGNED NOT NULL,
                min_age INT NOT NULL,
                max_age INT NOT NULL,
                PRIMARY KEY (id_product_age, id_product)
            )'
        );
    }

    public function deleteTable()
    {
        return DB::getInstance()->execute(
            'DROP TABLE IF EXISTS '._DB_PREFIX_.'product_age'
        );
    }



    //admin product
    public function hookDisplayAdminProductsExtra($params)
    {
        if(Configuration::get('ACTIVATEAGE') == 1)
        {
            $this->smarty->assign(array(
                'product' => $params['id_product'],
            ));
    
            return $this->display(__FILE__,'views/templates/hook/adminProductExtra.tpl');

        }

    }

    public function hookActionProductUpdate($params)
    {
        $productId = (int)Tools::getValue('product');
        $minAgeProduct = (int)Tools::getValue('min_age_product');
        $maxAgeProduct = (int)Tools::getValue('max_age_product');

        // die('Product ID: ' . $productId . ', Min Age: ' . $minAgeProduct . ', Max Age: ' . $maxAgeProduct);

        // $product = new Product($productId);
        // $product->active = 1;
        // $product->save();

        $existingInBdd = ProductAge::getExistInBdd($productId);
        
        // var_dump($existingInBdd);
        // die();

        if($existingInBdd !== false)
        {
            ProductAge::updateAgeProduct($productId, $minAgeProduct, $maxAgeProduct);
        }
        else 
        {
            ProductAge::insertAgeProduct($productId, $minAgeProduct, $maxAgeProduct);
        }
    }

    public function hookDisplayReassurance($params)
    {
        if(Configuration::get('ACTIVATEAGE') == 1)
        {
            if(Configuration::get('AGEPRODUCTPAGE') == 1)
            {
                // $existingInBdd = ProductAge::getAgeByProductId($params["product"]->id);
            }

        }

    }

    public function hookDisplayAfterProductThumbs($params)
    {
        if(Configuration::get('ACTIVATEAGE') == 1)
        {
            if(Configuration::get('AGEPRODUCTPAGE') == 1)
            {
                $existingInBdd = ProductAge::getExistInBdd($params["product"]["id_product"]);
            }

        }
    }

}
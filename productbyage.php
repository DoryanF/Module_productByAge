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

require_once _PS_MODULE_DIR_.'productbyage/classes/ProductAge.php';

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
        $this->description = $this->l('The module that allows you to add the recommended age to your products');

        $this->confirmUninstall = $this->l('Do you want to delete this module');
    }

    public function install()
    {
        if (!parent::install() ||
        !Configuration::updateValue('ACTIVATEAGE',0) ||
        !Configuration::updateValue('AGEPRODUCTLIST',0) ||
        !Configuration::updateValue('AGEPRODUCTPAGE',0) ||
        !Configuration::updateValue('AGEHOMEACTIVE',0) ||
        !Configuration::updateValue('ACTIVETEXTAGEPRODUCTLIST',0) ||
        !Configuration::updateValue('ACTIVELOGOAGEPRODUCTLIST',0) ||
        !$this->registerHook('displayAdminProductsExtra') ||
        !$this->registerHook('actionProductUpdate') ||
        !$this->registerHook('displayContentWrapperBottom') ||
        !$this->registerHook('displayHeader') ||
        !$this->registerHook('displayProductListReviews') ||
        !$this->registerHook('displayLeftColumn') ||
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
        !Configuration::deleteByName('ACTIVETEXTAGEPRODUCTLIST') ||
        !$this->unregisterHook('displayAdminProductsExtra') ||
        !$this->unregisterHook('actionProductUpdate') ||
        !$this->unregisterHook('displayContentWrapperBottom') ||
        !$this->unregisterHook('displayHeader') ||
        !$this->unregisterHook('displayProductListReviews') ||
        !$this->unregisterHook('displayLeftColumn') ||
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
                [
                    'type' => 'switch',
                        'label' => $this->l('Display text on productlist ?'),
                        'name' => 'ACTIVETEXTAGEPRODUCTLIST',
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
                        'label' => $this->l('Display logo on productlist ?'),
                        'name' => 'ACTIVELOGOAGEPRODUCTLIST',
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
        $helper->fields_value['ACTIVETEXTAGEPRODUCTLIST'] = Configuration::get('ACTIVETEXTAGEPRODUCTLIST');
        $helper->fields_value['ACTIVELOGOAGEPRODUCTLIST'] = Configuration::get('ACTIVELOGOAGEPRODUCTLIST');

        return $helper->generateForm($field_form);
    }

    public function postProcess()
    {
        if(Tools::isSubmit('saving'))
        {
            if(Validate::isBool(Tools::getValue('ACTIVATEAGE')) && Validate::isBool(Tools::getValue('AGEPRODUCTLIST')) 
            && Validate::isBool(Tools::getValue('AGEPRODUCTPAGE')) && Validate::isBool(Tools::getValue('AGEHOMEACTIVE')) 
            && Validate::isBool(Tools::getValue('ACTIVETEXTAGEPRODUCTLIST')) && Validate::isBool(Tools::getValue('ACTIVELOGOAGEPRODUCTLIST'))
            )
            {
                Configuration::updateValue('ACTIVATEAGE',Tools::getValue('ACTIVATEAGE'));
                Configuration::updateValue('AGEPRODUCTLIST',Tools::getValue('AGEPRODUCTLIST'));
                Configuration::updateValue('AGEPRODUCTPAGE',Tools::getValue('AGEPRODUCTPAGE'));
                Configuration::updateValue('AGEHOMEACTIVE',Tools::getValue('AGEHOMEACTIVE'));
                Configuration::updateValue('ACTIVETEXTAGEPRODUCTLIST',Tools::getValue('ACTIVETEXTAGEPRODUCTLIST'));
                Configuration::updateValue('ACTIVELOGOAGEPRODUCTLIST',Tools::getValue('ACTIVELOGOAGEPRODUCTLIST'));

                return $this->displayConfirmation('Well recorded!');
            }
        }
    }


    public function createTable()
    {
        return DB::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'product_age(
                id_product_age INT UNSIGNED NOT NULL AUTO_INCREMENT,
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


//Hooks
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

        $existingInBdd = ProductAge::getExistInBdd($productId);

        if($existingInBdd !== false)
        {
            ProductAge::updateAgeProduct($productId, $minAgeProduct, $maxAgeProduct);
        }
        else 
        {
            ProductAge::insertAgeProduct($productId, $minAgeProduct, $maxAgeProduct);
        }
    }
    //


    // page product boutique
    public function hookDisplayReassurance($params)
    {
        $link = new Link();
        if(Configuration::get('ACTIVATEAGE') == 1)
        {
            if(Configuration::get('AGEPRODUCTPAGE') == 1)
            {
                $product = $params["smarty"]->tpl_vars;
                $existingInBdd = ProductAge::getExistInBdd($product["product"]->value["id"]);

                if($existingInBdd == true)
                {
                    $maxAge = ProductAge::getMaxAgeByProduct($product["product"]->value["id"]);

                    $imagePath = $link->getBaseLink() . 'modules/' . $this->name .'/views/img/'.$maxAge.'.png';
                    $this->smarty->assign(array(
                        'img' => $imagePath
                    ));

                    return $this->display(__FILE__,'views/templates/hook/productAgePageProduct.tpl');
                }
            }

        }

    }

    public function hookDisplayAfterProductThumbs($params)
    {

        $link = new Link();

        if(Configuration::get('ACTIVATEAGE') == 1 && Configuration::get('AGEPRODUCTPAGE') == 1)
        {
                $existingInBdd = ProductAge::getExistInBdd($params["product"]["id_product"]);

                if($existingInBdd == true)
                {
                    $maxAge = ProductAge::getMaxAgeByProduct($params["product"]["id_product"]);

                    $imagePath = $link->getBaseLink() . 'modules/' . $this->name .'/views/img/'.$maxAge.'.png';
                    $this->smarty->assign(array(
                        'img' => $imagePath
                    ));

                    return $this->display(__FILE__,'views/templates/hook/productAgePageProduct.tpl');
                }

        }
    }
    //

    //page home
    public function hookDisplayContentWrapperBottom($params)
    {

        $link = new Link();
        if(Configuration::get('ACTIVATEAGE') == 1 && Configuration::get('AGEHOMEACTIVE') == 1)
        {
            if($this->context->controller->php_self == "index")
            {

                $imgFolderPath = _PS_MODULE_DIR_ . $this->name . '/views/img/';

                $images = scandir($imgFolderPath);

                $imagePaths = array();
                foreach ($images as $image) {
                    if ($image != '.' && $image != '..') {
                        $imagePaths[] = $link->getBaseLink() . 'modules/' . $this->name . '/views/img/' . $image;
                    }
                }

                natsort($imagePaths);

                $this->smarty->assign(array(
                    'imgPath' => $imagePaths
                ));
        
                
                return $this->display(__FILE__,'views/templates/hook/displayContentWrapperTop.tpl');

            }

        }
    }

    public function hookDisplayHeader()
    {
        if(Configuration::get('ACTIVATEAGE') == 1)
        {
            if(_PS_VERSION_ < '8.0.0')
            {
                $this->context->controller->registerStylesheet('css_carousel','modules/productbyage/views/css/style-1_7.css');
            }
            else{
                
                $this->context->controller->registerStylesheet('css_carousel','modules/productbyage/views/css/style.css');
            }

            if($this->context->controller->page_name == 'module-productbyage-productage')
            {
                $this->context->controller->registerStylesheet('css_carousel','modules/productbyage/views/css/style_front_controller.css');
            }
        }
    }
    //

    //ProductList
    public function hookDisplayProductListReviews($params)
    {
        $link = new Link();

        if(Configuration::get('ACTIVATEAGE') == 1 && Configuration::get('AGEPRODUCTLIST') == 1)
        {

            $product_id = $params["product"]->id;

            $existBdd = ProductAge::getExistInBdd($product_id);

            if($existBdd)
            {
                $getAge = ProductAge::getProductAgeByProductId($product_id);
                
                $minAgeProduct = $getAge[0]["min_age"];
                $maxAgeProduct = $getAge[0]["max_age"];
                $imagePath = $link->getBaseLink() . 'modules/' . $this->name .'/views/img/'.$maxAgeProduct.'.png';

                $this->smarty->assign(array(
                    'min_age' => $minAgeProduct,
                    'max_age' => $maxAgeProduct,
                    'switch_text' => Configuration::get('ACTIVETEXTAGEPRODUCTLIST'),
                    'switch_logo' => Configuration::get('ACTIVELOGOAGEPRODUCTLIST'),
                    'img' => $imagePath
                ));

                return $this->display(__FILE__,'views/templates/hook/productListReviews.tpl');
            }

        }

    }
    //

    //Left Column Category
    public function hookDisplayLeftColumn($params)
    {
        if(Configuration::get('ACTIVATEAGE') == 1)
        {
            $link = new Link();

            $imgFolderPath = _PS_MODULE_DIR_ . $this->name . '/views/img/';

            $images = scandir($imgFolderPath);

            $imagePaths = array();
            foreach ($images as $image) {
                if ($image != '.' && $image != '..') {
                    $imagePaths[] = $link->getBaseLink() . 'modules/' . $this->name . '/views/img/' . $image;
                }
            }

            natsort($imagePaths);

            $this->smarty->assign(array(
                'imgPath' => $imagePaths
            ));
            
            return $this->display(__FILE__, 'views/templates/hook/leftColumn.tpl');
        }
    }
    //
//
}
<?php

use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Presenter\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

class ProductByAgeProductAgeModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        $dataAge = Tools::getValue('age');
        $link = new Link();

        $products = $this->getProducts($dataAge);
        $baseUrl = $link->getBaseLink();

        $this->context->smarty->assign(array(
            'products' => $products,
            'base_url' => $baseUrl,
            'noProductsMessage' => empty($products) ? $this->l('No product found') : null
        ));

        return $this->setTemplate('module:productbyage/views/templates/front/product_age_front_view.tpl');

    }


    public function getProducts($age)
    {
        $customer = $this->context->customer->id;
        
        $db = Db::getInstance();
        $request = 'SELECT DISTINCT id_product FROM ' ._DB_PREFIX_.'product_age WHERE max_age = ' . $age;
        $result = $db->executeS($request);

        $products = [];

        foreach($result as $rs){

            if($rs["id_product"] != 0)
            {
                $products[] = new Product($rs["id_product"], false, $this->context->language->id);
            }
            
        }


        $assembler = new ProductAssembler($this->context);

        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = new ProductListingPresenter(
            new ImageRetriever(
                $this->context->link
            ),
            $this->context->link,
            new PriceFormatter(),
            new ProductColorsRetriever(),
            $this->context->getTranslator()
        );

        $products_for_template = array();


        foreach ($products as $rawProduct) {
            
            $rawProduct = (array) $rawProduct;
            $products_for_template[] = $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct(['id_product' => $rawProduct['id']]),
                $this->context->language
            );
        }
        
        return $products_for_template;
    }
}
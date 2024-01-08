<?php

class ProductAge extends ObjectModel
{
    public $id_product_age;
    public $id_product;
    public $min_age;
    public $max_age;

    public static function getProductAgeByProductId($id_product)
    {
        $sql = 'SELECT * FROM '._DB_PREFIX_.'product_age WHERE id_product = '.(int)$id_product;

        return DB::getInstance()->executeS($sql);
    }

    public static function insertAgeProduct($id_product, $min_age, $max_age)
    {
        $sql = 'INSERT INTO '._DB_PREFIX_.'product_age (id_product, min_age, max_age) VALUES('.(int)$id_product.','.(int)$min_age.','.(int)$max_age.')';

        return DB::getInstance()->execute($sql);
    }

    public static function updateAgeProduct($id_product, $min_age, $max_age)
    {
        $sql = 'UPDATE '._DB_PREFIX_.'product_age SET min_age = ' . (int)$min_age . ', max_age = ' . (int)$max_age . '
        WHERE id_product = '.(int)$id_product;

        return DB::getInstance()->execute($sql);
    }

    public static function getExistInBdd($id_product)
    {
        $sql = 'SELECT id_product FROM '._DB_PREFIX_.'product_age WHERE id_product = '.(int)$id_product;

        return DB::getInstance()->getValue($sql);
    }
}
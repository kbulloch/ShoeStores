<?php

    class Brand
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getid()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function save() //CREATE
        {
            //check for existing brand before creating a new one
            //do not save to database if already existing
            $existing_brand = Brand::findByName($this->getName());

            if($existing_brand == null){
                $statement = $GLOBALS['DB']->query("INSERT INTO brands (name)
                                                    VALUES ('{$this->getName()}')
                                                    RETURNING id;");
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                $this->setId($result['id']);
            }
        }

        function getStores()
        {
            $stores = array();
            $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands
                                    JOIN brands_stores ON (brands.id = brands_stores.brand_id)
                                    JOIN stores ON (stores.id = brands_stores.store_id)
                                    WHERE brand_id = {$this->getId()};");
            foreach($returned_stores as $store) {
                $name = $store['name'];
                $id = $store['id'];
                $new_store = new Store($name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        function notInStore($a_store)
        {
            //checks if a given brand name has already been listed at $this store
            $stores_stocking = $this->getStores();
            $check_name = $a_store->getName();
            foreach($stores_stocking as $element){
                if($element->getName() == $check_name) {
                    return false;
                }
            }
            return true;
        }

        function addStore($new_store)
        {
            //check for existing store
            //to avoid duplicate entries in database
            $existing_store = Store::findByName($new_store->getName());

            if($existing_store == null){
                $new_store->save();
                $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id)
                                      VALUES ({$this->getId()}, {$new_store->getId()});");
            }
            else {
                if ($this->notInStore($new_store)) {
                $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id)
                                      VALUES ({$this->getId()}, {$existing_store->getId()});");
                }
            }


        }

        static function getAll() //READ ALL
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = [];
            foreach($returned_brands as $element) {
                $name = $element['name'];
                $id = $element['id'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        static function deleteAll() //DESTROY ALL
        {
            $GLOBALS['DB']->exec("DELETE FROM brands *;");
        }

        static function find($search_id) //READ SINGLE
        {
            $found_brand = null;
            $brands = Brand::getAll();
            foreach($brands as $my_brand) {
                $brand_id = $my_brand->getId();
                if ($brand_id == $search_id) {
                    $found_brand = $my_brand;
                }
            }
            return $found_brand;
        }

        static function findByName($search_name)
        {
            $found_brand = null;
            $all_brands = Brand::getAll();
            foreach($all_brands as $brand){
                $brand_name = $brand->getName();
                if ($brand_name == $search_name){
                    $found_brand = $brand;
                }
            }
            return $found_brand;
        }
    }
?>

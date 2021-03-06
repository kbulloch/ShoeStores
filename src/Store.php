<?php

    class Store
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
            //check for existing store before saving a new one
            //do not save to database if already existing
            $existing_store = Store::findByName($this->getName());

            if($existing_store == null){
                $statement = $GLOBALS['DB']->query("INSERT INTO stores (name)
                                                    VALUES ('{$this->getName()}')
                                                    RETURNING id;");
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                $this->setId($result['id']);
            }
        }

        function update($new_name) //UPDATE
        {
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}'
                                  WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete() //DESTROY
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
        }


        function getBrands()
        {
            $brands = array();
            $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores
                                    JOIN brands_stores ON (stores.id = brands_stores.store_id)
                                    JOIN brands ON (brands.id = brands_stores.brand_id)
                                    WHERE store_id = {$this->getId()};");
            foreach($returned_brands as $brand) {
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        function notStocking($a_brand)
        {
            //checks if a given brand name has already been listed at $this store
            $brands_listed = $this->getBrands();
            $check_name = $a_brand->getName();
            foreach($brands_listed as $element){
                if($element->getName() == $check_name) {
                    return false;
                }
            }
            return true;
        }

        function addBrand($new_brand)
        {

            //check for existing store
            //to avoid duplicate entries in database
            $existing_brand = Brand::findByName($new_brand->getName());

            if($existing_brand == null){
                $new_brand->save();
                $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id)
                                      VALUES ({$new_brand->getId()}, {$this->getId()});");
            }
            else {
                if ($this->notStocking($new_brand)) {
                    $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id)
                                          VALUES ({$existing_brand->getId()}, {$this->getId()});");
                }
            }
        }

        static function getAll() //READ ALL
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = [];
            foreach($returned_stores as $element) {
                $name = $element['name'];
                $id = $element['id'];
                $new_store = new Store($name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function deleteAll() //DESTROY ALL
        {
            $GLOBALS['DB']->exec("DELETE FROM stores *;");
        }

        static function find($search_id) //READ SINGLE
        {
            $found_store = null;
            $stores = Store::getAll();
            foreach($stores as $my_store) {
                $store_id = $my_store->getId();
                if ($store_id == $search_id) {
                    $found_store = $my_store;
                }
            }
            return $found_store;
        }

        static function findByName($search_name)
        {
            $found_store = null;
            $all_stores = Store::getAll();
            foreach($all_stores as $store){
                $store_name = $store->getName();
                if ($store_name == $search_name){
                    $found_store = $store;
                }
            }
            return $found_store;
        }
    }
?>

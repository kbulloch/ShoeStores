<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoe_stores_test');

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Doc Marten";
            $test_brand = new Brand($name);

            //Act
            $result = $test_brand->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_setName()
        {
            //Arrange
            $name = "Doc Marten";
            $test_brand = new Brand($name);

            $new_name = "Niwell";

            //Act
            $test_brand->setName($new_name);

            //Assert
            $this->assertEquals($new_name, $test_brand->getName());
        }

        function test_getId()
        {
            //Arrange
            $name = "Doc Marten";
            $id = 777;
            $test_brand = new Brand($name, $id);

            //Act
            $result = $test_brand->getId();

            //Assert
            $this->assertEquals(777, $result);
        }

        function test_setId()
        {
            //Arrange
            $name = "Doc Marten";
            $id = 777;
            $test_brand = new Brand($name, $id);

            //Act
            $test_brand->setId(222);

            //Assert
            $result = $test_brand->getId();
            $this->assertEquals(222, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Doc Marten";
            $test_brand = new Brand($name);

            //Act
            $test_brand->save();

            //Assert
            $result = Brand::getAll();
            $this->assertEquals($test_brand, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Doc Marten";
            $test_brand = new Brand($name);
            $test_brand->save();

            $name2 = "Niwell";
            $test_brand2 = new Brand($name2);
            $test_brand2->save();


            //Act
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }




























    }
?>

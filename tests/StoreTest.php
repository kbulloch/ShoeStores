<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Doc Marten Depo";
            $test_store = new Store($name);

            //Act
            $result = $test_store->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_setName()
        {
            //Arrange
            $name = "Doc Marten Depo";
            $test_store = new Store($name);

            $new_name = "Crudley";

            //Act
            $test_store->setName($new_name);

            //Assert
            $this->assertEquals($new_name, $test_store->getName());
        }

        function test_getId()
        {
            //Arrange
            $name = "Doc Marten Depo";
            $id = 777;
            $test_store = new Store($name, $id);

            //Act
            $result = $test_store->getId();

            //Assert
            $this->assertEquals(777, $result);
        }

        function test_setId()
        {
            //Arrange
            $name = "Doc Marten Depo";
            $id = 777;
            $test_store = new Store($name, $id);

            //Act
            $test_store->setId(222);

            //Assert
            $result = $test_store->getId();
            $this->assertEquals(222, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Doc Marten Depo";
            $test_store = new Store($name);

            //Act
            $test_store->save();

            //Assert
            $result = Store::getAll();
            $this->assertEquals($test_store, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Doc Marten Depo";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Crudley";
            $test_store2 = new Store($name2);
            $test_store2->save();


            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Doc Marten Depo";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Crudley";
            $test_store2 = new Store($name2);
            $test_store2->save();


            //Act
            Store::deleteAll();
            $result = Store::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Doc Marten Depo";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Crudley";
            $test_store2 = new Store($name2);
            $test_store2->save();

            //Act
            $result = Store::find($test_store->getId());

            //Assert
            $this->assertEquals($test_store, $result);
        }

        function test_delete()
        {
            //Arrange
            $name = "Doc Marten Depo";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Crudley";
            $test_store2 = new Store($name2);
            $test_store2->save();

            //Act
            $test_store->delete();

            //Assert
            $result = Store::getAll();
            $this->assertEquals([$test_store2], $result);
        }

        function test_update()
        {
            //Arrange
            $name = "Doc Marten Depo";
            $test_store = new Store($name);
            $test_store->save();

            $new_name = "Crudley";

            //Act
            $test_store->update($new_name);

            //Assert
            $this->assertEquals($new_name, $test_store->getName());
        }
























    }
?>

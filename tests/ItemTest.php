<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Item.php";

    $server = "mysql:host=localhost;dbname=inventory_test";
    $username = "root";
    $password = "root";
    $DB = new PDO($server, $username, $password);

    class ItemTest extends PHPUnit_Framework_TestCase{

        protected function tearDown()
        {
            Item::deleteAll();
        }

        function test_save()
        {
            //arrange
            $thing = "Quartz";
            $test_item = new Item($thing);

            //act
            $test_item->save();

            //assert
            $result = Item::getAll();
            $this->assertEquals($test_item, $result[0]);
        }

        function test_getAll()
        {
            $thing = "Quartz";
            $test_item = new Item($thing);
            $test_item->save();
            $thing2 = "Limestone";
            $test_item2 = new Item($thing2);
            $test_item2->save();

            $result = Item::getAll();

            $this->assertEquals([$test_item, $test_item2], $result);

        }

        function test_deleteAll()
        {
            $thing = "Quartz";
            $test_item = new Item($thing);
            $test_item->save();
            $thing2 = "Limestone";
            $test_item2 = new Item($thing2);
            $test_item2->save();

            Item::deleteAll();

            $result = Item::getAll();
            $this->assertEquals([], $result);

        }
        function test_findObject()
        {
            $thing = "Quartz";
            $test_item = new Item($thing);
            $test_item->save();
            $thing2 = "Limestone";
            $test_item2 = new Item($thing2);
            $test_item2->save();

            $search_string = $test_item->getObject();
            $result = Item::findObject($search_string);

            $this->assertEquals([$test_item], $result);
        }

    }
?>

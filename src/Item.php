<?php
    class Item {
        private $object;
        private $id;

        function __construct($object, $id = null)
        {
            $this->object= $object;
            $this->id = $id;
        }

        function getObject(){
            return $this->object;
        }

        function setObject($new_object){
            $this->object = $new_object;
        }

        function save(){
            $GLOBALS['DB']->exec("INSERT INTO collection (item) VALUES ('{$this->getObject()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_items = $GLOBALS['DB']->query("SELECT * FROM collection;");
            $items = array();
            foreach($returned_items as $item){
                $object = $item['item'];
                $id = $item['id'];
                $new_item = new Item($object, $id);
                array_push($items, $new_item);
            }
            return $items;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM collection;");
        }

        static function findObject($search_string)
        {
            $found_objects = array();
            $collection = Item::getAll();
            foreach($collection as $item) {
                $object_name = $item->getObject();
                if ($search_string == $object_name) {
                    array_push($found_objects, $item);
                }
            }
            return $found_objects;    
        }
    }
?>

<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Item.php";

    $server = 'mysql:host=localhost;dbname=inventory';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../views"
    ));

    $app->get("/", function() use ($app){
        return $app['twig']->render('index.html.twig', array('items'=> Item::getAll()));
    });

    $app->post("/add_item", function() use ($app){
        $new_item = new Item ($_POST['item_input']);
        $new_item->save();
        return $app['twig']->render('index.html.twig', array('items'=> Item::getAll()));
    });

    $app->post("/delete_all", function() use ($app) {
        Item::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/search", function() use ($app){
        $search_results = Item::findObject($_GET['search']);
        return $app['twig']->render('index.html.twig', array('objects'=> $search_results));
    });



    return $app;
 ?>

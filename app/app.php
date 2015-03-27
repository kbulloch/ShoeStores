<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=shoes');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //home page
    $app->get("/", function() use ($app) {
        return $app['twig']->render('home.twig');
    });

    //all stores view
    $app->get("/all_stores", function() use ($app) {
        $stores = Store::getAll();
        return $app['twig']->render('store_list.twig', array('stores'=>$stores));
    });

    $app->post("/create_store", function() use ($app) {
        $name = $_POST['store'];
        $new_store = new Store($name);
        $new_store->save();
        $stores = Store::getAll();
        return $app['twig']->render('store_list.twig', array('stores'=>$stores));
    });

    $app->get("/store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $brands = $store->getBrands();
        return $app['twig']->render('store.twig', array('store'=>$store, 'brands'=>$brands));
    });

    return $app;
?>

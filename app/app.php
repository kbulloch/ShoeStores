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

    //view all brands
    $app->get("/all_brands", function() use ($app) {
        $brands = Brand::getAll();
        return $app['twig']->render('brand_list.twig', array('brands'=>$brands));
    });

    //create a store
    $app->post("/create_store", function() use ($app) {
        $name = $_POST['store'];
        $new_store = new Store($name);
        $new_store->save();
        $stores = Store::getAll();
        return $app['twig']->render('store_list.twig', array('stores'=>$stores));
    });

    //create a new brand
    $app->post("/create_brand", function() use ($app) {
        $name = $_POST['brand'];
        $new_brand = new Brand($name);
        $new_brand->save();
        $brands = Brand::getAll();
        return $app['twig']->render('brand_list.twig', array('brands'=>$brands));
    });

    //single store view
    $app->get("/store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $brands = $store->getBrands();
        return $app['twig']->render('store.twig', array('store'=>$store, 'brands'=>$brands));
    });

    //view single brand
    $app->get("/brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $stores = $brand->getStores();
        return $app['twig']->render('brand.twig', array('stores'=>$stores, 'brand'=>$brand));
    });

    //Add a brand to a particular store, from that stores page
    $app->post("/store/{id}/add_brand", function($id) use ($app) {
        $store = Store::find($id);
        $name = $_POST['brand'];
        $new_brand = new Brand($name);
        $new_brand->save();
        $store->addBrand($new_brand);
        $brands = $store->getBrands();
        return $app['twig']->render('store.twig', array('store'=>$store, 'brands'=>$brands));
    });

    //add a new store listing in a particular brand page
    $app->post("/brand/{id}/add_store", function($id) use ($app) {
        $brand = Brand::find($id);
        $store = $_POST['store'];
        $new_store = new Store($store);
        $new_store->save();
        $brand->addStore($new_store);
        $stores = $brand->getStores();
        return $app['twig']->render('brand.twig', array('stores'=>$stores, 'brand'=>$brand));
    });

    //cofirmation page to clear store list
    $app->get("/confirm_delete_stores", function() use ($app) {
        return $app['twig']->render('confirm_delete_stores.twig');
    });

    //clear store list
    $app->delete("/delete_all_stores", function() use ($app) {
        Store::deleteAll();
        $stores = Store::getAll();
        return $app['twig']->render('store_list.twig', array('stores'=>$stores));
    });

    //cofirmation page to clear brand list
    $app->get("/confirm_delete_brands", function() use ($app) {
        return $app['twig']->render('confirm_delete_brands.twig');
    });

    //clear brand list
    $app->delete("/delete_all_brands", function() use ($app) {
        Brand::deleteAll();
        $brands = Brand::getAll();
        return $app['twig']->render('brand_list.twig', array('brands'=>$brands));
    });

    //edit store form page
    $app->get("/store/{id}/edit", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('edit_store.twig', array('store'=>$store));
    });

    //submit edit form with new store name
    $app->patch("/store/{id}", function($id) use ($app) {
        $new_name = $_POST['new_name'];
        $store = Store::find($id);
        $store->update($new_name);
        $brands = $store->getBrands();
        return $app['twig']->render('store.twig', array('store'=>$store, 'brands'=>$brands));
    });

    //confirm delete a single store
    $app->get("/confirm_delete_store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('confirm_delete_store.twig', array('store'=>$store));
    });

    //delete a single store
    $app->delete("/delete_store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        $stores = Store::getAll();
        return $app['twig']->render('store_list.twig', array('stores'=>$stores));
    });

    return $app;
?>

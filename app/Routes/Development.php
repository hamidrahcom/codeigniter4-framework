
<?php
$routes->environment('development', function($routes){
    $routes->get('/test', 'Test::index');
    $routes->get('/install', function (){
        $migrate = \Config\Services::migrations();
        $seeder = \Config\Database::seeder();
        try{
            $migrate->latest();
            $seeder->call('UserSeeder');
            echo 'install Done';
            header( "refresh:5;url=".base_url() );
        }
        catch (\Throwable $e){
            var_dump($e->getMessage());
        }
    });
    $routes->get('/uninstall', function (){
        $migrate = \Config\Services::migrations();
        $seeder = \Config\Database::seeder();
        try{
            $migrate->regress();
            echo 'Uninstall Done';
            header( "refresh:5;url=".base_url() );
        }
        catch (\Throwable $e){
            die(var_dump($e->getMessage()));
        }
    });
});


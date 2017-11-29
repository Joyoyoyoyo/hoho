<?php
require_once '../vendor/autoload.php';
$app=new \Silex\Application();
require_once '../config/db.php';


$app->get('/listusers',function(\Silex\Application $app){
    $users=$app['users.dao']->findMany();
    return $app['twig']->render('listuser.html.twig',['users'=>$users]);
})->bind('listusers');

$app->get('/home',function(\Silex\Application $app){
    return $app['twig']->render('home.html.twig');
})->bind('home');

$app->get('/profil/{id}',function($id,\Silex\Application $app){
    $user=$app['users.dao']->find($id);
    return $app['twig']->render('profile.html.twig',['user'=>$user]);
})->bind('profile');

$app['users.dao']=function($app){
    return new \DAO\UserDao($app['pdo']);
};

$app['pdo'] = function($app){
  $options=$app['pdo.options'];
   return new \PDO("{$options['sgbdr']}://host={$options['host']};dbname={$options['dbname']};charset={$options['charset']}", 
           $options['username'],
         $options['password'],
           array(
          \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
         \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
     ));
};

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/views',
    'twig.options'=>array(
        'debug'=>true
    )
));

$app->run();


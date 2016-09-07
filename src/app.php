<?php

use App\Session;
use App\Oauth2;
use App\Oauth2Error;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

$session = new Session();
$session->start();

$config = [
	'settings' => [
		'displayErrorDetails' => true,
	],
];

$app = new App($config);

$container = $app->getContainer();
$container['view'] = function ($container) {
	$view = new \Slim\Views\Twig('templates', ['cache' => false]);
	$view->addExtension(new \Slim\Views\TwigExtension(
		$container['router'],
		$container['request']->getUri()
	));
	return $view;
};

$app->get('/', function (Request $request, Response $response) use ($session) {
	return $this->view->render(
		$response,
		'index.html.twig',
		['user' => $session->get('user'), 'error' => $request->getQueryParam('error')]
	);
});

$app->get('/authorize', function (Request $request, Response $response) {
	Oauth2::create()->authorize($response);
})->setName('authorize');

$app->get('/callback', function (Request $request, Response $response) {
	try {
		Oauth2::create()->callback($request, $response);
	} catch (\Exception $e) {
		$response->withRedirect(
			Oauth2::APP_URL . '?' . http_build_query(['error' => $e->getMessage()]),
			401
		);
		exit;
	}
});

return $app;

<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Routing\Route;

final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
        $router->addRoute('lorem', 'Lorem:lorem');
        $router->addRoute('<action>', [
            'presenter' => 'User',
            'action' => [
                Route::PATTERN => '\b(login|logout|register)\b'
            ]
        ]);

//		$router->addRoute('<presenter>/<action>[/<id>]', 'Lorem:default');
		return $router;
	}
}

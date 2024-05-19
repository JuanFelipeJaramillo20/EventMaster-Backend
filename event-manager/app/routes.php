<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Actions\User\CreateUserAction;
use App\Application\Actions\User\UpdateUserAction;
use App\Application\Actions\User\DeleteUserAction;
use App\Application\Actions\User\LoginAction;
use App\Application\Actions\Event\ListEventsAction;
use App\Application\Actions\Event\ViewEventAction;
use App\Application\Actions\Event\CreateEventAction;
use App\Application\Actions\Event\UpdateEventAction;
use App\Application\Actions\Event\DeleteEventAction;
use App\Application\Actions\Event\GetEventAttendeesAction;
use App\Application\Actions\Event\AddUserToEventAction;
use App\Application\Actions\Event\RemoveUserFromEventAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Middleware\TokenAuthenticationMiddleware;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->post('', CreateUserAction::class);
        $group->get('/{id}', ViewUserAction::class);
        $group->put('/{id}', UpdateUserAction::class);
        $group->delete('/{id}', DeleteUserAction::class);
    });

    $tokenMiddleware = new TokenAuthenticationMiddleware('secret_key_test');


    $app->group('/events', function (Group $group) use ($tokenMiddleware) {
       $group->get('', ListEventsAction::class);
       $group->post('', CreateEventAction::class);
       $group->get('/{id}', ViewEventAction::class);
       $group->put('/{id}', UpdateEventAction::class);
       $group->delete('/{id}', DeleteEventAction::class);
       $group->get('/{id}/attendees', GetEventAttendeesAction::class);
       $group->post('/{id}/addAttendee', AddUserToEventAction::class);
       $group->post('/{id}/removeAttendee', RemoveUserFromEventAction::class);
    })->add($tokenMiddleware);

    $app->post('/login',  LoginAction::class);

    $app->post('/register', CreateUserAction::class);
};

<?php

namespace App\Controllers;

use App\Entities\View;
use App\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class UserController
{

    private UserRepository $repository;
    private View $view;

    public function __construct(
        UserRepository $repository,
        View $view
    ) {
        $this->repository = $repository;
        $this->view = $view;
    }

    private function isAuthorized(array $credentials): bool
    {
        $credentials = [
            'name' => filter_var($credentials['name'], FILTER_SANITIZE_STRING),
            'password' => md5(filter_var($credentials['password'], FILTER_SANITIZE_STRING))
        ];

        return $this->repository->checkForRole($credentials);
    }

    private function index(Request $request)
    {

        print $this->view->render(
            'login.twig',
            []
        );
    }

    private function login(Request $request)
    {
        session_start();

        try {

            $authorized = $this->isAuthorized($request->query->all());

            if ($authorized) {
                $_SESSION['auth'] = $authorized;

                header('Location: /', true, 303);
                die();
            } else {
                $_SESSION = [];
                session_destroy();

                print $this->view->render(
                    'login.twig',
                    [
                        'error' => "Не правильные реквизиты доступа!"
                    ]
                );
            }

        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

    private function logout()
    {
        session_start();

        $_SESSION = [];

        session_destroy();

        header('Location: /', true, 303);
        die();
    }

    public function handler(Request $request, string $action)
    {

        switch ($action) {
            case "login":

                try {
                    $this->login($request);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }

                break;
            case "logout":

                $this->logout();

                break;
            default:

                $this->index($request);

                break;
        }


    }

}

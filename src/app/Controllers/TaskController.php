<?php

namespace App\Controllers;

use App\Entities\View;
use App\Repositories\TaskRepository;
use Symfony\Component\HttpFoundation\Request;

class TaskController
{

    private $repository;
    private $view;

    public function __construct(
        TaskRepository $repository,
        View $view
    ) {
        $this->repository = $repository;
        $this->view = $view;
    }

    private function index(Request $request)
    {
        session_start();

        try {

            $limit = 3;
            $offset = $request->get('page') > 0 ? ((int) $request->get('page') - 1) * $limit : 0;
            $sort = $request->get('sort') ?? 'name';
            $order = $request->get('order') ?? 'ASC';

            $currentPage = $request->get('page') ?? 1;
            $tasks = $this->repository->getAll();

            $data = $this->repository->getData($sort, $order, $limit, $offset);
            if (empty($data)) {
                throw new \Exception('Задача не найдена!');
            }

            print $this->view->render(
                'index.twig',
                [
                    'authorized' => isset($_SESSION['auth']),
                    'data' => $data,
                    'tasks' => $tasks,
                    'pages' => ceil($tasks / $limit),
                    'current_page' => $currentPage,
                    'sort' => $sort,
                    'order' => $order
                ]
            );

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    private function create(Request $request)
    {

        $name = filter_var($request->get('name', FILTER_SANITIZE_STRING));
        $email = filter_var($request->get('email', FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL));
        $text = filter_var($request->get('task', FILTER_SANITIZE_STRING));

        if ($name && $email && $text) {
            $this->repository->setTask($name, $email, $text);
        }

        header('Location: /message', true, 303);
        die();
    }

    private function message()
    {

        print $this->view->render(
            'message.twig',
            [
                'message' => 'Запись успешно создана!'
            ]
        );
    }

    private function update(Request $request)
    {
        session_start();

        $this->repository->updateStatus((int) $request->get('id'));

        $limit = 3;
        $offset = $request->get('page') > 0 ? ((int) $request->get('page') - 1) * $limit : 0;
        $sort = $request->get('sort') ?? 'name';
        $order = $request->get('order') ?? 'ASC';

        $currentPage = $request->get('page') ?? 1;
        $tasks = $this->repository->getAll();

        $data = $this->repository->getData($sort, $order, $limit, $offset);
        if (empty($data)) {
            throw new \Exception('Задача не найдена!');
        }

        print $this->view->render(
            'index.twig',
            [
                'authorized' => isset($_SESSION['auth']),
                'data' => $data,
                'tasks' => $tasks,
                'pages' => ceil($tasks / $limit),
                'current_page' => $currentPage,
                'sort' => $sort,
                'order' => $order
            ]
        );
    }

    private function change(Request $request)
    {
        session_start();

        if ($_SESSION['auth']) {
            $id = filter_var($request->get("id", FILTER_SANITIZE_NUMBER_INT));
            $text = filter_var($request->get("task", FILTER_SANITIZE_STRING));

            $this->repository->changeTask($id, $text);

            $limit = 3;
            $offset = $request->get('page') > 0 ? ((int) $request->get('page') - 1) * $limit : 0;
            $sort = $request->get('sort') ?? 'name';
            $order = $request->get('order') ?? 'ASC';

            $currentPage = $request->get('page') ?? 1;
            $tasks = $this->repository->getAll();

            $data = $this->repository->getData($sort, $order, $limit, $offset);
            if (empty($data)) {
                throw new \Exception('Задача не найдена!');
            }

            print $this->view->render(
                'index.twig',
                [
                    'authorized' => isset($_SESSION['auth']),
                    'data' => $data,
                    'tasks' => $tasks,
                    'pages' => ceil($tasks / $limit),
                    'current_page' => $currentPage,
                    'sort' => $sort,
                    'order' => $order
                ]
            );
        } else {
            header('Location: /login', true, 303);
            die();
        }

    }

    public function handler(Request $request, string $action)
    {

        switch ($action) {
            case "create":

                try {
                    $this->create($request);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }

                break;
            case "message":

                $this->message();

                break;
            case "update":

                $this->update($request);

                break;
            case "change":

                $this->change($request);

                break;
            default:

                $this->index($request);

                break;
        }


    }

}

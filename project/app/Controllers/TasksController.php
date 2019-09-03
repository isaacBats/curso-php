<?php

namespace App\Controllers;

use App\Models\Task;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequest;

class TasksController extends BaseController
{
    public function getListTaskAction ($response) {

        $tasks = Task::all();

        return $this->renderHTML('tasks.twig', compact('tasks'));
    }

    public function getTasks (ServerRequest $request)
    {
        $tasks = Task::all();

        return new JsonResponse($tasks);
    }

    public function createTask (ServerRequest $request) {
        $data = json_decode($request->getBody()->getContents(), true);
        $task = new Task();
        $task->description = $data['description'];
        $task->done = 0;
        $task->save();

        return new EmptyResponse(201);
    }

    public function editTask (ServerRequest $request)
    {
        $data = json_decode($request->getBody()->getContents(), true);
        $id = $request->getAttribute('id');
        $task = Task::find($id);
        $task->done = $data['done'];
        $task->save();

        return new JsonResponse($task);
    }

    public function deleteTask (ServerRequest $request) {
        $id = $request->getAttribute('id');
        $task = Task::find($id);
        $task->delete();

        return new EmptyResponse(204);
    }
}
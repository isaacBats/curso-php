<?php

namespace App\Controllers;

class TasksController extends BaseController
{
    public function getListTaskAction ($response) {

        $tasks = [
                [
                    'id' => 1,
                    'description' => 'Aprender inglés',
                    'done' => false
                ],
                [
                    'id' => 1,
                    'description' => 'Hacer la tarea',
                    'done' => true
                ],
                [
                    'id' => 1,
                    'description' => 'Pasear al perro',
                    'done' => false
                ],
                [
                    'id' => 1,
                    'description' => 'Ver el curso de introducción a PHP',
                    'done' => false
                ]
            ];
            return $this->renderHTML('tasks.twig', compact('tasks'));
    }
}
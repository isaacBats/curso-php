<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    public function index ($response) {

        return $this->renderHTML('admin.twig');
    }
}
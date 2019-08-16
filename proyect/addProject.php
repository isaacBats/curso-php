<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once 'vendor/autoload.php';

    use Illuminate\Database\Capsule\Manager as Capsule;

    $capsule = new Capsule;

    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => '127.0.0.1:3307',
        'database'  => 'php_cursos',
        'username'  => 'root',
        'password'  => 'mysql',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    if ( !empty($_POST) ) {
        $project = new App\Models\Project();
        $project->title = $_POST['title'];
        $project->description = $_POST['description'];
        $project->save();
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Project</title>
    <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
    crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
    </header>
    <section>
        <h1>Add Project</h1>
        <form method="post" action="addProject.php">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title" aria-describedby="titleHelp" placeholder="Project">
            <small id="titleHelp" class="form-text text-muted">Get your Project.</small>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" class="form-control" id="description">
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </section>
</body>
</html>
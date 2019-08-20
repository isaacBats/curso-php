<?php

    if ( !empty($_POST) ) {
        $job = new App\Models\Job();
        $job->title = $_POST['title'];
        $job->description = $_POST['description'];
        $job->save();
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Job</title>
    <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
    crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
    </header>
    <section>
        <h1>Add Job</h1>
        <form method="post" action="addJob.php">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title" aria-describedby="titleHelp" placeholder="Dev">
            <small id="titleHelp" class="form-text text-muted">Get a Job.</small>
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
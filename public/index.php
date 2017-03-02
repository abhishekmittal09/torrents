<?php

include '../vendor/autoload.php';

use abhishekmittal09\torrents;

torrents\App::init();

$errors = new stdClass();

if (isset($_FILES['uploads'])) {
    foreach ($_FILES['uploads']['name'] as $key => $file) {
        $errors->upload[] = torrents\Files::upload($key);
    }
}

if (isset($_POST['downloads'])) {
    foreach ($_POST['downloads'] as $key => $file) {
        $errors->move[] = torrents\Files::move($key);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Torrents</h1>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panel-group">
                <form action="Upload" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="uploads">Select file to upload:</label>
                        <input type="file" name="uploads[]" id="uploads" multiple>
                    </div>

                    <?php if (isset($errors->upload)) { ?>
                        <?php if ($errors->upload[0]->error) { ?>
                            <div class="alert alert-warning">
                                <ul class="list-unstyled">
                                    <?php foreach ($errors->upload as $status) { ?>
                                        <li><?= $status->error ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-success">
                                <ul class="list-unstyled">
                                    <li>Successfully uploaded torrents.</li>
                                </ul>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <input class="btn btn-default" type="submit" value="Upload File" name="submit">
                </form>
            </div>

            <hr/>

            <div class="panel-group">
                <h1>Pending Torrents</h1>

                <form action="Move" method="post">
                    <table class="table">
                        <?php
                        $i = 0;
                        foreach (new DirectoryIterator(UPLOAD_DIR) as $file) {
                            if ($file->isDot() || $file->isDir()) {
                                continue;
                            }
                            ?>
                            <tr>
                                <td>
                                    <input title="File Name" type='checkbox' name='downloads[]'
                                           value='<?= htmlspecialchars($file) ?>'>
                                </td>
                                <td>
                                    <?= $file ?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        if ($i == 0) {
                            echo 'There are no pending torrent files.';
                        }

                        ?>
                    </table>

                    <?php if (isset($errors->move)) { ?>
                        <?php if ($errors->move[0]->error) { ?>
                            <div class="alert alert-warning">
                                <ul class="list-unstyled">
                                    <?php foreach ($errors->move as $status) { ?>
                                        <li><?= $status->error ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-success">
                                <ul class="list-unstyled">
                                    <li>Successfully moved torrents.</li>
                                </ul>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <input class="btn btn-default" type="submit" value="Submit">
                </form>
            </div>

            <hr/>

            <div class="panel-group">
                <h1>Active Torrents</h1>

                <table class="table">
                    <?php

                    $i = 0;
                    foreach (new DirectoryIterator(ACTIVE_DIR) as $file) {
                        if ($file->isDot() || $file->isDir()) {
                            continue;
                        }
                        ?>
                        <tr>
                            <td>
                                <input title="File Name" type='checkbox' name='downloads[]'
                                       value='<?= htmlspecialchars($file) ?>'>
                            </td>
                            <td>
                                <?= $file ?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    if ($i == 0) {
                        echo 'There are no currently active files.';
                    }

                    ?>
                </table>
            </div>

            <hr/>

            <div class="panel-group">
                <h1>Start Torrent Daemon</h1>

                <form action="Daemon" method="post">
                    <input class="btn btn-default" type="submit" value="Start"><br>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
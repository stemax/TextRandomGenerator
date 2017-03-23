<?php
/***
 * Example of using of TextGenerator class file
 */
use RandomText\TextGenerator;
if (file_exists('TextGenerator.php')) {
    include_once('TextGenerator.php');
} else {
    die('TextGenerator class not found!');
}

TextGenerator::initialize(isset($_REQUEST['lang']) ? $_REQUEST['lang'] : 'eng');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Text Random Generator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
          integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-12">
            <div class="jumbotron">
                <h1>Text Template Generator!</h1>

                <p>This is an example to show the potential of text generation.</p>

                <p>
                    <?= TextGenerator::generateRandomSentences(1, 5); ?>
                </p>
            </div>
            <div class="row">
                <?php
                for ($i = 1; $i <= 3; $i++) {
                    ?>
                    <div class="col-xs-6 col-lg-4">
                        <h2><?= TextGenerator::generateRandomHeader(); ?></h2>
                        <?= TextGenerator::generateRandomSentences(5, 5); ?>
                        <p><a role="button" href="#"
                              class="btn btn-default"><?= TextGenerator::generateRandomSentences(1, 1); ?> »</a></p>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="jumbotron">
                <h1>Message example</h1>

                <p style="text-align: justify;"><?= TextGenerator::generateRandomSentences(rand(5, 12), rand(3, 7)); ?></p>

                <p><a class="btn btn-primary btn-lg" href="#"
                      role="button"><?= TextGenerator::generateRandomSentences(1, 1); ?></a></p>
            </div>
            <div class="row">
                <?php
                for ($i = 1; $i <= 3; $i++) {
                    ?>
                    <div class="col-xs-6 col-lg-4">
                        <h2><?= TextGenerator::generateRandomHeader(); ?></h2>
                        <?= TextGenerator::generateRandomSentences(5, 5); ?>
                        <p><a role="button" href="#"
                              class="btn btn-default"><?= TextGenerator::generateRandomSentences(1, 1); ?> »</a></p>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="jumbotron">
                <h1>API example:</h1>

                <p style="text-align: justify;">API secret: <?= TextGenerator::generateRandomString(30); ?></p>

                <p style="text-align: justify;">Password: <?= TextGenerator::generateRandomString(12, true); ?></p>
            </div>
            <div class="jumbotron">
                <h1>User data generate:</h1>
                <table class="table table-hover">
                    <tr>
                        <th>Picture</th>
                        <th>First Name</th>
                        <th>Second Name</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Birthday</th>
                        <th>Email</th>
                        <th>Login</th>
                        <th>Password</th>
                    </tr>
                    <?php
                    for ($i = 0; $i < 25; $i++) {
                        $gender = rand(0, 1) ? 'Male' : 'Female';
                        $firstname = TextGenerator::generateFirstName($gender);
                        $lastname = TextGenerator::generateLastName($gender);
                        $age = TextGenerator::generateYearsOld(18, 68);
                        $birthday = TextGenerator::generateBirthday($age);
                        $email = TextGenerator::generateEmail($firstname, $lastname, $birthday);
                        $login = TextGenerator::generateLogin($firstname, $lastname, $birthday);
                        $password = TextGenerator::generateRandomString(12, true);
                        ?>
                        <tr>
                            <td><img height="25"
                                     src="https://graph.facebook.com/<?= rand(500000, 1000000); ?>/picture?type=square"/>
                            </td>
                            <td><?= $firstname ?></td>
                            <td><?= $lastname ?></td>
                            <td><?= $gender; ?></td>
                            <td><?= $age; ?></td>
                            <td><?= $birthday; ?></td>
                            <td><?= $email; ?></td>
                            <td><?= $login; ?></td>
                            <td><?= $password; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
            <div class="jumbotron">
                <h1>Car info example:</h1>
                <p style="text-align: justify;">Vin code: <?= TextGenerator::generateVinCode(); ?></p>
            </div>
        </div>
    </div>
    <hr>
    <footer>
        <p>&copy; <?= date('Y'); ?> Company "<?= TextGenerator::generateRandomSentences(1, 1); ?>", Inc.</p>
    </footer>
</div>
</body>
</html>
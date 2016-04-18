<?php

class TextGenerator
{
    public static $words, $symbols, $symbols_pronouns, $question_words, $popular_verbs;

    public function initialize()
    {
        $lang = isset($_REQUEST['lang']) ? $_REQUEST['lang'] : 'eng';
        if (!file_exists($lang)) $lang = 'eng';
        self::$words = explode("\n", file_get_contents($lang . '/words.txt'));
        self::$symbols_pronouns = explode("\n", file_get_contents($lang . '/pronouns.txt'));
        self::$question_words = explode("\n", file_get_contents($lang . '/question_words.txt'));
        self::$popular_verbs = explode("\n", file_get_contents($lang . '/popular_verbs.txt'));
    }

    public function generateRandomSentences($c_sent = 5, $c_words = 0)
    {
        $sentences = [];
        for ($i = 0; $i < $c_sent; $i++) {
            $sentence = '';
            $c_words = ($c_words ? $c_words : rand(2, 15));
            $is_question = false;
            for ($j = 0; $j < $c_words; $j++) {
                //start sentence
                if (!$sentence) {
                    $is_question_now = rand(0, 100);
                    if ($is_question_now > 80) {
                        $start_word = self::$question_words[rand(0, count(self::$question_words) - 1)];
                        $is_question = true;
                    } else if ($is_question_now < 60) {
                        $start_word = self::$symbols_pronouns[rand(0, count(self::$symbols_pronouns) - 1)];
                    } else {
                        $start_word = self::$popular_verbs[rand(0, count(self::$popular_verbs) - 1)];
                    }
                    $sentence = self::multi_mb_ucfirst($start_word);
                }

                $sentence .= ' ';

                $r = rand(0, 100);
                if ($r < 80) {
                    $sentence .= self::$words[rand(0, count(self::$words) - 1)];
                } else {
                    $r = rand(0, 100);
                    if ($r < 70) {
                        $sentence .= self::$symbols_pronouns[rand(0, count(self::$symbols_pronouns) - 1)];
                    } else {
                        $sentence .= self::$popular_verbs[rand(0, count(self::$popular_verbs) - 1)];

                    }
                }

                //end sentence
                if ($j + 1 == $c_words) {
                    if ($is_question) {
                        $sentence .= '?';
                    } else {
                        $r = rand(0, 100);
                        if ($r > 80) $sentence .= '!'; else $sentence .= '.';
                    }

                }
            }

            $r = rand(0, 100);
            if ($r < 80 && $c_sent != 1) {
                $sentence .= '<br/>';
            } elseif ($c_sent > 1) $sentence .= ' ';

            $sentences[] = $sentence;
        }
        $result = implode('', $sentences);
        return $result;
    }

    function generateRandomHeader()
    {
        return self::multi_mb_ucfirst(self::$popular_verbs[rand(0, count(self::$popular_verbs) - 1)] . ' ' . self::$words[rand(0, count(self::$words) - 1)]);
    }

    function multi_mb_ucfirst($str)
    {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc . mb_substr($str, 1);
    }

    public static function generateRandomString($length = 10, $spec = false)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($spec) $characters .= '.,+-()*&^%$#@!;';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

TextGenerator::initialize();
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

        <div class="col-xs-12 col-sm-9">
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
            <!--/row-->
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
            <!--/row-->
        </div>
        <!--/.col-xs-12.col-sm-9-->
    </div>
    <!--/row-->

    <hr>

    <footer>
        <p>&copy; 2016 Company "<?= TextGenerator::generateRandomSentences(1, 1); ?>", Inc.</p>
    </footer>

</div>
</body>
</html>
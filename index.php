<?php

class TextGenerator
{
    public static $lang, $words, $symbols, $symbols_pronouns, $question_words, $popular_verbs, $male_firstnames, $female_firstnames, $surnames;

    public function initialize()
    {
        $lang = isset($_REQUEST['lang']) ? $_REQUEST['lang'] : 'eng';
        if (!file_exists($lang)) $lang = 'eng';
        self::$lang = $lang;
        self::$words = explode("\n", file_get_contents($lang . '/words.txt'));
        self::$symbols_pronouns = explode("\n", file_get_contents($lang . '/pronouns.txt'));
        self::$question_words = explode("\n", file_get_contents($lang . '/question_words.txt'));
        self::$popular_verbs = explode("\n", file_get_contents($lang . '/popular_verbs.txt'));
        self::$male_firstnames = explode("\n", file_get_contents($lang . '/male_firstnames.txt'));
        self::$female_firstnames = explode("\n", file_get_contents($lang . '/female_firstnames.txt'));
        self::$surnames = explode("\n", file_get_contents($lang . '/surnames.txt'));
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
        if ($spec) $characters .= '.+-()*&^%$#@!;';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function generateFirstName($gender='Male')
    {
        if ($gender=='Male')
        {
            return ucfirst(strtolower(self::$male_firstnames[rand(0, count(self::$male_firstnames) - 1)]));
        }else
        {
            return ucfirst(strtolower(self::$female_firstnames[rand(0, count(self::$female_firstnames) - 1)]));
        }
    }

    public static function generateLastName($gender='Male')
    {
        $surname = trim(ucfirst(strtolower(self::$surnames[rand(0, count(self::$surnames) - 1)])));
        if (self::$lang=='rus' && $gender=='Female')
        {
            $surname.='а';
        }
        return $surname;
    }

    public static function generateYearsOld($min=18, $max=91)
    {
        return rand($min,$max);
    }

    public static function generateBirthday($age)
    {
        $bd_year = date('Y') - $age;
        $bd_month = sprintf('%02d',rand(1,12));
        $bd_day = sprintf('%02d',rand(1,28));
        return $bd_year.'-'.$bd_month.'-'.$bd_day;
    }

    public static function generateEmail($firstname, $lastname, $birthday)
    {
        return self::generateLogin($firstname, $lastname, $birthday).'@gmail.com';
    }

    public static function generateLogin($firstname, $lastname, $birthday)
    {
        if (self::$lang=='rus') {
            $firstname = self::translitRusText($firstname);
            $lastname = self::translitRusText($lastname);
        }
        $login = strtolower(trim(substr($firstname,0,7)).(rand(0,1)?'.':'.').trim((substr($lastname,0,9))).(rand(0,1)?'.':'.').trim(str_replace('-','',$birthday)));
        return $login;
    }

    public static function translitRusText($str)
    {
        $tr = array(
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
            "Д"=>"D","Е"=>"E","Ё"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
            "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
            "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
            "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
            "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"e","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya"
        );
        return strtr($str,$tr);
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

        <div class="col-xs-12 col-sm-12">
            <?php /**/ ?>
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

            <?php /**/ ?>
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
                            <td><img height="25" src="https://graph.facebook.com/<?=rand(500000,1000000);?>/picture?type=square" /></td>
                            <td><?= $firstname ?></td>
                            <td><?= $lastname ?></td>
                            <td><?= $gender; ?></td>
                            <td><?= $age; ?></td>
                            <td><?= $birthday; ?></td>
                            <td><?= $login.'@gmail.com'; ?></td>
                            <td><?= $login; ?></td>
                            <td><?= $password; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
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
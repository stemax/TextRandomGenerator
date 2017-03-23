<?php
namespace RandomText;

class TextGenerator
{
    public static $lang, $words, $symbols, $symbols_pronouns, $question_words, $popular_verbs, $male_firstnames, $female_firstnames, $surnames, $vincodes;

    /***
     * Loading words from language files
     * @param string $lang
     */
    public static function initialize($lang = 'eng')
    {
        if (!file_exists($lang)) $lang = 'eng';
        self::$lang = $lang;
        self::$words = explode("\n", file_get_contents($lang . '/words.txt'));
        self::$symbols_pronouns = explode("\n", file_get_contents($lang . '/pronouns.txt'));
        self::$question_words = explode("\n", file_get_contents($lang . '/question_words.txt'));
        self::$popular_verbs = explode("\n", file_get_contents($lang . '/popular_verbs.txt'));
        self::$male_firstnames = explode("\n", file_get_contents($lang . '/male_firstnames.txt'));
        self::$female_firstnames = explode("\n", file_get_contents($lang . '/female_firstnames.txt'));
        self::$surnames = explode("\n", file_get_contents($lang . '/surnames.txt'));
        self::$vincodes = explode("\n", file_get_contents($lang . '/vincodes.txt'));
    }

    /***
     * Generate random sentences string
     *
     * @param int $c_sent
     * @param int $c_words
     * @return string
     */
    public static function generateRandomSentences($c_sent = 5, $c_words = 0)
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

    /***
     * Generate random string for header
     *
     * @return string
     */
    function generateRandomHeader()
    {
        return self::multi_mb_ucfirst(self::$popular_verbs[rand(0, count(self::$popular_verbs) - 1)] . ' ' . self::$words[rand(0, count(self::$words) - 1)]);
    }

    /***
     * Additional method for do upper case for input string
     * @param $str
     * @return string
     */
    public static function multi_mb_ucfirst($str)
    {
        return mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1);
    }

    /***
     * Method for generate random string (with special symbols)
     *
     * @param int $length
     * @param bool $spec
     * @return string
     */
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

    /***
     * Generate random First Name from file (by gender)
     *
     * @param string $gender
     * @return string
     */
    public static function generateFirstName($gender = 'Male')
    {
        if ($gender == 'Male') {
            return ucfirst(strtolower(self::$male_firstnames[rand(0, count(self::$male_firstnames) - 1)]));
        } else {
            return ucfirst(strtolower(self::$female_firstnames[rand(0, count(self::$female_firstnames) - 1)]));
        }
    }

    /***
     *Generate random First Name from file (by gender)
     *
     * @param string $gender
     * @return string
     */
    public static function generateLastName($gender = 'Male')
    {
        $surname = trim(ucfirst(strtolower(self::$surnames[rand(0, count(self::$surnames) - 1)])));
        if (self::$lang == 'rus' && $gender == 'Female') {
            $surname .= 'а';
        }
        return $surname;
    }

    /***
     * Generate random year value (18..91)
     *
     * @param int $min
     * @param int $max
     * @return int
     */
    public static function generateYearsOld($min = 18, $max = 91)
    {
        return rand($min, $max);
    }

    /***
     * Generate random birthday string by age
     *
     * @param $age
     * @return string
     */
    public static function generateBirthday($age)
    {
        $bd_year = date('Y') - $age;
        $bd_month = sprintf('%02d', rand(1, 12));
        $bd_day = sprintf('%02d', rand(1, 28));
        return $bd_year . '-' . $bd_month . '-' . $bd_day;
    }

    /***
     * Generate email (by firstname,lastname,birthday )
     *
     * @param $firstname
     * @param $lastname
     * @param $birthday
     * @return string
     */
    public static function generateEmail($firstname, $lastname, $birthday)
    {
        $email_parts = ['gmail.com', 'hotmail.com', 'yandex.com', 'yahoo.com', 'outlook.com', 'mail.com'];
        return self::generateLogin($firstname, $lastname, $birthday) . '@' . ($email_parts[rand(0, count($email_parts) - 1)]);
    }

    /***
     * Generate login string
     *
     * @param $firstname
     * @param $lastname
     * @param $birthday
     * @return string
     */
    public static function generateLogin($firstname, $lastname, $birthday)
    {
        if (self::$lang == 'rus') {
            $firstname = self::translitRusText($firstname);
            $lastname = self::translitRusText($lastname);
        }
        $login = strtolower(trim(substr($firstname, 0, 7)) . (rand(0, 1) ? '.' : '.') . trim((substr($lastname, 0, 9))) . (rand(0, 1) ? '.' : '.') . trim(str_replace('-', '', $birthday)));
        return $login;
    }

    /***
     * Get random VinCode
     */
    public static function generateVinCode()
    {
            return strtoupper(self::$vincodes[rand(0, count(self::$vincodes) - 1)]);
    }

    /***
     * Help method for translation rus text to translit
     *
     * @param $str
     * @return string
     */
    public static function translitRusText($str)
    {
        $tr = array(
            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
            "Д" => "D", "Е" => "E", "Ё" => "E", "Ж" => "J", "З" => "Z", "И" => "I",
            "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
            "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
            "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
            "Ш" => "SH", "Щ" => "SCH", "Ъ" => "", "Ы" => "YI", "Ь" => "",
            "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "e", "ж" => "j",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "y",
            "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya"
        );
        return strtr($str, $tr);
    }

}
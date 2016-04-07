<?php

class TextGenerator
{
    public static $words, $symbols, $symbols_pronouns, $question_words, $popular_verbs;

    public function initialize()
    {
        self::$words = explode("\n", file_get_contents('words.txt'));
        self::$symbols = [', ', '! <br/>', '. <br/>', '? <br/>'];
        self::$symbols_pronouns = ['I', 'you', 'we', 'they', 'he', 'she', 'it', 'us', 'them', 'him', 'his', 'her', 'we are'];
        self::$question_words = ['who', 'where', 'when', 'why', 'what', 'which', 'how', 'do you', 'am I', 'does he', 'did'];
        self::$popular_verbs = ['accept', 'allow', 'ask', 'believe', 'borrow', 'break', 'bring', 'buy', 'can able', 'cancel', 'change', 'clean', 'comb', 'complain', 'cough', 'count', 'cut', 'dance', 'draw', 'drink', 'drive', 'eat', 'explain', 'fall', 'fill', 'find', 'finish', 'fit', 'fix', 'fly', 'forget', 'give', 'go', 'have', 'hear', 'hurt', 'know', 'learn', 'leave', 'listen', 'live', 'look', 'lose', 'make/do', 'need', 'open', '', 'close/shut', 'organise', 'pay', 'play', 'put', 'rain', 'read', 'reply', 'run', 'say', 'see', 'sell', 'send', 'sign', 'sing', 'sit', 'sleep', 'smoke', 'speak', 'spell', 'spend', 'stand', 'start/begin', 'study', 'succeed', 'swim', 'take', 'talk', 'teach', 'tell', 'think', 'translate', 'travel', 'try', 'turn off', 'turn on', 'type', 'understand', 'use', 'wait', 'wake up', 'want', 'watch', 'work', 'worry', 'write'];
    }

    public function generateRandomSentences()
    {
        $sentences = [];
        $c_sent = rand(2, 20);
        $c_sent = 5;
        for ($i = 0; $i < $c_sent; $i++) {
            $sentence = '';
            $c_words = rand(2, 15);
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
                    $sentence = ucfirst($start_word);
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
            if ($r < 80) {
                $sentence .= '<br/>';
            } else $sentence .= ' ';

            $sentences[] = $sentence;
        }
        $result = implode('', $sentences);
        return $result;
    }

    function generateRandomHeader()
    {
        return ucfirst(self::$popular_verbs[rand(0, count(self::$popular_verbs) - 1)].' '.self::$words[rand(0, count(self::$words) - 1)]);
    }
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateRandowWorld()
{
	$length = rand(1,5);
	$characters_glas = 'aeiouvy';
	$popular_letters = 'bcklmstx';
	$characters_soglas = 'bcdfghjklmnpqrstvwxz';
	$characters_length_glas = strlen($characters_glas);
	$characters_length_soglas = strlen($characters_soglas);
	$randomString = array();

	$gl_podr = $sgl_podr = $i = 0;
	while ($i<$length)
	{
		if (count($randomString) == 0)	
		{
			$is_glas_first = (bool)rand(0,1);
		}
		if ($is_glas_first)
		{
			$randomString[] = $characters_glas[rand(0, $characters_length_glas - 1)];
			$gl_podr++;
		}
		
		$is_glas_now = (bool)rand(0,1);
		if ($is_glas_now && $gl_podr<2)
		{
			$randomString[] = $characters_glas[rand(0, $characters_length_glas - 1)];
			$gl_podr++;
			$sgl_podr=0;
		}else
		{
			$is_popular_now = (bool)rand(0,10);
			$sgl_podr++;
			if ($is_popular_now<8) 
			{
				$randomString[] = $popular_letters[rand(0, $popular_letters - 1)];
			}
			else {$randomString[] = $characters_soglas[rand(0, $characters_length_soglas - 1)];}
			$gl_podr=0;
		}
		
		$i++;
	}
    return implode($randomString);	
}


/*
for ($j=0;$j<60;$j++)
{
	$is_dot_now = rand(0,100);
    $is_pronouns_now = rand($j,60);
    if ($is_pronouns_now>$j*7) {
        $quest = $question_words[rand(0,count($question_words)-1)];
        echo ' '.$quest.' ';
    }
    if ($is_pronouns_now>$j*5) {
        $pron = $symbols_pronouns[rand(0,count($symbols_pronouns)-1)];
        echo ' '.$pron.' ';
    }
	echo $words[rand(0,count($words)-1)];
	echo ($is_dot_now<90?' ':$symbols[rand(0,count($symbols)-1)]);
}
*/
TextGenerator::initialize();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Text Random Generator</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
            <div class="jumbotron">
                <h1>Text Template Generator!</h1>
                <p>This is an example to show the potential of text generation.</p>
            </div>
            <div class="row">
                <div class="col-xs-6 col-lg-4">
                    <h2><?=TextGenerator::generateRandomHeader();?></h2>
                    
                        <?=TextGenerator::generateRandomSentences();?>
                    <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
                </div><!--/.col-xs-6.col-lg-4-->
                <div class="col-xs-6 col-lg-4">
                    <h2><?=TextGenerator::generateRandomHeader();?></h2>
                    <p><?=TextGenerator::generateRandomSentences();?></p>
                    <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
                </div><!--/.col-xs-6.col-lg-4-->
                <div class="col-xs-6 col-lg-4">
                    <h2><?=TextGenerator::generateRandomHeader();?></h2>
                    <p><?=TextGenerator::generateRandomSentences();?></p>
                    <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
                </div><!--/.col-xs-6.col-lg-4-->
                <div class="col-xs-6 col-lg-4">
                    <h2><?=TextGenerator::generateRandomHeader();?></h2>
                    <p><?=TextGenerator::generateRandomSentences();?></p>
                    <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
                </div><!--/.col-xs-6.col-lg-4-->
                <div class="col-xs-6 col-lg-4">
                    <h2><?=TextGenerator::generateRandomHeader();?></h2>
                    <p><?=TextGenerator::generateRandomSentences();?></p>
                    <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
                </div><!--/.col-xs-6.col-lg-4-->
                <div class="col-xs-6 col-lg-4">
                    <h2><?=TextGenerator::generateRandomHeader();?></h2>
                    <p><?=TextGenerator::generateRandomSentences();?></p>
                    <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
                </div><!--/.col-xs-6.col-lg-4-->
            </div><!--/row-->
        </div><!--/.col-xs-12.col-sm-9-->
    </div><!--/row-->

    <hr>

    <footer>
        <p>&copy; 2016 Company, Inc.</p>
    </footer>

</div>
</body>
</html>
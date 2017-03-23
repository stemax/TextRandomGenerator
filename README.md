# TextRandomGenerator
> Generate random sentences.

## General methods:
*initialize($lang = 'eng')* - Use always for load words from language files
*generateRandomHeader()* - Generate random string for header
*generateRandomString($length = 10, $spec = false)* - Method for generate random string (with special symbols)
*generateRandomSentences($count_of_sentences = 5, $count_of_words = 0)* - Generate random sentences string
*generateFirstName($gender = 'Male'* - Generate random First Name from file (by gender)
*generateLastName($gender = 'Male')* - Generate random First Name from file (by gender)
*generateYearsOld($min = 18, $max = 91)* - Generate random year value (18..91)
*generateBirthday($age)* - Generate random birthday string by age
*generateEmail($firstname, $lastname, $birthday)* - Generate email (by firstname,lastname,birthday )
*generateLogin($firstname, $lastname, $birthday)* - Generate login (by firstname,lastname,birthday )

Example of fast using:
'''PHP
use RandomText\TextGenerator;
//...

TextGenerator::initialize();

$api_secret = TextGenerator::generateRandomString(30);
$api_password = TextGenerator::generateRandomString(12, true);
$gender = rand(0, 1) ? 'Male' : 'Female';
$firstname = TextGenerator::generateFirstName($gender);
$lastname = TextGenerator::generateLastName($gender);
$age = TextGenerator::generateYearsOld(18, 68);
$birthday = TextGenerator::generateBirthday($age);
$email = TextGenerator::generateEmail($firstname, $lastname, $birthday);
$login = TextGenerator::generateLogin($firstname, $lastname, $birthday);
$password = TextGenerator::generateRandomString(12, true);

'''
> Allowed 2 languages RUS and ENG(by default)


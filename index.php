<?php
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

	$gl_podr = $sgl_podr = 0;
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

for ($j=0;$j<60;$j++)
{
	$symbols = [', ','! <br/>', '. <br/>','? <br/>'];
	$is_dot_now = rand(0,100);
	echo generateRandowWorld();
	echo ($is_dot_now<90?' ':$symbols[rand(0,count($symbols))]);
}
?>
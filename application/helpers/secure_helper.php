<?php  
	function cetak($str)
	{
		echo htmlentities($str, ENT_QUOTES, 'UTF-8');
	}

	function hash_string($string)
	{
		$hashed_string = password_hash($string, PASSWORD_BCRYPT, ['cost'=>9]);
		return $hashed_string;
	}

	function hash_verify($plain_text='', $hashed_string='')
	{
		$hashed_string = password_verify($plain_text, $hashed_string);
		return $hashed_string;
	}
?>
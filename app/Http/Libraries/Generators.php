<?php 
namespace App\Http\Libraries;
use App;
use Illuminate\Database\Eloquent\Model;
class Generators
{	
	public static function generateCode($jml_char,$angka=false)
	{
		if ($angka)
		$possible = '0123456789';
		else
			$possible = '2988546XFREVERYESUSMEMBERKATSTUSPUSATKULAKANDTCM773BYAREFBUDIANTJANCEVL';
		$code = '';
		$characters = $jml_char;
		$i = 0;
		while ($i < $characters) {
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code ;
	}
	public static function autousername()
	{
	 	$autousername = App\AutoUsername::findOrFail(1);

	    if ($autousername->username) $currentUsername = $autousername->username; else $currentUsername = 'AAA000';
	    $isUnique = false;
	    while (!$isUnique)
	    {
	        $currentUsername++;
	        //CEK sudah ada belum di tabel username
	        $result = App\AutoUsername::where('username', '=', $currentUsername)->first();
	        if ($result === null) 
	        {
        		$autousername->username = $currentUsername;
        		$autousername->save();
        		$isUnique = true;
        	}
	    }
	    return $currentUsername;
	}
}

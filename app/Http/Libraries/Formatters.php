<?php 
namespace App\Http\Libraries;
class Formatters
{	
	public static function currencyformat($angka,$satuan='true',$backsign='')
	{
		$angka = (int) $angka;
		switch ($angka){
			default :
				if ($satuan)
					$output = "Rp. ".number_format($angka,0,",",".").$backsign;
				else
					$output = number_format($angka,0,",",".");
				break;
		}
		return $output;
	}
	public static function tgl_indo($tgl,$format='') {
		$tanggal = substr($tgl,8,2);
		if ($format=='short')
			$bulan	 = substr($tgl,5,2);
		elseif ($format=='alphashort')
			$bulan	 = substr(Formatters::get_bulan(substr($tgl,5,2)),0,3);
		else
			$bulan	 = Formatters::get_bulan(substr($tgl,5,2));
		$tahun	 = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;
	}
	public static function get_bulan($bln){
		switch ($bln){
			case 1 :
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	}
}

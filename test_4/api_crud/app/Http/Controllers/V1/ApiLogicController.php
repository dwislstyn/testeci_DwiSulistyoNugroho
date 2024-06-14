<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\ParameterException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use stdClass;

class ApiLogicController extends Controller
{
    private static $units = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
    private static $tens = ['sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'];
    private static $tens_place = ['', '', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'];
    private static $thousands = ['', 'ribu', 'juta', 'milyar', 'triliun'];

    private $output;

    public function __construct()
    {
        $this->output = new stdClass();
        $this->output->responseCode = null;
        $this->output->responseDesc = null;
    }
    

    public function nomor_satu(Request $request)
    {
        if(empty($request->kode_tipe) || !in_array($request->kode_tipe, ['1','2','3'])){
            throw new ParameterException("Parameter kode tipe tidak valid");
        }

        if(empty($request->jumlah_baris) || !is_numeric($request->jumlah_baris)){
            throw new ParameterException("Parameter jumlah baris tidak valid.");
        }

        $result     = '';
        $jmlBaris   = $request->jumlah_baris;

        if($request->kode_tipe == '1'){
            for($a=$jmlBaris;$a>0;$a--){

                for($b=$jmlBaris;$b>=$a;$b--){
                    $result .= "*";
                }

                $result .= "<br>";
            }
        }
        
        if($request->kode_tipe == '2'){
            for($a=1; $a<=$jmlBaris; $a++){
                
                for($c=$jmlBaris; $c>=$a; $c-=1){
                    $result .= "*";
                }
                
                $result .= "<br>";
            }
        }
        
        if($request->kode_tipe == '3'){
            for($a=$jmlBaris;$a>0;$a--){
                for($i=1; $i<=$a; $i++){
                    $result .= " &nbsp";
                }
                for($a1=$jmlBaris;$a1>=$a;$a1--){
                    $result .= "*";
                }
                $result .= "<br>";
            }
        }

        return $result;
    }

    public function nomor_dua(Request $request)
    {
        if(empty($request->angka) || !is_numeric($request->angka) ||strlen($request->angka) <= 6){
            throw new ParameterException("Parameter angka tidak valid.");
        }

        $angka = intval($request->angka);
        $convertNilai = self::convert($angka);
        
        $result = new stdClass();
        $result->nilai = "Rp ".number_format($angka, 0, ",",".").",-";
        $result->nilai_terbilang = $convertNilai.' rupiah';

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Convert nilai berhasil';
        $this->output->responseData = $result;

        return response()->json($this->output);
    }

    private function convert(int $number)
    {
        if ($number == 0) {
            return 'nol';
        }

        return self::convertToWords($number);
    }

    private function convertToWords($number)
    {
        $number = (string)$number;
        $length = strlen($number);
        $levels = (int)(($length + 2) / 3);
        $max_length = $levels * 3;
        $number = substr('00' . $number, -$max_length);
        $levels = str_split($number, 3);

        $result = [];
        foreach ($levels as $index => $level) {
            $level = (int)$level;
            if ($level == 0) {
                continue;
            }

            $level_text = '';
            if ($level < 20) {
                $level_text = self::translateUnits($level);
            } else {
                $units = $level % 10;
                $tens = (int)($level / 10) % 10;
                $hundreds = (int)($level / 100) % 10;

                if ($hundreds) {
                    $level_text .= self::$units[$hundreds] . ' ratus ';
                }
                if ($tens) {
                    $level_text .= ($tens < 2 ? self::$tens[$tens * 10 + $units] : self::$tens_place[$tens] . ' ' . self::$units[$units]);
                } else {
                    $level_text .= self::$units[$units];
                }
            }

            $unit_level = count($levels) - $index - 1;
            if ($unit_level > 0) {
                $level_text .= ' ' . self::$thousands[$unit_level];
            }

            $result[] = $level_text;
        }

        return implode(' ', $result);
    }

    private function translateUnits($number)
    {
        if ($number < 10) {
            return self::$units[$number];
        } else {
            return self::$tens[$number - 10];
        }
    }
}

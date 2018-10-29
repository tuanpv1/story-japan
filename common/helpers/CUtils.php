<?php
namespace common\helpers;

class CUtils
{
    /**
     * @param float $number
     * @return string (1.000)
     */
    public static function formatNumber($number)
    {
        $formatter = new \yii\i18n\Formatter();
        $formatter->thousandSeparator = ',';
        $formatter->decimalSeparator = '.';
//       return number_format($number, 2, '.', ',');
        return $formatter->asInteger($number);
    }

    public static function substr($str, $length, $minword = 3)
    {
        $sub = '';
        $len = 0;
        foreach (explode(' ', $str) as $word) {
            $part = (($sub != '') ? ' ' : '') . $word;
            $sub .= $part;
            $len += strlen($part);
            if (strlen($word) > $minword && strlen($sub) >= $length) {
                break;
            }
        }
        return $sub . (($len < strlen($str)) ? '...' : '');
    }
}

?>

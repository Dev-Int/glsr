<?php
/**
 * TimeHelper Helpers for the dates of the GLSR application.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace App\Helper;

/**
 * Time helper.
 *
 * @category Helper
 */
class TimeHelper
{
    /**
     * get Easter date.
     *
     * @param integer $pYear
     * @return timestamp
     */
    private function getEaster($pYear = null)
    {
        if (is_null($pYear)) {
            $pYear = (int)date('Y');
        }
        $nDate = $pYear - 1900;
        $pAa = $nDate%19;
        $pBb = floor(((7*$pAa)+1)/19);
        $pCc = ((11*$pAa)-$pBb+4)%29;
        $pDd = floor($nDate/4);
        $pEe = ($nDate-$pCc+$pDd+31)%7;
        $pResult = 25-$pCc-$pEe;
        if ($pResult > 0) {
            $pEaster = strtotime($pYear.'/04/'.$pResult);
        } else {
            $pEaster = strtotime($pYear.'/03/'.(31+$pResult));
        }
        return $pEaster;
    }

    /**
     * get the next open day.
     *
     * @link http://codes-sources.commentcamarche.net/source/38705-jours-ouvres Working days
     * @author Malalam
     *
     * @param timestamp $pDate Order date
     * @param integer   $pDays Delta for the day of delivery
     * @return integer  Delta next business day
     */
    public function getNextOpenDay($pDate, $pDays)
    {
        $aBankHolidays = ['1_1', '1_5', '8_5', '14_7', '15_8', '1_11', '11_11', '25_12', ];
        if (function_exists('easter_date')) {
            $pEaster = easter_date((int)date('Y', $pDate));
        } else {
            $pEaster = $this->getEaster((int)date('Y', $pDate));
        }
        $aBankHolidays[] = date('j_n', $pEaster);
        $aBankHolidays[] = date('j_n', $pEaster + (86400*39));
        $aBankHolidays[] = date('j_n', $pEaster + (86400*49));

        $pEnd = strtotime('+' . $pDays . ' day', $pDate);
        $idn = 0;
        while ($idn < $pEnd) {
            if (in_array(date('w', $pEnd), array(0, 6)) || in_array(date('j_n', $pEnd), $aBankHolidays)) {
                $pEnd = strtotime('+1 day', $pEnd);
                $pDays ++;
            }
            $idn = strtotime('+1 day', $idn);
        }
        return $pDays;
    }
}

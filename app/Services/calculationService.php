<?php
namespace App\Services;


use Carbon\Carbon;

class calculationService{

    CONST j2000Epoch               = 2440587.5;
    CONST marsEarthDayDifferance   =  1.027491252;
    CONST unixEpoch                =  2451545.0;


    /**
     * Prepare needed values for msd and mtc equations and returning ΔtJ2000
     * @param $utc
     * @return float
     */
    protected function prepareData($utc): float
    {
        $date          = Carbon::parse('1970-01-01');
        $milliSeconds = $date->diffInMilliseconds($utc);
        $jd_ut         = self::j2000Epoch + ($milliSeconds /8.64E7);
        $jd_tt         = $jd_ut + (37 + 32.184) / 86400;

        return $jd_tt - self::unixEpoch;
    }

    /**
     * Get ΔtJ2000 from prepare data and pass it to the needed methods and return the data
     * @param $utcTime
     * @return array
     */
    public function returnValue($utcTime): array
    {
        $j2000 = $this->prepareData($utcTime);
        $msd   = $this->marsSolDate($j2000);
        $mtc   = $this->hoursToTimeFormat($this->coordinatedMarsTime($msd));

        return [
            'marsSolDate'         => $msd,
            'coordinatedMarsTime' => $mtc
        ];
    }

    /**
     * Mars Sol Date equation
     * @param $j2000
     * @return float
     */
    protected function marsSolDate($j2000): float
    {
        return  ((($j2000 - 4.5) / self::marsEarthDayDifferance) + 44796.0 - 0.00096);
    }

    /**
     * Martian Coordinated Time equation
     * @param $msd
     * @return int
     */
    protected function coordinatedMarsTime($msd): int
    {
        return (24 * $msd) % 24;
    }

    protected function hoursToTimeFormat($hours): string
    {
        $hours = $hours * 3600;
        $hours = floor($hours / 3600);
        if ($hours < 10) $hours = "0". $hours;
        $hoursReminder = $hours % 3600;
        $minutes =floor($hoursReminder / 60);
        if ($minutes < 10) $minutes = "0".$minutes;
        $seconds = round($hoursReminder % 60);
        if ($seconds < 10) $seconds = "0".$seconds;
        return $hours.":".$minutes . ":" . $seconds;
    }
}

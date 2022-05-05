<?php

/**
 * Calendar Class
 * @author Cavid Huseynov
 */

class Calendar
{
    const WEEKDAYS = 7;

    private int $maxWeeks = 6;

    public function getMonth($year, $month): array
    {
        $daysInfo = $this->getDaysInfo($year, $month);


        if ($daysInfo['firstWeekdayNumberOfMonth'] != 1) {

            $firstWeek = $this->getFirstWeek($year, $month, '1');

            foreach ($firstWeek['days'] as $week => $weekdays) {
                $daysInfo['days'][$week] = $weekdays + $daysInfo['days'][$week];
            }
        }

        $lastWeeks = $this->getLastWeeks($year, $month, $daysInfo['lastDayOfMonth'], $daysInfo['lastWeekdayNumberOfMonth'], $daysInfo['totalWeeks']);

        foreach ($lastWeeks['days'] as $week => $weekdays) {

            if (!array_key_exists($week, $daysInfo['days'])) {
                $daysInfo['days'][$week] = [];
            }
            $daysInfo['days'][$week] = $daysInfo['days'][$week] + $weekdays;
        }

        return $daysInfo;
    }


    private function getFirstWeek(string $year, string $month, string $day): array
    {
        $datetime = new \DateTime();

        $datetime->setDate($year, $month, $day);

        $datetime->modify('monday this week');

        $lastDayOfMonth = $datetime->format('t'); // 28 - 31

        $y = $datetime->format('Y');
        $m = $datetime->format('m');
        $d = $datetime->format('d');

        return $this->getDaysInfo($y, $m, $d, $lastDayOfMonth, false);

    }

    private function getLastWeeks(string $year, string $month, string $day, $lastWeekdayNumberOfMonth, $totalWeeks): array
    {
        $datetime = new \DateTime();

        $datetime->setDate($year, $month, $day);

        $datetime->modify('first day of next month');


        $lastDayOfMonth = self::WEEKDAYS - $lastWeekdayNumberOfMonth;

        if ($totalWeeks < $this->maxWeeks) {
            $lastDayOfMonth += (self::WEEKDAYS * ($this->maxWeeks - $totalWeeks));
        }

        $y = $datetime->format('Y');
        $m = $datetime->format('m');
        $d = $datetime->format('d');

        return $this->getDaysInfo($y, $m, $d, $lastDayOfMonth, false);
    }

    private function getDaysInfo($year, $month, $day = 1, $lastDayOfMonth = null, $isIncluded = true)
    {
        $datetime = new \DateTime();

        $datetime->setDate($year, $month, $day);

        $days = [];

        if (!$lastDayOfMonth) {
            $lastDayOfMonth = $datetime->format('t'); // 28 - 31;
        }

        $firstWeekdayNumberOfMonth = $datetime->format('N');

        foreach (range($day, $lastDayOfMonth) as $dayNum) {
            $datetime->setDate($year, $month, $dayNum);

            $days[$datetime->format('W')][$datetime->format('N')] = [
                'weekdayNameShort' => $datetime->format('D'),
                'weekdayNameFull' => $datetime->format('l'),
                'year' => $year,
                'month' => $month,
                'day' => $dayNum,
                'included' => $isIncluded
            ];

            $lastWeekdayNumberOfMonth = $datetime->format('N');
        }

        return [
            'lastDayOfMonth' => $lastDayOfMonth,
            'firstWeekdayNumberOfMonth' => $firstWeekdayNumberOfMonth,
            'lastWeekdayNumberOfMonth' => $lastWeekdayNumberOfMonth,
            'totalWeeks' => count($days),
            'days' => $days
        ];
    }
}
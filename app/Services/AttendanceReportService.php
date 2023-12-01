<?php

namespace App\Services;

use App\Student;

use App\Models\attendance;
use App\Models\LeaveApplication;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/**
 * Class AttendanceService
 * @package App\Services
 */
class AttendanceReportService
{
    /**
     * @return mixed
     */
    public function getAttendances()
    {
        return attendance::select(['user_id', 'attendance_date'])
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->pluck('user_id', 'attendance_date');
            });

    }


    public function getLeave()
    {
        return LeaveApplication::select(['user_id', 'startDate','leave_type_id'])
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->pluck('user_id', 'startDate','leave_type_id');
            });

    }

    /**
     * @param int $year
     * @param int $month
     * @param array $attendances
     */
    public function storeAttendances(int $year, int $month, array $attendances)
    {
        Attendance::query()
            ->whereYear('event_date', $year)
            ->whereMonth('event_date', $month)
            ->delete();

        foreach ($attendances as $key => $dates) {
            list(, $studentId) = explode('_', $key);
            $student = User::find($studentId);

            $studentAttendances = [];
            foreach ($dates as $date) {
                $studentAttendances[] = new Attendance(['event_date' => $date]);
            }

            $student->attendances()->saveMany($studentAttendances);
        }
    }

    /**
     * @param int $year
     * @param int $month
     * @return int
     */
    public function daysInMonth(int $year, int $month)
    {
        return now()->setYear($year)
            ->setMonth($month)
            ->daysInMonth;
    }

    /**
     * @param int $year
     * @param int $month
     * @return array
     */
    public function getAttendancePaginationLinks(int $year, int $month)
    {
        $currentDate       = now()->setYear($year)->setMonth($month)->toImmutable();
        $currentDateYear   = $currentDate->year;
        $currentDateMonth  = $currentDate->format('m');
        $previousDate      = $currentDate->subMonth();
        $previousDateYear  = $previousDate->year;
        $previousDateMonth = $previousDate->format('m');
        $nextDate          = $currentDate->addMonth();
        $nextDateYear      = $nextDate->year;
        $nextDateMonth     = $nextDate->format('m');

        $dates = [
            [
                'year'     => $previousDateYear,
                'month'    => $previousDateMonth,
                'fullName' => $this->getYearAndFullMonthName($previousDateYear, $previousDateMonth),
            ],
            [
                'year'     => $currentDateYear,
                'month'    => $currentDateMonth,
                'fullName' => $this->getYearAndFullMonthName($currentDateYear, $currentDateMonth)
            ],
        ];

        if ($year < now()->year | ($year == now()->year && $month < now()->month)) {
            $dates[] = [
                'year'     => $nextDateYear,
                'month'    => $nextDateMonth,
                'fullName' => $this->getYearAndFullMonthName($nextDateYear, $nextDateMonth)
            ];
        }

        return $dates;
    }

    /**
     * @param int $year
     * @param int $month
     * @return bool
     */
    public function isProvidedMonthGreaterThanCurrentMonth(int $year, int $month)
    {
        if ($year > now()->year) {
            return true;
        }

        if ($year == now()->year && $month > now()->month) {
            return true;
        }

        return false;
    }

    /**
     * @param int $year
     * @param int $month
     * @return string
     */
    public function getYearAndFullMonthName(int $year, int $month)
    {
        return now()->setYear($year)->setMonth($month)->format('F Y');
    }
}

<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Does the course have an end date.
 *
 * This tests whether the course end date has passed.
 *
 * @package    report_coursediagnositc
 * @copyright  2022 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_coursediagnostic;

use report_coursediagnostic\course_diagnostic_tests;

class course_enddate_test implements course_diagnostic_tests {

    /**
     * @param $course
     * @return bool
     */
    public function runTest($course)
    {
        // The course end date is in the past...
        if (!empty($course->enddate)) {
            if (($course->enddate) < time()) {
                return false;
            }

            return true;
        }

        return false;
    }
}
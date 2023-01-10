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
 * Are there students enrolled on this course.
 *
 * This tests whether a course has students enrolled onto it or not.
 *
 * @package    report_coursediagnositc
 * @copyright  2022 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_coursediagnostic;

use report_coursediagnostic\course_diagnostic_tests;

class course_studentenrolment_test implements course_diagnostic_tests {

    /**
     * @param $course
     * @return bool
     */
    public function runTest($course)
    {
        global $PAGE;
        $studentyusers = count_role_users(5, $PAGE->context);

        return (bool) $studentyusers;
    }
}
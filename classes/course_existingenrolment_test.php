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
 * Brief Description
 *
 * More indepth description.
 *
 * @package    report_coursediagnositc
 * @copyright  2023 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_coursediagnostic;

class course_existingenrolment_test implements course_diagnostic_tests
{

    /** @var string The name of the test - needed w/in the report */
    public string $testname;

    /** @var bool $testresult whether the test has passed or failed. */
    public bool $testresult;

    /**
     * @param $name
     */
    public function __construct($name) {
        $this->testname = $name;
    }
    /**
     * @param $course
     * @return bool
     */
    public function runTest($course)
    {
        // TODO: Implement runTest() method.
    }
}
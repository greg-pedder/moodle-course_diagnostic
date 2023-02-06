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
 * When Action after period is set to 'Unenrol'
 *
 * This tests if 'Enrolment period' OR 'Enrol end date' have been checked, AND
 * 'Enable user unenrol' OR 'Enable removal from groups' have been set to 'Yes'
 * This has the impact of data loss in that students & grades etc get deleted..
 * ...permanently.
 *
 * @package    report_coursediagnositc
 * @copyright  2023 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_coursediagnostic;
class course_autoenrolment_studentdatadeletion_test implements course_diagnostic_interface
{

    /** @var string The name of the test - needed w/in the report */
    public string $testname;

    /** @var object The course object */
    public object $course;

    /** @var bool $testresult whether the test has passed or failed. */
    public bool $testresult;

    /**
     * @param $name
     * @param $course
     */
    public function __construct($name, $course) {
        $this->testname = $name;
        $this->course = $course;
    }

    /**
     * @return bool
     */
    public function runTest()
    {
        global $PAGE;

        $course_enrolment_mgr = new \course_enrolment_manager($PAGE, $this->course);
        $enrolment_plugins = $course_enrolment_mgr->get_enrolment_instances(true);

        // More than one instance of an enrolment method can be created.
        // We need to filter and iterate over all the UofG instances,
        // and fail the test if at least 1 doesn't meet the rule set.
        $nothingToDisplay = true;
        foreach($enrolment_plugins as $enrolmentInstance) {
            switch($enrolmentInstance->enrol) {
                case 'gudatabase':
                    if (($enrolmentInstance->enrolperiod > 0) || !empty($enrolmentInstance->enrolenddate)) {
                        if (($enrolmentInstance->customint4 == 1) || ($enrolmentInstance->customint5 == 1)) {
                            $nothingToDisplay = false;
                            // No need to go any further...
                            break;
                        }
                    }
                    break;
            }
        }

        $this->testresult = $nothingToDisplay;
        return $this->testresult;
    }
}
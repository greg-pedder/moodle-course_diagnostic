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
 * Is Group Mode anything other than "No groups"?
 *
 * This tests whether Group Mode is set to something other than "No groups"
 * and if so, whether any groups have been defined, and are populated.
 *
 * @package    report_coursediagnositc
 * @copyright  2023 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_coursediagnostic;
class course_groupmode_test implements course_diagnostic_interface
{

    /** @var string The name of the test - needed w/in the report */
    public string $testname;

    /** @var object The course object */
    public object $course;

    /** @var bool $testresult whether the test has passed or failed. */
    public bool $testresult;

    /**
     * @param $name
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
        $definedandpopulated = true;
        if ($this->course->groupmode != NOGROUPS) {
            $groups = groups_get_all_groups($this->course->id);
            if (!empty($groups)) {
                // check if the group has at least 1 member...
                $hasmembers = 0;
                foreach($groups as $group) {
                    $groupmembercount = groups_get_members($group->id);
                    if (count($groupmembercount) > 0) {
                        // we don't need to go any further...
                        $hasmembers++;
                        break;
                    }
                }

                // Looks like the groups have no members...
                if ($hasmembers == 0) $definedandpopulated = false;

            } else {
                // Looks like the groups have no members...
                $definedandpopulated = false;
            }
        }

        $this->testresult = $definedandpopulated;

        return $this->testresult;
    }
}
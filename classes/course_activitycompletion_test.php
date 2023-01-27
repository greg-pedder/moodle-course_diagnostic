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
 * Activity completion settings when completion is off in the course.
 *
 * If Activity Completion is off in the course, have any activity completion
 * settings been set in any activities linked to the course.
 *
 * @package
 * @copyright  2023 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_coursediagnostic;
class course_activitycompletion_test implements \report_coursediagnostic\course_diagnostic_interface
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

        $this->testresult = true;
        $courseCompletion = $this->course->enablecompletion;
        $activityCompletion = true;

        // If enablecompletion is currently not set in the course...
        if ($courseCompletion == 0) {
            // Get all activities associated with the course...
            $moduleInfo = get_fast_modinfo($this->course->id);
            $modules = $moduleInfo->get_used_module_names();
            foreach ($modules as $pluginName) {
                $cm_info = $moduleInfo->get_instances_of($pluginName->get_component());
                foreach ($cm_info as $moduleName => $moduleData) {
                    if ($moduleData->completion > 0) {
                        // The 'Completion tracking' dropdown in the activity
                        // settings is something other than 'Show activity...'
                        $activityCompletion = false;
                        // We don't need to go any further.
                        break 2;
                    }
                }
            }
        }

        return $this->testresult = $activityCompletion;
    }
}
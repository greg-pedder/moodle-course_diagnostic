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
 * Has the course assignment end date been enabled
 *
 * This tests whether the assignment end date has been enabled or not.
 *
 * @package    report_coursediagnositc
 * @copyright  2023 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_coursediagnostic;
class course_assignmentenddate_test implements \report_coursediagnostic\course_diagnostic_interface
{

    /** @var string The name of the test - needed w/in the report */
    public string $testname;

    /** @var object The course object */
    public object $course;

    /** @var array $testresult whether the test has passed or failed. */
    public array $testresult;

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
        // Do any of the course assignments have an end date set...

        // Get all activities associated with the course...
        $moduleInfo = get_fast_modinfo($this->course->id);
        $assignments = $moduleInfo->get_instances_of('assign');
        $dueDateEnabled = true;
        $counter = 0;
        $assignmenturls = [];
        foreach ($assignments as $assignment) {
            if (!isset($assignment->customdata['duedate'])) {
                $counter++;
                // The cm assignment doesn't give us the path to the edit page,
                // only the view page ($assignment->url->get_path()) - which is
                // no good to us, hence the hard coded link here :-(
                $url = new \moodle_url('/course/modedit.php', ['update' => $assignment->url->param('id'), 'return' => 1]);
                $link = \html_writer::link($url, $assignment->get_name());
                $assignmenturls[] = $link;
                $dueDateEnabled = false;
            }
        }

        $this->testresult = [
            'testresult' => $dueDateEnabled,
            'assignmenturls' => $assignmenturls,
            'word1' => (($counter > 1) ? get_string('plural_1', 'report_coursediagnostic') : get_string('singular_1', 'report_coursediagnostic')),
            'word2' => (($counter > 1) ? get_string('plural_2', 'report_coursediagnostic') : get_string('singular_2', 'report_coursediagnostic'))
        ];

        return $this->testresult;
    }
}
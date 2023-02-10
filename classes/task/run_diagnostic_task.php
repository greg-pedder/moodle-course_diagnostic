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
 * Scheduled task to run the course diagnostics in the background essentially.
 *
 * The idea with this scheduled task is to prepare/prefil the cache with
 * diagnostic data - to save having it run when an end user visits the course.
 *
 * @package    report_coursediagnostic
 * @copyright  2023 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_coursediagnostic\task;

defined('MOODLE_INTERNAL') || die;

class run_diagnostic_task extends \core\task\scheduled_task
{

    /**
     * Return the task's name as shown in admin screens.
     *
     * @return string
     */
    public function get_name() {
        return get_string('scheduledname', 'report_coursediagnostic');
    }

    /**
     * Execute the task.
     */
    public function execute() {
        global $DB;

        // Trace.
        $trace = new \text_progress_trace();

        // Get the start time, we'll limit
        // how long this runs for.
        $starttime = time();

        // Get plugin config.
        $diagnosticconfig = get_config('report_coursediagnostic');

        // Are we set up?
        if (empty($diagnosticconfig->enablediagnostic)) {
            $trace->output( 'report_coursediagnostic: not enabled' );
            return false;
        }

        // Grab some things for later...
        $timelimit = $diagnosticconfig->timelimit;
        $startcourseindex = ((isset($diagnosticconfig->startcourseindex)) ? $diagnosticconfig->startcourseindex : 0);

        // Remove some things we don't need...
        unset($diagnosticconfig->enablediagnostic);
        unset($diagnosticconfig->version);
        unset($diagnosticconfig->filesizelimit);
        unset($diagnosticconfig->startcourseindex);
        unset($diagnosticconfig->timelimit);

        // Check that there are tests to perform...
        $counter = 0;
        foreach ($diagnosticconfig as $k => $v) {
            if ($v) {
                $counter++;
                // Not sure there's much point proceeding here, as we know we
                // have at least 1 test to perform.
                break;
            }
        }

        if ($counter == 0) {
            $trace->output( 'report_coursediagnostic: no tests enabled' );
            return false;
        }

        // Prepare the list of tests we need to perform...
        $testsuite = [];
        foreach($diagnosticconfig as $setting => $value) {
            if ($setting == 'enddate' && !empty($value)) $testsuite[] = 'enddate_notset';
            if (!empty($value)) $testsuite[] = $setting;
        }

        // Get the last course we processed.
        if (empty($startcourseindex)) {
            $startcourseindex = 0;
        }

        $trace->output( "report_coursediagnostic: starting at course index $startcourseindex" );

        // Get the basics of all visible courses. So we're not glomming the
        // whole of the course table, limit this to 5k records at a time.
        $courses = $DB->get_records( 'course', array('visible' => 1), '', 'id', $startcourseindex, 5000);

        // Convert courses to simple array.
        $courses = array_values( $courses );
        $highestindex = count($courses) - 1;
        $trace->output( "report_coursediagnostic: highest course index is $highestindex" );
        $trace->output( "report_coursediagnostic: configured time limit is {$timelimit} seconds" );

        // Process from current index...
        for ($i = $startcourseindex; $i <= $highestindex; $i++) {
            $course = $DB->get_record('course', array('id' => $courses[$i]->id));

            // Avoid site and front page.
            if ($course->id > 1) {
                $updatestart = microtime(true);
                $trace->output( "report_coursediagnostic: running tests for course '{$course->shortname}'" );
                $diagnostic_data = \report_coursediagnostic\coursediagnostic::run_tests($testsuite, $course->id);
                \report_coursediagnostic\coursediagnostic::prepare_cache($diagnostic_data, $course->id);
                $updateend = microtime(true);
                $updatetime = number_format($updateend - $updatestart, 4);
                $trace->output( "report_coursediagnostic: --- course {$course->shortname} took $updatetime seconds to process.");
            }
            $lastcourseprocessed = $i;

            // If we've used too much time then bail out.
            $elapsedtime = time() - $starttime;
            if ($elapsedtime > $timelimit) {
                break;
            }
        }

        // Set new value of index.
        if ($lastcourseprocessed >= $highestindex) {
            $nextcoursetoprocess = 0;
        } else {
            $nextcoursetoprocess = $lastcourseprocessed + 1;
        }
        set_config( 'startcourseindex', $nextcoursetoprocess, 'report_coursediagnostic' );
        $trace->output( "report_coursediagnostic: next course index to process is $nextcoursetoprocess" );
    }
}
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
 * Class to handle course viewed/updated events.
 *
 * Retrieve cache data, or create a new cache instance if none exists,
 * or it has since expired, before passing the data to the suite of
 * tests, and then finally adding a link to the report on the page.
 *
 * @package    report_coursediagnositc
 * @copyright  2022 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_coursediagnostic;

defined('MOODLE_INTERNAL') || die();

class observer {

    const CACHE_KEY = 'courseid:';

    /**
     * Handle the course viewed event.
     */
    public static function course_viewed(\core\event\course_viewed $event) {

        // courseid:1 appears to be the generic default course in Moodle - I don't think we need this...
        if ((!empty($event->courseid)) && $event->courseid != 1) {

            $settings_check = \report_coursediagnostic\coursediagnostic::cfg_settings_check();

            if ($settings_check) {

                \report_coursediagnostic\coursediagnostic::init_cache();
                $cache_data = \report_coursediagnostic\coursediagnostic::cache_data_exists($event->courseid);

                if ($cache_data[self::CACHE_KEY . $event->courseid]) {

                    $failed_tests = \report_coursediagnostic\coursediagnostic::parse_results($cache_data[self::CACHE_KEY . $event->courseid]);

                } else {

                    // Begin by creating the list of tests we need to perform...
                    $test_suite = \report_coursediagnostic\coursediagnostic::prepare_tests();

//                    $courseCompletion = $course->enablecompletion;
//
//                    // If enablecompletion is currently not set in the course...
//                    if ($courseCompletion == 0) {
//                        // Get all activities associated with the course...
//                        $moduleInfo = get_fast_modinfo($event->courseid);
//                        $modules = $moduleInfo->get_used_module_names();
//                        foreach ($modules as $pluginName) {
//                            $cm_info = $moduleInfo->get_instances_of($pluginName->get_component());
//                            foreach ($cm_info as $moduleName => $moduleData) {
//                                $isvisible = $moduleData->visible;
//                            }
//                        }
//                    }

                    $diagnostic_data = \report_coursediagnostic\coursediagnostic::run_tests($test_suite, $event->courseid);
                    $failed_tests = \report_coursediagnostic\coursediagnostic::fetch_test_results();
                    \report_coursediagnostic\coursediagnostic::prepare_cache($diagnostic_data, $event->courseid);

                }

                // Now hide/show the alert on the page that links to the report.
                if ($failed_tests > 0) {
                    \report_coursediagnostic\coursediagnostic::diagnostic_notification($failed_tests, $event->courseid);

                    return true;
                }

                return false;
            }

            return false;
        }

        return false;
    }

    /**
     * @param \core\event\course_updated $event
     * @return bool
     */
    public static function course_updated(\core\event\course_updated $event) {

        // Invalidate the cache for the given course id - if it exists...
        if ((!empty($event->courseid)) && $event->courseid != 1) {
            $cache = \cache::make('report_coursediagnostic', 'coursediagnosticdata');
            $cachekey = self::CACHE_KEY . $event->courseid;
            $courseid = $cache->get_many([$cachekey]);

            if ($courseid[$cachekey] != false) {
                $cache->delete($cachekey);

                global $SESSION;
                unset($SESSION->report_coursediagnostic);
                unset($SESSION->report_coursediagnosticconfig);
                return true;
            }

            return false;
        }

        return false;
    }
}

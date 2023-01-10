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
 * @package
 * @copyright  2022 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_coursediagnostic;

class coursediagnostic {

    const CACHE_KEY = 'courseid:';

    /**
     * @var object - the cache store being used by the site.
     */
    private static object $cache;

    /**
     * @var array|array[] - a simple list of ranges we can refer to
     */
    protected static array $alert_ranges = [
        'info' => [
            'min' => 1,
            'max' => 34,
            'messagetext' => 'The course has settings that need addressed.'
        ],
        'warning' => [
            'min' => 35,
            'max' => 69,
            'messagetext' => 'The course settings require your attention.'
        ],
        'error' => [
            'min' => 70,
            'max' => 100,
            'messagetext' => 'The course settings require <i>urgent</i> attention.'
        ]
    ];

    protected static array $diagnostic_data = [];

    /**
     * @return bool
     */
    public static function cfg_settings_check(): bool
    {

        global $SESSION;

        // To avoid extracting the settings values each time this event is triggered, make use of the session...
        if (!isset($SESSION->report_coursediagnosticconfig)) {
            $diagnostic_config = get_config('report_coursediagnostic');
            $SESSION->report_coursediagnostic = false;
            $SESSION->report_coursediagnosticconfig = null;
            if (property_exists($diagnostic_config, 'enablediagnostic') && $diagnostic_config->enablediagnostic) {
                $SESSION->report_coursediagnostic = true;

                // Some things we don't need however...
                unset($diagnostic_config->version);

                // Here we assign all the settings from the config object...
                $SESSION->report_coursediagnosticconfig = $diagnostic_config;
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array|false
     */
    public static function get_diagnosticsettings() {

        global $SESSION;

        if (isset($SESSION->report_coursediagnosticconfig)) {
            return get_object_vars($SESSION->report_coursediagnosticconfig);
        }

        return false;
    }

    /**
     * @return int
     */
    public static function get_settingscount() :int
    {

        $diagnostic_settings = self::get_diagnosticsettings();
        $counter = 0;
        if ($diagnostic_settings) {

            foreach ($diagnostic_settings as $k => $v) {
                if ($v) {
                    $counter++;
                }
            }
        }

        return $counter;

    }

    /**
     * @return mixed
     */
    public static function init_cache(): mixed
    {
        return self::$cache = \cache::make('report_coursediagnostic', 'coursediagnosticdata');
    }

    /**
     * @param $cachekey
     * @return mixed
     */
    public static function cache_data_exists($cachekey): mixed
    {
        $cachekey = self::CACHE_KEY . $cachekey;
        return self::$cache->get_many([$cachekey]);
    }

    /**
     * @param $diagnostic_data
     * @param $courseid
     * @return mixed
     */
    public static function prepare_cache($diagnostic_data, $courseid): mixed
    {

        // Now prepare the results for caching...
        $cache_key = self::CACHE_KEY . $courseid;
        $cache_data = [
            $cache_key => [
                $diagnostic_data
            ]
        ];

        // Cache this data set...
        return self::$cache->set_many($cache_data);
    }

    /**
     * @return array
     */
    public static function prepare_tests(): array
    {
        $diagnostic_setting = (object) self::get_diagnosticsettings();
        $testsuite = [];

        if (property_exists($diagnostic_setting, 'startdate') && $diagnostic_setting->startdate) {
            $testsuite[] = 'startdate';
        }

        if (property_exists($diagnostic_setting, 'enddate') && $diagnostic_setting->enddate) {
            $testsuite[] = 'enddate_notset';
            $testsuite[] = 'enddate';
        }

        if (property_exists($diagnostic_setting, 'visibility') && $diagnostic_setting->visibility) {
            $testsuite[] = 'visibility';
        }

        if (property_exists($diagnostic_setting, 'studentenrolment') && $diagnostic_setting->studentenrolment) {
            $testsuite[] = 'studentenrolment';
        }

        if (property_exists($diagnostic_setting, 'inactiveenrolment') && $diagnostic_setting->inactiveenrolment) {
            $testsuite[] = 'inactiveenrolment';
        }

        if (property_exists($diagnostic_setting, 'groupmodeenabled') && $diagnostic_setting->groupmodeenabled) {
            $testsuite[] = 'groupmodeenabled_notset';
            $testsuite[] = 'groupmodeenabled';
        }

        if (property_exists($diagnostic_setting, 'submissiontypes') && $diagnostic_setting->submissiontypes) {
            $testsuite[] = 'submissiontypes';
        }

        if (property_exists($diagnostic_setting, 'coursesize') && $diagnostic_setting->coursesize) {
            $testsuite[] = 'coursesize';
        }

        if (property_exists($diagnostic_setting, 'existingenrolments') && $diagnostic_setting->existingenrolments) {
            $testsuite[] = 'existingenrolments';
        }

        if (property_exists($diagnostic_setting, 'enrolmentpluginsenabled') && $diagnostic_setting->enrolmentpluginsenabled) {
            $testsuite[] = 'enrolmentpluginsenabled';
        }

        return $testsuite;
    }

    /**
     * @param $test_suite
     * @param $courseid
     * @return array
     */
    public static function run_tests($test_suite, $courseid): array
    {

        // Get all the pertinent course settings that we need...
        $course = get_course($courseid);
        // Pass this data onto our test suite...
        $factory = \diagnostic_factory::instance();

        $flag = false;
        foreach ($test_suite as $test_case) {
            if ($flag) {
                // reset and continue.
                $flag = false;
                continue;
            }

            $diagnostic_test = $factory->create_diagnostic_test_from_config($test_case, $course);

            // Some tests are a two state test, e.g. if enabled, then test.
            // If the first test fails, there's no need to perform the next.
            $stringmatch = (bool) strstr($test_case, 'notset');
            if ($stringmatch && !$diagnostic_test->testresult) {
                // Skip the next test as it's not needed.
                $flag = true;
            }

            // Assign the test result
            self::$diagnostic_data[$diagnostic_test->testname] = (bool) $diagnostic_test->testresult;
        }

        return self::$diagnostic_data;
    }

    /**
     * @return float
     */
    public static function fetch_test_results(): float
    {
        // If any of our tests have failed - have our 'alert' banner (the link to the report) display
        // Based on a % of the number of tests that have failed, display the appropriate severity banner/button
        $total_tests = count(self::$diagnostic_data);
        $passed = array_sum(self::$diagnostic_data);
        $failed = ($total_tests - $passed);
        return round($failed/$total_tests * 100);
    }

    /**
     * Examine the data that's been returned from the cache...
     * If any of our tests have failed previously have our 'alert' notification
     * (link to the report) displayed. Based on a % of the number of tests that
     * have failed, use the appropriate severity class for the alert
     *
     * @param $cache_data
     * @return float
     */
    public static function parse_results($cache_data): float
    {

        $tests = $cache_data[0];
        $total_tests = count($tests);
        $passed = array_sum($tests);
        $failed = ($total_tests - $passed);
        return round($failed/$total_tests * 100);
    }

    /**
     * @param $failed_tests
     * @param $courseid
     * @return mixed
     */
    public static function diagnostic_notification($failed_tests, $courseid): mixed
    {

        $class = '';
        $messagetext = '';
        foreach(self::$alert_ranges as $classname => $range) {
            if ($failed_tests >= $range['min'] && $failed_tests <= $range['max']) {
                $class = $classname;
                $messagetext = $range['messagetext'];
                break;
            }
        }
        $message = '<strong>' . $messagetext . '</strong> You can review what needs to be set <a class="alert-link" href="/report/coursediagnostic/index.php?courseid='.$courseid.'">on the report page</a>.';
        return \report_coursediagnostic\notification::$class($message);
    }
}

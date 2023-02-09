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
 * Class for Course Diagnostic
 *
 * Provides the functionality for running course diagnostics. This was
 * previously handled by procedural code embedded w/in the course page.
 *
 * @package    report_coursediagnositc
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

    /**
     * @var array Contains the results of all selected tests, ready for caching
     */
    protected static array $diagnostic_data = [];

    /**
     * @var bool Needed for when the settings page is submitted.
     */
    protected static bool $purgeFlag = false;

    /**
     * @return bool
     */
    public static function cfg_settings_check(): bool
    {

        global $SESSION;

        // To avoid a call to the db for the values each time this event is
        // triggered, make use of the session.
        if (!isset($SESSION->report_coursediagnosticconfig)) {
            $diagnostic_config = get_config('report_coursediagnostic');
            $SESSION->report_coursediagnostic = false;
            $SESSION->report_coursediagnosticconfig = null;
            if (property_exists($diagnostic_config, 'enablediagnostic') && $diagnostic_config->enablediagnostic) {
                $SESSION->report_coursediagnostic = true;

                // Some things we don't need however...
                unset($diagnostic_config->version);
                unset($diagnostic_config->enablediagnostic);
                unset($diagnostic_config->filesizelimit);

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
                $diagnostic_data[$courseid]
            ]
        ];

        // @todo - should we clear self::$diagnostic_data[$courseid] now?

        // Cache this data set...
        return self::$cache->set_many($cache_data);
    }

    /**
     * Called from w/in the settings page, when a change is made.
     * @return void
     */
    public static function flag_cache_for_deletion() {
        self::$purgeFlag = true;
    }

    public static function get_cache_deletion_flag() {
        return self::$purgeFlag;
    }

    /**
     * Clears the entire coursediagnosticdata cache.
     * Keep in mind that with our cronjob running and populating the cache,
     * this function destroys what could potentially be a lot of data.
     *
     * Only ^ever^ carried out when System Admin->Courses->Course diagnostic
     * Settings page is updated.
     * @return void
     */
    public static function purge_diagnostic_settings_cache() {

        // Safeguard....
        if (self::$purgeFlag) {

            // This gets set when the course_viewed event is caught.
            // Have it regenerate after any changes have been made.
            global $SESSION;
            unset($SESSION->report_coursediagnostic);
            unset($SESSION->report_coursediagnosticconfig);

            self::$cache = \cache::make('report_coursediagnostic', 'coursediagnosticdata');
            self::$cache->purge();

            // reset this now that the cache has been cleared.
            self::$purgeFlag = false;
        }
    }

    /**
     * Function that creates an array of tests to be performed.
     * Taken from the options selected in System Administration.
     *
     * To make this extendable, only generic/default tests are included here.
     * Extendability is provided by allowing end users to supply a JSON file
     * containing the names of additional tests to be carried out.
     * The filepath parameter will allow the necessary class files to be stored
     * outside of the main Moodle directory, thereby not causing any VC issues
     * if that is how the source code is being managed, for example. End users
     * only need to ensure their class follows the same format as the generic
     * tests in order for things to run.
     *
     * This will also allow the names of these additional tests to appear in
     * System Admninistration -> Course -> course diagnostic settings.
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

        if (property_exists($diagnostic_setting, 'groupmode') && $diagnostic_setting->groupmode) {
            $testsuite[] = 'groupmode';
        }

        if (property_exists($diagnostic_setting, 'submissiontypes') && $diagnostic_setting->submissiontypes) {
            $testsuite[] = 'submissiontypes';
        }

        if (property_exists($diagnostic_setting, 'activitycompletion') && $diagnostic_setting->activitycompletion) {
            $testsuite[] = 'activitycompletion';
        }

        if (property_exists($diagnostic_setting, 'coursefiles') && $diagnostic_setting->coursefiles) {
            $testsuite[] = 'coursefiles';
        }

        if (property_exists($diagnostic_setting, 'coursevideo') && $diagnostic_setting->coursevideo) {
            $testsuite[] = 'coursevideo';
        }

        if (property_exists($diagnostic_setting, 'courseaudio') && $diagnostic_setting->courseaudio) {
            $testsuite[] = 'courseaudio';
        }

        if (property_exists($diagnostic_setting, 'assignmentduedate') && $diagnostic_setting->assignmentduedate) {
            $testsuite[] = 'assignmentduedate';
        }

        if (property_exists($diagnostic_setting, 'existingenrolments') && $diagnostic_setting->existingenrolments) {
            $testsuite[] = 'existingenrolments';
        }

        if (property_exists($diagnostic_setting, 'enrolmentpluginsenabled') && $diagnostic_setting->enrolmentpluginsenabled) {
            $testsuite[] = 'enrolmentpluginsenabled';
        }

        if (property_exists($diagnostic_setting, 'selfenrolmentkey') && $diagnostic_setting->selfenrolmentkey) {
            //$testsuite[] = 'selfenrolmentkey_notset';
            $testsuite[] = 'selfenrolmentkey';
        }

        if (property_exists($diagnostic_setting, 'autoenrolment_studentdatadeletion') && $diagnostic_setting->autoenrolment_studentdatadeletion) {
            $testsuite[] = 'autoenrolment_studentdatadeletion';
        }

        // @todo - implement a mechanism for reading in any additional tests.
        // There will be a format that needs to be followed, tests should be
        // rejected otherwise.

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
        $tmpdata = [];
        foreach ($test_suite as $test_case) {
            if ($flag) {
                // reset and continue.
                $flag = false;
                continue;
            }

            $diagnostic_test = $factory->create_diagnostic_test_from_config($test_case, $course);

            // Some tests are a two state test, e.g. if 'enabled', then test.
            // If the first test fails, there's no need to perform the next.
            $stringmatch = (bool) strstr($test_case, 'notset');
            if ($stringmatch && (!$diagnostic_test->testresult || (is_array($diagnostic_test->testresult) && array_key_exists('testresult', $diagnostic_test->testresult) && !$diagnostic_test->testresult['testresult']))) {
                // Skip the next test as it's not needed.
                $flag = true;
            }

            // Assign the test result
            $tmpdata[$courseid][$diagnostic_test->testname] = $diagnostic_test->testresult;
        }

        // Before returning the results, we need to remove any of the 'notset'
        // tests that passed - this is skewing our results total and messing
        // up the colour coding for the notifications. Basically, we only need
        // to concern ourselves with the 'notset' ones if they failed. We don't
        // need to know, or care, that they passed.
        $tmp = [];
        foreach($tmpdata[$courseid] as $testname => $testresult) {
            $stringmatch = (bool) strstr($testname, 'notset');
            if ($stringmatch && ($testresult || (!empty($testresult['testresult']) && !$testresult['testresult']))) {
                // We don't need this one anymore, just continue onto the next.
                continue;
            }
            $tmp[$testname] = $testresult;
        }

        // Assign the cleaned data...
        self::$diagnostic_data[$courseid] = $tmp;

        // Return just the data for this course, not everything else...
        return self::$diagnostic_data;
    }

    /**
     * @param $courseid
     * @return float
     */
    public static function fetch_test_results($courseid): float
    {
        // If any of our tests have failed - have our 'alert' banner (the link to the report) display.
        // Based on a % of the number of tests that have failed, display the appropriate severity banner/button
        $total_tests = count(self::$diagnostic_data[$courseid]);
        $passed = [];
        foreach (self::$diagnostic_data[$courseid] as $result) {
            if (is_array($result)) {
                $passed[] = $result['testresult'];
            } else {
                $passed[] = $result;
            }
        }
        $total_passed = array_sum($passed);
        $failed = ($total_tests - $total_passed);
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
        $passed = [];
        foreach ($tests as $result) {
            if (is_array($result)) {
                $passed[] = $result['testresult'];
            } else {
                $passed[] = $result;
            }
        }
        $total_passed = array_sum($passed);
        $failed = ($total_tests - $total_passed);
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

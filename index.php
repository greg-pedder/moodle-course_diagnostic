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
 * Displays the course diagnostic results.
 *
 * This page will show, in tabular format, the options that have been selected
 * in the Settings page, along with a colour coded column to denote whether the
 * 'enabled' test has passed or failed. An information column proves further
 * details as to what impact this setting has/is having.
 *
 * @package    report_coursediagnostic
 * @copyright  2022 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

$courseid = required_param('courseid', PARAM_INT);// Course ID.
$context = context_course::instance($courseid);

$url = new moodle_url('/report/coursediagnostic/index.php', ['course' => $courseid]);
$PAGE->set_url($url);

if (!$course = $DB->get_record('course', ['id' => $courseid])) {
    print_error('invalidcourseid');
}

require_login($course);

$PAGE->set_context($context);
$PAGE->set_pagelayout('report');
$title = get_string('reporttitle', 'report_coursediagnostic');
$pagetitle = $title;
$PAGE->set_title($title);
$PAGE->set_heading(get_string('pluginname', 'report_coursediagnostic'));

$canviewreport = false;
require_capability('report/coursediagnostic:view', $context);

$output = $PAGE->get_renderer('report_coursediagnostic');

echo $output->header();
echo $output->heading($pagetitle);

// Get the config settings...
$cfg_settings = \report_coursediagnostic\coursediagnostic::cfg_settings_check();

// If the diagnostics have been enabled...
if ($cfg_settings) {

    // Check that one or more tests have been enabled...
    $diagnostic_settings_count = \report_coursediagnostic\coursediagnostic::get_settingscount();

    if ($diagnostic_settings_count <= 1) {

        $supportemail = $CFG->supportemail;
        $link = html_writer::link("mailto:{$supportemail}", get_string('system_administrator', 'report_coursediagnostic'));
        $phrase = get_string('no_tests_enabled', 'report_coursediagnostic', $link);
        if (has_capability('moodle/site:config', context_system::instance())) {
            $url = new moodle_url('/admin/settings.php', ['section' => 'coursediagnosticsettings']);
            $link = html_writer::link($url, get_string('admin_link_text', 'report_coursediagnostic'));
            $phrase = get_string('no_tests_enabled_admin', 'report_coursediagnostic', $link);
        }

        $diagnostic_content = html_writer::div($phrase, 'alert alert-info');
    } else {

        // Get the tests that have been run...
        \report_coursediagnostic\coursediagnostic::init_cache();
        $cache_data_exists = \report_coursediagnostic\coursediagnostic::cache_data_exists($courseid);
        $cache_data = [];
        // @todo - decide whether to run the test again if say, someone arrives at this page and the cache has expired.
        if ($cache_data_exists[\report_coursediagnostic\coursediagnostic::CACHE_KEY . $courseid]) {
            $cache_data = $cache_data_exists[\report_coursediagnostic\coursediagnostic::CACHE_KEY . $courseid];
        }

        if (count($cache_data) > 0) {

            // Create our base table from the config settings...
            $table = new html_table();
            $table->id = 'course-diagnostic-report';
            $tableheadings = [
                get_string('column1', 'report_coursediagnostic'),
                get_string('column2', 'report_coursediagnostic'),
                get_string('column3', 'report_coursediagnostic'),
            ];
            $table->head = $tableheadings;
            $table->data = [];
            $automaticEnrolmentsDisabled = false;

            foreach ($SESSION->report_coursediagnosticconfig as $configkey => $configvalue) {

                // @todo - refactor this - making use of some kind of table class

                // We don't need to worry about this particular value...
                if ($configkey == 'enablediagnostic') continue;

                $cell1 = new html_table_cell(get_string($configkey, 'report_coursediagnostic'));
                $cell1->attributes['class'] = 'rightalign ' . $configkey . 'cell';
                $cell2 = new html_table_cell();
                $cell2->attributes['class'] = 'leftalign ' . $configkey . 'cell';
                $cell3 = new html_table_cell($configkey);
                $cell3->text = "<span class='badge badge-secondary'>" . get_string('skipped', 'report_coursediagnostic') . "</span>";
                $cell3->attributes['class'] = 'leftalign ' . $configkey . 'cell';
                $tablecells = [];
                $tablecells[] = $cell1;

                if ($configvalue || $configvalue > 0) {

                    $cell2->text = $configkey;

                    // Bit scrappy this - refactor to account for these tests that have 2 states
                    if (array_key_exists($configkey, $cache_data[0])) {
                        $cell2->text = get_string($configkey . '_impact', 'report_coursediagnostic');
                    } else {
                        $cell2->text = get_string($configkey . '_notset_impact', 'report_coursediagnostic');
                    }

                    $cell3->text = "<span class='badge badge-danger'>" . get_string('failtext', 'report_coursediagnostic') . "</span>";

                    if (isset($cache_data[0][$configkey]) && $cache_data[0][$configkey]) {
                        $cell2->text = '';
                        $cell3->text = "<span class='badge badge-success'>" . get_string('passtext', 'report_coursediagnostic') . "</span>";
                    }

                }

                $tablecells[] = $cell2;
                $tablecells[] = $cell3;
                $row = new html_table_row($tablecells);
                $table->data[] = $row;
            }

            $diagnostic_content = html_writer::table($table);

        } else {
            $url = new moodle_url('/course/edit.php', ['id' => $courseid]);
            $link = html_writer::link($url, get_string('settings_link_text', 'report_coursediagnostic'));
            $diagnostic_content = html_writer::div(get_string('no_cache_data', 'report_coursediagnostic', $link), 'alert alert-warning');
        }
    }
} else {
    $supportemail = $CFG->supportemail;
    $link = html_writer::link("mailto:{$supportemail}", get_string('system_administrator', 'report_coursediagnostic', $supportemail));
    $phrase = get_string('not_enabled', 'report_coursediagnostic', $link);
    if (has_capability('moodle/site:config', context_system::instance())) {
        $url = new moodle_url('/admin/settings.php', ['section' => 'coursediagnosticsettings']);
        $link = html_writer::link($url, get_string('admin_link_text', 'report_coursediagnostic'));
        $phrase = get_string('not_enabled_admin', 'report_coursediagnostic', $link);
    }
    $diagnostic_content = html_writer::div($phrase, 'alert alert-info');
}

$renderable = new \report_coursediagnostic\output\index_page($diagnostic_content);
echo $output->render($renderable);

echo $output->footer();

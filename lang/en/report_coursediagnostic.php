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
 * Language file
 *
 * English descriptions for commonly used strings in the plugin.
 *
 * @package    report_coursediagnostic
 * @copyright  2022 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['diagnosticoverview:view'] = 'View course diagnostic report';
$string['pluginname'] = 'Course diagnostics';
$string['pluginsettingsname'] = 'Course diagnostic settings';
$string['privacy:metadata'] = 'The Course diagnostic plugin does not store any personal data.';
$string['cachedef_coursediagnosticdata'] = 'The cache for coursediagnosticdata.';
$string['enablediagnostic'] = 'Enable course diagnostics';
$string['enablediagnostic_desc'] = 'When enabled, the course diagnostic tool will run when viewing a course page.';
$string['testsuite'] = 'Course settings tests';
$string['startdate'] = 'Course start date';
$string['startdate_desc'] = 'Test whether a course start date is in the future.';
$string['startdate_impact'] = 'This course\'s start date is in the future. MyCampus enrolments are frozen, and won\'t be updated.';
$string['enddate'] = 'Course end date';
$string['enddate_desc'] = 'Test whether a course end date has been enabled, if so, is it valid.';
$string['enddate_notset_impact'] = 'This course doesn\'t have an end date. Automatic enrolments won\'t work unless you add one. This is to protect old courses from accidental changes.';
$string['enddate_impact'] = 'This course\'s end date is in the past. MyCampus enrolments are frozen, and won\'t be updated. If you\'re still using this course, you can change the end date on the settings page';
$string['visibility'] = 'Course visibility';
$string['visibility_desc'] = 'Test whether a course is hidden or not.';
$string['visibility_impact'] = 'This course is currently hidden. You can see it, but students can\'t.';
$string['autoenrolment'] = 'Auto enrolment settings tests';
$string['autoenrolmentenddate'] = 'End date';
$string['autoenrolmentenddate_desc'] = 'Test if an auto enrolment end date has been set';
$string['activitycompletion'] = 'Activity completion settings tests';
$string['activitycompletionenabled'] = 'Activity completion';
$string['activitycompletion_desc'] = 'Test activity completetion settings if course completion is disabled';
$string['studentenrolment'] = 'Student enrolments';
$string['studentenrolment_desc'] = 'Test whether there are students enrolled on a course';
$string['studentenrolment_impact'] = 'There are no students on this course.';
$string['enrolmentplugins'] = 'Enrolment plugins tests';
$string['enrolmentpluginsenabled'] = 'Enrolment plugins disabled';
$string['enrolmentplugins_desc'] = 'Test whether all enrolment plugins are disabled.';
$string['inactiveenrolment'] = 'Inactive user enrolments';
$string['inactiveenrolment_desc'] = 'Test whether there are inactive users enrolled on a course';
$string['groupmodeenabled'] = 'Group mode';
$string['groupmodeenabled_desc'] = 'Test whether Group mode is enabled and no groups have been defined (or all empty)';
$string['submissiontypes'] = 'Incompatible assignment submission types';
$string['submissiontypes_desc'] = 'Test if assignment submission types are incompatible with Mahara.';
$string['coursesize'] = 'Course size (MB/GB)';
$string['coursesize_desc'] = 'Analyze the overall size of the course. Large 100-999MB - Excessive > 1GB ';
$string['gcat'] = 'GCAT configuration';
$string['existingenrolments'] = 'Existing enrolments';
$string['existingenrolments_desc'] = 'Test whether existing gudatabase enrolments are enabled.';
$string['selfenrolmentkeymissing'] = 'Self-enrolment key.';
$string['selfenrolmentkeymissing_desc'] = 'Tests whether self-enrolment is enabled, and if the key is missing.';
$string['reporttitle'] = 'Course diagnostic checks';
$string['passtext'] = 'PASS';
$string['failtext'] = 'FAIL';
$string['skipped'] = 'N/A';
$string['column1'] = 'Setting/Check';
$string['column2'] = 'Impact';
$string['column3'] = 'Status';
$string['no_cache_data'] = 'The cache returned no data. You can run the tests again by making a change in {$a}.';
$string['settings_link_text'] = 'the settings page';
$string['not_enabled'] = 'The course diagnostics are not enabled. You can change this in the Site Administration {$a}.';
$string['no_tests_enabled'] = 'No diagnostic tests have been enabled. You can change this in the Site Administration {$a}.';
$string['admin_link_text'] = 'course diagnostic settings page';

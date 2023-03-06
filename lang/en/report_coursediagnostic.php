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

$string['coursediagnostic:view'] = 'View course diagnostic report';
$string['pluginname'] = 'Course diagnostics';
$string['privacy:metadata'] = 'The Course diagnostic plugin does not store any personal data.';
$string['cachedef_coursediagnosticdata'] = 'The cache for coursediagnosticdata.';
$string['coursediagnosticdefaults_desc'] = 'These defaults are used both by the scheduled job, and when a teacher or manager first views a course page.<p><strong class="red">WARNING!</strong> Clicking \'save changes\' will <strong><em>empty the cache</em></strong> of all course diagnostic data, causing it to be reloaded using the settings from this page - use this with care.</p>';
$string['coursediagnostichdr_text'] = 'Course diagnostic settings';
$string['enablediagnostic'] = 'Enable course diagnostics';
$string['enablediagnostic_desc'] = 'When enabled, the course diagnostic tool will run when viewing a course page.';
$string['testsuite'] = 'Course settings tests';
$string['startdate'] = 'Course start date';
$string['startdate_desc'] = 'Test whether a course start date is in the future.';
$string['startdate_impact'] = 'This course\'s start date is in the future. MyCampus enrolments are frozen, and won\'t be updated. If you\'re already using this course right now, you can change the start date on {$a->settingslink}.';
$string['startdate_success_text'] = 'The start date for the course is configured correctly.';
$string['enddate'] = 'Course end date';
$string['enddate_desc'] = 'Test whether a course end date has been enabled, if so, is it valid.';
$string['enddate_notset_impact'] = 'This course doesn\'t have an end date. Automatic enrolments won\'t work unless you add one. This is to protect old courses from accidental changes. You can change this on {$a->settingslink}.';
$string['enddate_impact'] = 'This course\'s end date is in the past. MyCampus enrolments are frozen, and won\'t be updated. If you\'re still using this course, you can change the end date on {$a->settingslink}.';
$string['enddate_success_text'] = 'The end date for the course is configured correctly.';
$string['visibility'] = 'Course visibility';
$string['visibility_desc'] = 'Test whether a course is hidden or not.';
$string['visibility_impact'] = 'This course is currently hidden. You can see it, but students can\'t.<br />You can change this on {$a->settingslink}.';
$string['visibility_success_text'] = 'The course is visible to students and staff.';
$string['studentenrolment'] = 'Student enrolments';
$string['studentenrolment_desc'] = 'Test whether there are students enrolled on a course';
$string['studentenrolment_impact'] = 'There are no students enrolled on this course.<br />You can enrol students on the {$a->participantslink} page.';
$string['studentenrolment_success_text'] = 'There are students enrolled on this course.';
$string['participants_link_text'] = 'Participants';
$string['inactiveenrolment'] = 'Inactive user enrolments';
$string['inactiveenrolment_desc'] = 'Test whether there are inactive users enrolled on a course.';
$string['inactiveenrolment_impact'] = 'There {$a->word1} {$a->inactiveusercount} {$a->word2} enrolled who {$a->word3} not accessed this course within the last 90 days.<br />You can view inactive users on the {$a->participantslink} page.';
$string['singular_6'] = 'user';
$string['plural_6'] = 'users';
$string['groupmode'] = 'Group mode';
$string['groupmode_desc'] = 'Test whether the "Group Mode" option (within Groups), if not set to "No Groups", has groups that have been defined and are not empty.';
$string['groupmode_impact'] = 'The "Group Mode" option (within Groups) has a value other than "No Groups", and no groups have been defined or are empty.<br />You can change this on {$a->settingslink} or {$a->groupsettingslink}.';
$string['submissiontypes'] = 'Incompatible assignment submission types';
$string['submissiontypes_desc'] = 'Test if assignment submission types are incompatible with Mahara.';
$string['activitycompletion'] = 'Activity completion';
$string['activitycompletion_desc'] = 'Test activity completion settings if course activity completion is disabled.';
$string['activitycompletion_impact'] = 'Course activity completion is currently disabled, but some activities have completion settings. Are you sure it should be off?<br />If you want to know what they are, you can switch it on and look at the {$a->activitycompletionlink}.';
$string['activitycompletion_link_text'] = 'activity completion report';
$string['activitycompletion_success_text'] = 'Activity completion is configured correctly for all activities.';
$string['singular_3'] = 'activity';
$string['plural_3'] = 'activities';
$string['coursesize'] = 'Course size tests';
$string['filesizelimit'] = 'File size limit';
$string['filesizelimit_desc'] = 'What is the maximum limit for all files combined, that a course should not exceed.';
$string['coursefiles'] = 'Course files';
$string['coursefiles_desc'] = 'Test whether all course files (Microsoft, PDF, graphics, audio, video, backups etc) combined exceeds the File Size Limit (set above).';
$string['coursefiles_impact'] = 'There are <strong>{$a->totalfiles}</strong> files (totalling <strong>{$a->totalfilesize}</strong>) uploaded for this course (Microsoft, PDF, graphics, audio, video, backups etc). This exceeds the current system limit of <strong>{$a->filesizelimit}</strong>.<br />Removing unwanted files will free up drive space and improve the efficiency of your course.';
$string['coursefiles_success_text'] = 'Uploaded files (Microsoft, PDF, graphics, audio, video, backups etc) for the course are within the current system limits.';
$string['coursevideo'] = 'Course videos';
$string['coursevideo_desc'] = 'Test whether all video files for the course exceed the File Size Limit (set above).';
$string['coursevideo_impact'] = 'There are <strong>{$a->totalfiles}</strong> videos uploaded for this course, totalling <strong>{$a->totalfilesize}</strong>. This exceeds the current system limit of <strong>{$a->filesizelimit}</strong>.<br />This will be having an impact on the end user experience when viewing this course.<br />Removing unwanted videos will free up drive space and improve the efficiency of your course.';
$string['coursevideo_success_text'] = 'Uploaded video files for the course are within the current system limits.';
$string['courseaudio'] = 'Course audio';
$string['courseaudio_desc'] = 'Test whether all audio files for the course exceed the File Size Limit (set above).';
$string['courseaudio_impact'] = 'There are <strong>{$a->totalfiles}</strong> audio files uploaded for this course, totalling <strong>{$a->totalfilesize}</strong>. This exceeds the current system limit of <strong>{$a->filesizelimit}</strong>.<br />This will be having an impact on the end user experience when viewing this course.<br />Removing unwanted audio files will free up drive space and improve the efficiency of your course.';
$string['courseaudio_success_text'] = 'Uploaded audio files for the course are within the current system limits.';
$string['courseassignment'] = 'Course assignment tests';
$string['assignmentduedate'] = 'Course assignment due date';
$string['assignmentduedate_desc'] = 'Test whether all course assignment due date\'s have been enabled.';
$string['assignmentduedate_impact'] = 'The following course {$a->word1} currently {$a->word2} no due date set:<br />{$a->assignmentlinks}';
$string['assignmentduedate_success_text'] = 'Assignment due date\'s are configured correctly.';
$string['singular_1'] = 'assignment';
$string['plural_1'] = 'assignments';
$string['singular_2'] = 'has';
$string['plural_2'] = 'have';
$string['enrolmentplugins'] = 'Enrolment plugins tests';
$string['enrolmentpluginsenabled'] = 'Enrolment plugins disabled';
$string['enrolmentplugins_desc'] = 'Test whether all enrolment plugins are disabled.';
$string['enrolmentpluginsenabled_impact'] = 'This course doesn\'t have any enrolment methods enabled.<br />You can change this on the {$a->enrolmentpluginslink} page.';
$string['enrolmentpluginsenabled_success_text'] = 'Enrolment methods are configured correctly.';
$string['enrolmentplugins_link_text'] = 'Enrolment Methods';
$string['selfenrolmentkey'] = 'Self-enrolment contains a key';
$string['selfenrolmentkey_desc'] = 'Tests whether, if self-enrolment has been enabled, that a key has been set.';
$string['selfenrolmentkey_impact'] = 'The following Self-enrolment {$a->word1} {$a->word2} enabled for this course, with no enrolment key. This means anybody can add themselves to this course.<br />{$a->enrolmentlinks}<br />';
$string['selfenrolmentkey_success_text'] = 'Self enrolment key(s) are configured correctly.';
$string['autoenrolment'] = 'UofG Specific tests';
$string['autoenrolment_studentdatadeletion'] = 'Enrolment settings that could delete student data.';
$string['autoenrolment_studentdatadeletion_desc'] = 'If \'Enrolment period\' or \'Enrol end date\' have been checked, and \'Enable user enrol\' or \'Enable removal from group\' are set to \'Yes\', this would lead to student data being permanently deleted. <strong class="red">DATA LOSS!</strong>';
$string['autoenrolment_studentdatadeletion_impact'] = 'The way the following Enrolment {$a->word1} {$a->word2} configured, if left unchecked could lead to the <em><u>permanent loss</u></em> of student data:<br />{$a->enrolmentlinks}<br /><strong>WARNING</strong> - <strong class="red">DATA LOSS!</strong>';
$string['autoenrolment_studentdatadeletion_success_text'] = 'Enrolment settings are configured correctly.';
$string['singular_4'] = 'method';
$string['plural_4'] = 'methods';
$string['singular_5'] = 'is';
$string['plural_5'] = 'are';
$string['enrolperiod'] = 'Enrolment period';
$string['enrolenddate'] = 'Enrol end date';
$string['reporttitle'] = 'Course diagnostic checks';
$string['report_summary'] = '<p>This report shows the results of the tests that have been run against this course.<br />You can use the results of these tests to ensure that your course is performing at its optimal best for end users.</p><div class="w-25 p-2 alert alert-dark" style="display:inline-block"><strong>N/A</strong></div><div style="display:inline-block">&nbsp;Indicates tests that haven\'t been enabled and can safely be ignored.</div><p><div class="w-25 p-2 alert alert-success" style="display:inline-block"><strong>OK</strong></div><div style="display:inline-block">&nbsp;Indicates tests that have successfully passed.</div></p><p><div class="w-25 p-2 alert alert-danger" style="display:inline-block"><strong>CHECK</strong></div><div style="display:inline-block">&nbsp;Indicates tests that require further investigation.</div></p>';
$string['passtext'] = 'OK';
$string['failtext'] = 'CHECK';
$string['skipped'] = 'N/A';
$string['skipped_text'] = 'This test hasn\'t been enabled.';
$string['column1'] = 'Setting/Check';
$string['column2'] = 'Impact';
$string['column3'] = 'Status';
$string['no_cache_data'] = 'The cache returned no data. You can run the tests again by visiting the course page, or making a change in {$a}.';
$string['settings_link_text'] = 'the settings page';
$string['group_settings_link_text'] = 'the group participants page';
$string['not_enabled'] = 'The plugin <strong>Course Diagnostic</strong> is not enabled. Please contact your {$a} to inform them of this.';
$string['system_administrator'] = 'System Administrator';
$string['not_enabled_admin'] = 'The plugin <strong>Course Diagnostic</strong> is not enabled. You can change this in the Site Administration {$a}.';
$string['no_tests_enabled'] = 'The plugin <strong>Course Diagnostic</strong> is enabled, but no tests have been selected. Please contact your {$a} to inform them of this.';
$string['no_tests_enabled_admin'] = 'The plugin <strong>Course Diagnostic</strong> is enabled, but no tests have been selected. You can change this in the Site Administration {$a}.';
$string['admin_link_text'] = 'course diagnostic settings page';
$string['scheduledname'] = 'Course diagnostic task';
$string['timelimit'] = 'Cron time limit';
$string['timelimit_desc'] = 'Maximum time (in seconds) that the cron process may run for.';

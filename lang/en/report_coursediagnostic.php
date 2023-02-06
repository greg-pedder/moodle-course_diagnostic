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
$string['studentenrolment'] = 'Student enrolments';
$string['studentenrolment_desc'] = 'Test whether there are students enrolled on a course';
$string['studentenrolment_impact'] = 'There are no students on this course.';
$string['inactiveenrolment'] = 'Inactive user enrolments';
$string['inactiveenrolment_desc'] = 'Test whether there are inactive users enrolled on a course.';
$string['inactiveenrolment_impact'] = 'There are 1 or more students enrolled on this course who have been inactive for some time.';
$string['groupmode'] = 'Group mode';
$string['groupmode_desc'] = 'Test whether Groups, if not set to "No Groups", have been defined and are not empty';
$string['groupmode_impact'] = 'Group Mode has a value other than "No Groups" and no groups have been defined, or are empty.';
$string['submissiontypes'] = 'Incompatible assignment submission types';
$string['submissiontypes_desc'] = 'Test if assignment submission types are incompatible with Mahara.';
$string['activitycompletion'] = 'Activity completion';
$string['activitycompletion_desc'] = 'Test activity completion settings if course activity completion is disabled.';
$string['activitycompletion_impact'] = 'Course activity completion is currently disabled, but some activities still have their completion settings set. This could cause problems with assignment submissions.<br />You need to enable Course completion again, in order to view the activity settings.';
$string['coursesize'] = 'Course size tests';
$string['filesizelimit'] = 'File size limit';
$string['filesizelimit_desc'] = 'What is the maximum limit for all files combined, that a course should not exceed.';
$string['coursefiles'] = 'Course files';
$string['coursefiles_desc'] = 'Test whether all course files (Microsoft, PDF, graphics, audio, video, backups etc) combined exceeds 500MB.';
$string['coursefiles_impact'] = 'There are <strong>{$a->totalfiles}</strong> files (totalling <strong>{$a->totalfilesize}</strong>) uploaded for this course (Microsoft, PDF, graphics, audio, video, backups etc). This exceeds the current system limit of <strong>{$a->filesizelimit}</strong>.<br />Removing unwanted files will improve the efficiency of your course.';
$string['coursevideo'] = 'Course videos';
$string['coursevideo_desc'] = 'Test whether all video files for the course exceed 500MB.';
$string['coursevideo_impact'] = 'There are <strong>{$a->totalfiles}</strong> videos uploaded for this course, totalling <strong>{$a->totalfilesize}</strong>. This exceeds the current system limit of <strong>{$a->filesizelimit}</strong>.<br />This will be having an impact on the end user experience when viewing this course.<br />Removing unwanted videos will improve the efficiency of your course.';
$string['courseaudio'] = 'Course Audio';
$string['courseaudio_desc'] = 'Test whether all audio files for the course exceed 500MB.';
$string['courseaudio_impact'] = 'There are <strong>{$a->totalfiles}</strong> audio files uploaded for this course, totalling <strong>{$a->totalfilesize}</strong>. This exceeds the current system limit of <strong>{$a->filesizelimit}</strong>.<br />This will be having an impact on the end user experience when viewing this course.<br />Removing unwanted audio files will improve the efficiency of your course.';
$string['courseassignment'] = 'Course assignment tests';
$string['assignmentenddate'] = 'Course assignment end date';
$string['assignmentenddate_desc'] = 'Test whether all course assignment end date\'s have been enabled.';
$string['assignmentenddate_impact'] = 'The following course {$a->word1} currently {$a->word2} no end date set.<br />{$a->assignmenturls}';
$string['singular_1'] = 'assignment';
$string['plural_1'] = 'assignments';
$string['singular_2'] = 'has';
$string['plural_2'] = 'have';
$string['enrolmentplugins'] = 'Enrolment plugins tests';
$string['enrolmentpluginsenabled'] = 'Enrolment plugins disabled';
$string['enrolmentplugins_desc'] = 'Test whether all enrolment plugins are disabled.';
$string['enrolmentpluginsenabled_impact'] = 'This course doesn\'t have any enrolment methods enabled.';
$string['selfenrolmentkey'] = 'Self-enrolment contains a key';
$string['selfenrolmentkey_desc'] = 'Tests whether, if self-enrolment has been enabled, that a key has been set.';
$string['selfenrolmentkey_impact'] = 'Self-enrolment is enabled for this course, with no enrolment key. This means anybody can add themselves to this course.';
$string['selfenrolmentkey_notset_impact'] = 'Self-enrolment is not enabled for this course.';
$string['autoenrolment'] = 'Auto enrolment settings tests (UofG Specific)';
$string['autoenrolment_action_after_period'] = 'Action after period - unenrol';
$string['autoenrolment_action_after_period_desc'] = 'Test if Enrol end date is enabled, and "Action after period" has been set to "unenrol" - which will unenrol students from the course.';
$string['autoenrolment_action_after_period_impact'] = 'Auto enrolment is currently configured to unenrol students from this course once the end date has passed.';
$string['autoenrolment_enable_user_unenrol'] = 'User unenrol has been been enabled.';
$string['autoenrolment_enable_user_unenrol_desc'] = 'If enabled, and a valid course end date has been set, students will unenrolled shortly after they are removed from the course in MyCampus. <strong class="red">DATA LOSS!</strong>';
$string['autoenrolment_enable_user_unenrol_impact'] = 'User unenrol is "enabled" - students will unenrolled shortly after they are removed from the course in MyCampus. WARNING - DATA LOSS!';
$string['autoenrolment_remove_student_from_groups'] = 'Remove student from group';
$string['autoenrolment_remove_student_from_groups_desc'] = 'If enabled, and a valid course end date has been set, students will be removed from all groups for this course after they are removed from the class list in MyCampus. <strong class="red">DATA LOSS!</strong>';
$string['autoenrolment_remove_student_from_groups_impact'] = 'Removal from groups is "enabled" - students will removed from all groups, after being removed from the corresponding class list in MyCampus. WARNING - DATA LOSS!';



$string['gcat'] = 'GCAT configuration';
$string['existingenrolments'] = 'Existing enrolments'; // Not a course thing??
$string['existingenrolments_desc'] = 'Test whether existing gudatabase enrolments are enabled.'; // Not a course thing??

$string['reporttitle'] = 'Course diagnostic checks';
$string['passtext'] = 'PASS';
$string['failtext'] = 'FAIL';
$string['skipped'] = 'N/A';
$string['column1'] = 'Setting/Check';
$string['column2'] = 'Impact';
$string['column3'] = 'Status';
$string['no_cache_data'] = 'The cache returned no data. You can run the tests again by making a change in {$a}.';
$string['settings_link_text'] = 'the settings page';
$string['not_enabled'] = 'The plugin <strong>Course Diagnostic</strong> is not enabled. Please contact your {$a} to inform them of this.';
$string['system_administrator'] = 'System Administrator';
$string['not_enabled_admin'] = 'The plugin <strong>Course Diagnostic</strong> is not enabled. You can change this in the Site Administration {$a}.';
$string['no_tests_enabled'] = 'The plugin <strong>Course Diagnostic</strong> is enabled, but no tests have been selected. Please contact your {$a} to inform them of this.';
$string['no_tests_enabled_admin'] = 'The plugin <strong>Course Diagnostic</strong> is enabled, but no tests have been selected. You can change this in the Site Administration {$a}.';
$string['admin_link_text'] = 'course diagnostic settings page';

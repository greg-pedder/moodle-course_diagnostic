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
 * @package    report_coursediagnositc
 * @copyright  2022 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Ensure the configurations for this site are set.
if ($hassiteconfig) {
    $pluginname = get_string('pluginsettingsname', 'report_coursediagnostic');

    $ADMIN->add('courses', new admin_category('report_coursediagnostic_settings', $pluginname));
    $settingspage = new admin_settingpage('coursediagnosticsettings', $pluginname);

    if ($ADMIN->fulltree) {
        // This gets set when the course_viewed event is caught.
        // @todo: figure out how to handle the POST of this form and unset the
        // @todo session variables there instead...
        global $SESSION;
        unset($SESSION->report_coursediagnostic);
        unset($SESSION->report_coursediagnosticconfig);

        $settingspage->add(new admin_setting_configcheckbox(
            'report_coursediagnostic/enablediagnostic',
            new lang_string('enablediagnostic', 'report_coursediagnostic'),
            new lang_string('enablediagnostic_desc', 'report_coursediagnostic'),
            0,
        ));

        // Course settings tests
        $settingspage->add(new admin_setting_heading('coursediagnostichdr', new lang_string('testsuite', 'report_coursediagnostic'), ''));

        $settingspage->add(new admin_setting_configcheckbox('report_coursediagnostic/startdate', get_string('startdate', 'report_coursediagnostic'),
            get_string('startdate_desc', 'report_coursediagnostic'), 0));

        $settingspage->add(new admin_setting_configcheckbox('report_coursediagnostic/enddate', get_string('enddate', 'report_coursediagnostic'),
            get_string('enddate_desc', 'report_coursediagnostic'), 0));

        $settingspage->add(new admin_setting_configcheckbox('report_coursediagnostic/visibility', get_string('visibility', 'report_coursediagnostic'),
            get_string('visibility_desc', 'report_coursediagnostic'), 0));

        $settingspage->add(new admin_setting_configcheckbox('report_coursediagnostic/studentenrolment', get_string('studentenrolment', 'report_coursediagnostic'),
            get_string('studentenrolment_desc', 'report_coursediagnostic'), 0));

        $settingspage->add(new admin_setting_configcheckbox('report_coursediagnostic/inactiveenrolment', get_string('inactiveenrolment', 'report_coursediagnostic'),
            get_string('inactiveenrolment_desc', 'report_coursediagnostic'), 0));

        $settingspage->add(new admin_setting_configcheckbox('report_coursediagnostic/groupmodeenabled', get_string('groupmodeenabled', 'report_coursediagnostic'),
            get_string('groupmodeenabled_desc', 'report_coursediagnostic'), 0));

        $settingspage->add(new admin_setting_configcheckbox('report_coursediagnostic/submissiontypes', get_string('submissiontypes', 'report_coursediagnostic'),
            get_string('submissiontypes_desc', 'report_coursediagnostic'), 0));

        $settingspage->add(new admin_setting_configcheckbox('report_coursediagnostic/coursesize', get_string('coursesize', 'report_coursediagnostic'),
            get_string('coursesize_desc', 'report_coursediagnostic'), 0));

        // Auto enrolment tests
        $settingspage->add(new admin_setting_heading('autoenrolmenthdr', new lang_string('autoenrolment', 'report_coursediagnostic'), ''));

        $settingspage->add(new admin_setting_configcheckbox('report_coursediagnostic/existingenrolments', get_string('existingenrolments', 'report_coursediagnostic'),
            get_string('existingenrolments_desc', 'report_coursediagnostic'), 0));

        $settingspage->add(new admin_setting_configcheckbox('report_coursediagnostic/existingenrolments', get_string('existingenrolments', 'report_coursediagnostic'),
            get_string('existingenrolments_desc', 'report_coursediagnostic'), 0));

        $settingspage->add(new admin_setting_heading('enrolmentpluginshdr', new lang_string('enrolmentplugins', 'report_coursediagnostic'), ''));

        $settingspage->add(new admin_setting_configcheckbox('report_coursediagnostic/enrolmentpluginsenabled', get_string('enrolmentpluginsenabled', 'report_coursediagnostic'),
            get_string('enrolmentplugins_desc', 'report_coursediagnostic'), 0));

        // Activity completion tests
        $settingspage->add(new admin_setting_heading('activitycompletionhdr', new lang_string('activitycompletion', 'report_coursediagnostic'), ''));

        // GCAT - this will be specific to UofG so we need to make these kind of 'options' dynamically loaded.
        $settingspage->add(new admin_setting_heading('gcathdr', new lang_string('gcat', 'report_coursediagnostic'), ''));
    }

    $ADMIN->add('courses', $settingspage);
}

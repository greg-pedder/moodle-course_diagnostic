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
 * Course diagnostic settings
 *
 * @package    report_coursediagnositc
 * @copyright  2022 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $pluginname = get_string('pluginsettingsname', 'report_coursediagnostic');

    $ADMIN->add('courses', new admin_category('report_coursediagnostic_settings', $pluginname));
    $settingspage = new admin_settingpage('coursediagnosticsettings', $pluginname);

    if ($ADMIN->fulltree) {

        $name = new lang_string('enablediagnostic', 'report_coursediagnostic');
        $desc = new lang_string('enablediagnostic_desc', 'report_coursediagnostic');
        $default = 0;
        $setting = new admin_setting_configcheckbox('report_coursediagnostic/enablediagnostic',
            $name,
            $desc,
            $default);
        $setting->set_updatedcallback('report_coursediagnostic\coursediagnostic::flag_cache_for_deletion');
        $settingspage->add($setting);

        // Course settings tests
        $name = new lang_string('testsuite', 'report_coursediagnostic');
        $desc = '';
        $setting = new admin_setting_heading('coursediagnostichdr',
            $name,
            $desc);
        $settingspage->add($setting);

        $name = new lang_string('startdate', 'report_coursediagnostic');
        $desc = new lang_string('startdate_desc', 'report_coursediagnostic');
        $default = 0;
        $setting = new admin_setting_configcheckbox('report_coursediagnostic/startdate',
            $name,
            $desc,
            $default);
        $setting->set_updatedcallback('report_coursediagnostic\coursediagnostic::flag_cache_for_deletion');
        $settingspage->add($setting);

        $name = new lang_string('enddate', 'report_coursediagnostic');
        $desc = new lang_string('enddate_desc', 'report_coursediagnostic');
        $default = 0;
        $setting = new admin_setting_configcheckbox('report_coursediagnostic/enddate',
            $name,
            $desc,
            $default);
        $setting->set_updatedcallback('report_coursediagnostic\coursediagnostic::flag_cache_for_deletion');
        $settingspage->add($setting);

        $name = new lang_string('visibility', 'report_coursediagnostic');
        $desc = new lang_string('visibility_desc', 'report_coursediagnostic');
        $default = 0;
        $setting = new admin_setting_configcheckbox('report_coursediagnostic/visibility',
            $name,
            $desc,
            $default);
        $setting->set_updatedcallback('report_coursediagnostic\coursediagnostic::flag_cache_for_deletion');
        $settingspage->add($setting);

        $name = new lang_string('studentenrolment', 'report_coursediagnostic');
        $desc = new lang_string('studentenrolment_desc', 'report_coursediagnostic');
        $default = 0;
        $setting = new admin_setting_configcheckbox('report_coursediagnostic/studentenrolment',
            $name,
            $desc,
            $default);
        $setting->set_updatedcallback('report_coursediagnostic\coursediagnostic::flag_cache_for_deletion');
        $settingspage->add($setting);

        $name = new lang_string('inactiveenrolment', 'report_coursediagnostic');
        $desc = new lang_string('inactiveenrolment_desc', 'report_coursediagnostic');
        $default = 0;
        $setting = new admin_setting_configcheckbox('report_coursediagnostic/inactiveenrolment',
            $name,
            $desc,
            $default);
        $setting->set_updatedcallback('report_coursediagnostic\coursediagnostic::flag_cache_for_deletion');
        $settingspage->add($setting);

        $name = new lang_string('groupmodeenabled', 'report_coursediagnostic');
        $desc = new lang_string('groupmodeenabled_desc', 'report_coursediagnostic');
        $default = 0;
        $setting = new admin_setting_configcheckbox('report_coursediagnostic/groupmodeenabled',
            $name,
            $desc,
            $default);
        $setting->set_updatedcallback('report_coursediagnostic\coursediagnostic::flag_cache_for_deletion');
        $settingspage->add($setting);

        $name = new lang_string('submissiontypes', 'report_coursediagnostic');
        $desc = new lang_string('submissiontypes_desc', 'report_coursediagnostic');
        $default = 0;
        $setting = new admin_setting_configcheckbox('report_coursediagnostic/submissiontypes',
            $name,
            $desc,
            $default);
        $setting->set_updatedcallback('report_coursediagnostic\coursediagnostic::flag_cache_for_deletion');
        $settingspage->add($setting);

        $name = new lang_string('coursesize', 'report_coursediagnostic');
        $desc = new lang_string('coursesize_desc', 'report_coursediagnostic');
        $default = 0;
        $setting = new admin_setting_configcheckbox('report_coursediagnostic/coursesize',
            $name,
            $desc,
            $default);
        $setting->set_updatedcallback('report_coursediagnostic\coursediagnostic::flag_cache_for_deletion');
        $settingspage->add($setting);

        // Enrolment plugin tests
        $name = new lang_string('enrolmentplugins', 'report_coursediagnostic');
        $desc = '';
        $setting = new admin_setting_heading('enrolmentpluginshdr',
            $name,
            $desc);
        $settingspage->add($setting);

        $name = new lang_string('enrolmentpluginsenabled', 'report_coursediagnostic');
        $desc = new lang_string('enrolmentplugins_desc', 'report_coursediagnostic');
        $default = 0;
        $setting = new admin_setting_configcheckbox('report_coursediagnostic/enrolmentpluginsenabled',
            $name,
            $desc,
            $default);
        $setting->set_updatedcallback('report_coursediagnostic\coursediagnostic::flag_cache_for_deletion');
        $settingspage->add($setting);

        $name = new lang_string('selfenrolmentkeymissing', 'report_coursediagnostic');
        $desc = new lang_string('selfenrolmentkeymissing_desc', 'report_coursediagnostic');
        $default = 0;
        $setting = new admin_setting_configcheckbox('report_coursediagnostic/selfenrolmentkeymissing',
            $name,
            $desc,
            $default);
        $setting->set_updatedcallback('report_coursediagnostic\coursediagnostic::flag_cache_for_deletion');
        $settingspage->add($setting);

        // Auto enrolment tests
        $name = new lang_string('autoenrolment', 'report_coursediagnostic');
        $desc = '';
        $setting = new admin_setting_heading('autoenrolmenthdr',
            $name,
            $desc);
        $settingspage->add($setting);

        $name = new lang_string('existingenrolments', 'report_coursediagnostic');
        $desc = new lang_string('existingenrolments_desc', 'report_coursediagnostic');
        $default = 0;
        $setting = new admin_setting_configcheckbox('report_coursediagnostic/selfenrolmentkeymissing',
            $name,
            $desc,
            $default);
        $setting->set_updatedcallback('report_coursediagnostic\coursediagnostic::flag_cache_for_deletion');
        $settingspage->add($setting);

        // Activity completion tests
        $name = new lang_string('activitycompletion', 'report_coursediagnostic');
        $desc = '';
        $setting = new admin_setting_heading('activitycompletionhdr',
            $name,
            $desc);
        $settingspage->add($setting);

        // GCAT - this will be specific to UofG so we need to make these kind of 'options' dynamically loaded.
        $name = new lang_string('gcat', 'report_coursediagnostic');
        $desc = '';
        $setting = new admin_setting_heading('gcathdr',
            $name,
            $desc);
        $settingspage->add($setting);

        if (\report_coursediagnostic\coursediagnostic::get_cache_deletion_flag()) {
            \report_coursediagnostic\coursediagnostic::purge_diagnostic_settings_cache();
        }
    }

    $ADMIN->add('courses', $settingspage);
}

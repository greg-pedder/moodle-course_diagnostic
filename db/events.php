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

defined('MOODLE_INTERNAL') || die();

/**
 * An array of observers.
 *
 * The list of events we are wanting to observe as part of the diagnostics.
 *
 * @package    report_coursediagnositc
 * @copyright  2022 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$observers = [
    [
        'eventname' => '\core\event\course_viewed',
        'callback' => 'report_coursediagnostic\observer::course_viewed'
    ],
    [
        'eventname' => '\core\event\course_updated',
        'callback' => 'report_coursediagnostic\observer::course_updated'
    ],
    [
        'eventname' => '\core\event\course_deleted',
        'callback' => 'report_coursediagnostic\observer::course_deleted'
    ],
    [
        'eventname' => '\core\event\user_enrolment_created',
        'callback' => 'report_coursediagnostic\observer::user_enrolment_created'
    ],
    [
        'eventname' => '\core\event\user_enrolment_deleted',
        'callback' => 'report_coursediagnostic\observer::user_enrolment_deleted'
    ]
];

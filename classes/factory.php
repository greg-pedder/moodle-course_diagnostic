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
class diagnostic_factory {
    /**
     * An instance of the diagnostic_factory class created upon the first request.
     * @var diagnostic_factory
     */
    protected static $instance;

    /**
     * Protected constructor, please use the static instance method.
     */
    protected function __construct() {
        // Nothing to do here.
    }

    /**
     * Returns an instance of the diagnostic_factory class.
     *
     * @param bool $forcereload If set to true a new diagnostic_factory instance will be created and used.
     * @return diagnostic_factory
     */
    public static function instance(bool $forcereload = false): diagnostic_factory
    {

        if ($forcereload || self::$instance === null) {
            // Initialise a new factory to facilitate our needs.

            // We're using the regular factory.
            self::$instance = new diagnostic_factory();
        }
        return self::$instance;
    }

    /**
     * @param $name - the test being performed
     * @param $course - the course object
     * @return mixed
     */
    public function create_diagnostic_test_from_config($name, $course) {
        $class = 'course_' . $name . '_test';

        require_once('interfaces.php');
        require_once($class . '.php');

        $fqclassname = '\\report_coursediagnostic\\course_' . $name . '_test';

        $testclass = new $fqclassname($name, $course);

        $testclass->runTest();

        return $testclass;
    }
}
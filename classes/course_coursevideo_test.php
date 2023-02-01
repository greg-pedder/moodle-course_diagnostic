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
 * @copyright  2023 Greg Pedder <greg.pedder@glasgow.ac.uk>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_coursediagnostic;
class course_coursevideo_test implements course_diagnostic_interface
{

    /** @var string The name of the test - needed w/in the report */
    public string $testname;

    /** @var object The course object */
    public object $course;

    /** @var bool $testresult whether the test has passed or failed. */
    public bool $testresult;

    /** @var int FILESIZE_100MB - filesize in mdl_files is stored as bytes  */
    const FILESIZE_100MB = 104857600;

    /** @var int FILESIZE_500MB - filesize in mdl_files is stored as bytes  */
    const FILESIZE_500MB = 524288000;

    /** @var int FILESIZE_1GB - filesize in mdl_files is stored as bytes  */
    const FILESIZE_1GB = 1073741824;

    /** @var int FILESIZE_10GB - filesize in mdl_files is stored as bytes  */
    const FILESIZE_10GB = 10737418240;

    /** @var int FILESIZE_100GB - filesize in mdl_files is stored as bytes  */
    const FILESIZE_100GB = 107374182400;

    /**
     * This array maps to the option values in the Settings page.
     * @var array
     */
    protected static array $filesizeoptions = [
        1 => self::FILESIZE_100MB,
        2 => self::FILESIZE_500MB,
        3 => self::FILESIZE_1GB,
        4 => self::FILESIZE_10GB,
        5 => self::FILESIZE_100GB
    ];

    /**
     * @var array|string[] A list of video related mime types.
     */
    protected static array $mimetypes = [
        '"video/mp4"',
        '"video/mpeg"',
        '"video/ogg"',
        '"video/quicktime"',
        '"video/webm"',
        '"video/x-flv"',
        '"video/x-ms-asf"',
        '"video/x-ms-wm"',
        '"video/x-ms-wmv"'
    ];

    /**
     * @param $name
     * @param $course
     */
    public function __construct($name, $course) {
        $this->testname = $name;
        $this->course = $course;
    }

    /**
     * @return bool
     */
    public function runTest()
    {
        global $DB;
        $filesizeoption = get_config('report_coursediagnostic', 'filesizelimit');
        $filesizelimit = self::$filesizeoptions[$filesizeoption];
        $context = \context_course::instance($this->course->id);
        $result = $DB->get_records_sql('SELECT SUM(filesize) AS filesize FROM {files} mf JOIN {context} mc ON mc.id = mf.contextid WHERE mc.path LIKE "'.$context->path.'/%" AND mf.filename <> "." AND mimetype IN ('.implode(', ', self::$mimetypes).')');

        $fileSizeWithinLimit = true;
        if (count($result) > 0) {
            foreach ($result as $row) {
                if ($row->filesize > 0) {
                    if ($row->filesize >= $filesizelimit) {
                        $fileSizeWithinLimit = false;
                        break;
                    }
                }
            }
        }

        return $this->testresult = $fileSizeWithinLimit;
    }
}
<?php

/**
 * Quick and dirty directory iterator for doing semi-automated testing of our code structure
 * @author bobbravo2
 */
class readmeTests extends PHPUnit_Framework_TestCase
{
    /**
     * @const string folder name for lessons
     */
    const LESSON_PLAN_DIR = '02-lesson-plans';

    const ACTIVITIES_DIR = 'Activities';

    static private $lessonPlanPath = null;

    /**
     * Gets the '02-lesson-plans' absolute path
     * @return string
     */
    private static function getLessonPlanPath()
    {
        if (is_null(self::$lessonPlanPath)) {
            //TODO is there a better way to construct a relative path for running tests?
            //  Current problem comes when invoking PHPUnit via JetBrains IDE vs. CLI
            // IE running ./phpunit works fine, but running from another path causes issues
            //Use a static variable to account for invoking the script from an IDE context vs. CLI
            /** @var constant REPO_ABSPATH string defined in phpunit.dist.xml */
            self::$lessonPlanPath = REPO_ABSPATH . DIRECTORY_SEPARATOR . self::LESSON_PLAN_DIR;

        }
        return self::$lessonPlanPath;
    }


    /**
     * @var RecursiveDirectoryIterator[]
     */
    protected $directories = array();

    public function testLessons()
    {
        foreach ($this->getTopLevelLessonFolderNames() as $path) {

            //02-lesson-plans
            //TODO find current path in haystack, relative to each module week
//            echo $path->getRealPath() . PHP_EOL;

            $this->hasReadme($path->getRealPath());

            //02-lesson-plans/01-html-css-three-days/1-Class-Content
            //TODO test capitalization of each class content
            //TODO see if each week has a class content directory
            //TODO see if each week has 3 folders inside of class-content
            //1.1
            //TODO see if each day has a LessonPlan & TimeTracker
            //TODO see if each day has an 'Activities' folder
            //02-lesson-plans/01-html-css-three-days/1-Class-Content/1.1/Activities
            //TODO foreach Activity, if there are subdirectories, test that the Activity top level has a README.md, and each subdirectory is named 'Skeleton' and 'Solution', fail if named other than those two
            //TODO                      ELSE - Make sure the directory has a README.md


//            $this->assertArrayHasKey('', $array)
        }

    }


    public function testStudentGuides()
    {
        foreach ($this->getTopLevelLessonFolderNames() as $path) {
            $this->assertFileExists($path->getRealPath() . DIRECTORY_SEPARATOR . 'StudentGuide.md');
        }
    }

    public function testVideoGuides()
    {
        foreach ($this->getTopLevelLessonFolderNames() as $path) {
            $this->assertFileExists($path->getRealPath() . DIRECTORY_SEPARATOR . 'VideoGuide.md');
        }
    }

    public function testValidWeeks()
    {
        foreach ($this->getTopLevelLessonFolderNames() as $path) {
            //02-lesson-plans/01-html-css-three-days
            //02-lesson-plans/01-html-css-three-days/1-Class-Content
            $classContentDir = $path->getRealPath() . DIRECTORY_SEPARATOR . '1-Class-Content';
            $this->assertDirectoryExists($classContentDir);

            //Use type juggling to hack our week string into a normalized version of directories (01 == 1.1, 11 == 11.1, et.al.)
            $weekNumber = (int)substr($path->getFilename(), 0, 2);
            //02-lesson-plans/01-html-css-three-days/1-Class-Content/1.1
            $this->assertValidWeek($classContentDir . DIRECTORY_SEPARATOR, $weekNumber . '.1');
            $this->assertValidWeek($classContentDir . DIRECTORY_SEPARATOR, $weekNumber . '.2');
            $this->assertValidWeek($classContentDir . DIRECTORY_SEPARATOR, $weekNumber . '.3');
        }

    }

    /**
     * Wrapper for working inside a week's lesson plan
     * Asserts that we have a folder for the day 14.1, that their is an activity folder, and a Lessonplan.md
     * @param $path
     */
    public function assertValidWeek($path, $dayNumber)
    {
        //02-lesson-plans/01-html-css-three-days/1-Class-Content/1.1
        $dayPath = $path . $dayNumber;
        $this->assertDirectoryExists($dayPath);
        $activityPath = $dayPath . DIRECTORY_SEPARATOR . self::ACTIVITIES_DIR;

//        $this->assertValidActivities($activityPath);
        //TODO cURL spellcheck/pspell in PHP?
        //TODO MarkDown validation
        //TODO 404 checker for links
        $this->assertFileExists($dayPath . DIRECTORY_SEPARATOR . $dayNumber . '-Lessonplan.md');
        $xlsx = $dayPath . DIRECTORY_SEPARATOR . $dayNumber . '-TimeTracker.xlsx';
        $md = $dayPath . DIRECTORY_SEPARATOR . $dayNumber . '-TimeTracker.md';
        if (file_exists($md) && file_exists($xlsx)) {
            $this->fail('Found a TimeTracker.md AND a TimeTracker.xlsx');
        }
        if (! file_exists($xlsx)) {
            //Updated format using .md for timetrackers instead of Micro$oft Excel.
            $this->assertFileExists($md);
        } else {
            //Old format
            $this->assertFileExists($xlsx);

        }

    }

    public function assertValidActivities ($path)
    {
        $this->assertDirectoryExists($path);

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD);


        $activity_directories = array();
        foreach ($iterator as $path => $directory) {
            /** @var $directory RecursiveDirectoryIterator */
            if ($directory->isDir()) {
                $path_parts = $this->getParts($path);

                $last_item = count($path_parts) - 2;
                if (self::ACTIVITIES_DIR == $path_parts[$last_item]) {
                    //TODO implement 2nd level directory search for skeleton / solution if # directories == 2
                    $this->assertFileExists($path . DIRECTORY_SEPARATOR . 'README.md', 'No README.md found for activity');
                }
                $activity_directories[] = $directory;
            }
        }


    }

    protected function setUp()
    {
        $path = $this->getLessonPlanPath();

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD);


        foreach ($iterator as $path => $directory) {
            /** @var $directory RecursiveDirectoryIterator */
            if ($directory->isDir()) {
                $this->directories[] = $directory;
            }
        }

        parent::setUp();
    }

    /**
     * @var RecursiveDirectoryIterator[]
     */
    private $topLevelDirectories = array();

    private function getTopLevelLessonFolderNames()
    {
        if (empty($this->topLevelDirectories)) {
            foreach ($this->directories as $directory) {
                $parts = $this->getParts($directory->getPath());
                $base_parts = $this->getParts($this->getLessonPlanPath());
                if (preg_match('/\d[1-9]-/', $directory->getFilename()) && end($parts) == end($base_parts)) {
                    //Only get top level directories from 01-99
                    //(Skips 00 dev guidelines & EXTRA_CONTENT, for Now)
                    $this->topLevelDirectories[] = $directory;
                }
            }
        }
        return $this->topLevelDirectories;
    }


    private function hasReadme($path)
    {
        $this->assertFileExists($path . DIRECTORY_SEPARATOR . 'README.md', 'README.md not found in: ' . $path);
    }

    private function getParts($path)
    {
        return explode(DIRECTORY_SEPARATOR, $path);
    }

}


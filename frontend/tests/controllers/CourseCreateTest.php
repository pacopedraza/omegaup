<?php

class CourseCreateTest extends OmegaupTestCase {
    /**
     * Create course hot path
     */
    public function testCreateSchoolCourse() {
        $user = UserFactory::createUser();

        $r = new Request(array(
            'auth_token' => self::login($user),
            'name' => Utils::CreateRandomString(),
            'alias' => Utils::CreateRandomString(),
            'description' => Utils::CreateRandomString(),
            'start_time' => (Utils::GetPhpUnixTimestamp() + 60),
            'finish_time' => (Utils::GetPhpUnixTimestamp() + 120)
        ));

        $response = CourseController::apiCreate($r);

        $this->assertEquals('ok', $response['status']);
        $this->assertEquals(1, count(CoursesDAO::findByName($r['name'])));
    }

    /**
     * Two courses cannot have the same alias
     *
     * @expectedException DuplicatedEntryInDatabaseException
     */
    public function testCreateCourseDuplicatedName() {
        $sameAlias = Utils::CreateRandomString();
        $sameName = Utils::CreateRandomString();

        $user = UserFactory::createUser();

        $r = new Request(array(
            'auth_token' => self::login($user),
            'name' => $sameName,
            'alias' => $sameAlias,
            'description' => Utils::CreateRandomString(),
            'start_time' => (Utils::GetPhpUnixTimestamp() + 60),
            'finish_time' => (Utils::GetPhpUnixTimestamp() + 120)
        ));

        $response = CourseController::apiCreate($r);

        $this->assertEquals('ok', $response['status']);
        $this->assertEquals(1, count(CoursesDAO::findByName($r['name'])));

        // Create a new Course with different alias and name
        $user = UserFactory::createUser();

        $r = new Request(array(
            'auth_token' => self::login($user),
            'name' => $sameName,
            'alias' => $sameAlias,
            'description' => Utils::CreateRandomString(),
            'start_time' => (Utils::GetPhpUnixTimestamp() + 60),
            'finish_time' => (Utils::GetPhpUnixTimestamp() + 120)
        ));

        CourseController::apiCreate($r);
    }

    public function testCreateSchoolAssignment() {
        // Create a test course
        $user = UserFactory::createUser();

        $courseAlias = Utils::CreateRandomString();

        $r = new Request(array(
            'auth_token' => self::login($user),
            'name' => Utils::CreateRandomString(),
            'alias' => $courseAlias,
            'description' => Utils::CreateRandomString(),
            'start_time' => (Utils::GetPhpUnixTimestamp() + 60),
            'finish_time' => (Utils::GetPhpUnixTimestamp() + 120)
        ));

        // Call api
        $course = CourseController::apiCreate($r);
        $this->assertEquals('ok', $course['status']);

        // Create a test course
        $r = new Request(array(
            'auth_token' => self::login($user),
            'name' => Utils::CreateRandomString(),
            'alias' => Utils::CreateRandomString(),
            'description' => Utils::CreateRandomString(),
            'start_time' => (Utils::GetPhpUnixTimestamp() + 60),
            'finish_time' => (Utils::GetPhpUnixTimestamp() + 120),
            'course_alias' => $courseAlias,
            'assignment_type' => 'homework'
        ));
        $course = CourseController::apiCreateAssignment($r);

        // There should exist 1 assignment with this alias
        $this->assertEquals(1, count(AssignmentsDAO::search(
            array('alias' => $r['alias'])
        )));
    }

    /**
     * Tests course/apiListAssignments
     */
    public function testListCourseAssignments() {
        // Create 1 course with 1 assignment
        $courseData = CoursesFactory::createCourseWithOneAssignment();

        $response = CourseController::apiListAssignments(new Request(array(
            'auth_token' => self::login($courseData['user']),
            'course_alias' => $courseData['course_alias']
        )));

        $this->assertEquals(1, count($response['assignments']));

        // Create another course with 5 assignment and list them
        $courseData = CoursesFactory::createCourseWithAssignments(5);

        $response = CourseController::apiListAssignments(new Request(array(
            'auth_token' => self::login($courseData['user']),
            'course_alias' => $courseData['course_alias']
        )));

        $this->assertEquals(5, count($response['assignments']));
    }
}

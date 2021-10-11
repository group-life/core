<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\DataMapper;

use GroupLife\Core\Activity;
use GroupLife\Core\Test\TestCaseWithCoreClasses;

class VisitMapperTest extends TestCaseWithCoreClasses
{
    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws \GroupLife\Core\Exception\SavingToDbIsForbidden
     */
    public function testInsert()
    {
        $visits = $this->activity->subscribe($this->visitor, $this->subscription);
        $this->scheduleMapper->insert($this->schedule);
        $this->leaderMapper->insert($this->leader);
        $this->visitorMapper->insert($this->visitor);
        $this->activityMapper->insert($this->activity);
        $this->subscriptionMapper->insert($this->subscription);
        $this->visitMapper->insert($visits);
        $data = self::$db->fetchAllAssociative(
            'select * from visit where visitor_id = ?',
            [getDataObject($this->visitor)->id]
        );
        self::assertEquals(
            [
                [
                    'id' => getDataObject($visits[0])->id,
                    'activity_id' => getDataObject($this->activity)->id,
                    'visitor_id' => getDataObject($this->visitor)->id,
                    'time' => getDataObject($visits[0])->time->date,
                    'status' => getDataObject($visits[0])->status,
                ],
                [
                    'id' => getDataObject($visits[1])->id,
                    'activity_id' => getDataObject($this->activity)->id,
                    'visitor_id' => getDataObject($this->visitor)->id,
                    'time' => getDataObject($visits[1])->time->date,
                    'status' => getDataObject($visits[1])->status,
                ]
            ],
            $data
        );
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws \GroupLife\Core\Exception\LoadFromDbImpossible
     */
    public function testFind()
    {
        self::assertInstanceOf(Activity\Visit::class, $this->visitMapper->find(
            1,
            $this->activityMapper,
            $this->visitorMapper,
            $this->leaderMapper,
            $this->scheduleMapper
        ));
    }

    /**
     * @throws \GroupLife\Core\Exception\LoadFromDbImpossible
     * @throws \GroupLife\Core\Exception\WrongVisitStatus
     * @throws \Doctrine\DBAL\Exception
     */
    public function testUpdate()
    {
        $visit = $this->visitMapper->find(
            1,
            $this->activityMapper,
            $this->visitorMapper,
            $this->leaderMapper,
            $this->scheduleMapper
        );
        self::assertEquals('planned', getDataObject($visit)->status);
        $visit->changeStatus('confirmed');
        $this->visitMapper->update($visit);
        self::assertEquals(
            ['status' => 'confirmed'],
            self::$db->fetchAssociative('select status from visit where id = 1')
        );
        $visit->changeStatus('planned');
        $this->visitMapper->update($visit);
        self::assertEquals('planned', (self::$db->fetchAssociative('select status from visit where id = 1'))['status']);
    }
}

<?php

declare(strict_types=1);

namespace GroupLife\Core\Activity;

use GroupLife\Core\Activity;
use GroupLife\Core\Exception\WrongVisitStatus;
use GroupLife\Core\Subscription\SubscriptionInterface;
use GroupLife\Core\Visitor;

class Visit implements \JsonSerializable
{
    private $id;
    private $time;
    private $status;
    private $activity;
    private $visitor;

    /**
     * @param \DateTimeImmutable $time date and time of a visit
     * @param Activity $activity what activity to be visit
     * @param Visitor $visitor who will visit
     */
    public function __construct(
        \DateTimeImmutable $time,
        Activity $activity,
        Visitor $visitor,
    ) {
        $this->time = $time;
        $this->activity = $activity;
        $this->status = 'planned';
        $this->visitor = $visitor;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        $data = new \stdClass();
        $data->id = $this->id;
        $data->time = $this->time;
        $data->status = $this->status;
        $data->activity = $this->activity;
        $data->visitor = $this->visitor;
        return $data;
    }

    /**
     * @param int $id
     */
    public function persists(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $status
     * @throws WrongVisitStatus
     */
    public function changeStatus(string $status): void
    {
        switch ($status) {
            case ('planned'):
                $this->status = 'planned';
                break;
            case ('confirmed'):
                $this->status = 'confirmed';
                break;
            case ('visited'):
                $this->status = 'visited';
                break;
            default:
                throw new WrongVisitStatus('The visit status cannot be updated');
        }
    }
}

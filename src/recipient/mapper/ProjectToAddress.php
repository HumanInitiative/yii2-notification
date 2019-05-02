<?php

namespace pkpudev\notification\recipient\mapper;

use pkpudev\notification\event\ProjectActionEvent as Event;
use pkpudev\notification\event\ModelEventInterface;
use pkpudev\notification\recipient\RecipientQuery;
use pkpudev\notification\recipient\Role;
use pkpudev\notification\transform\DataTransformInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class ProjectToAddress implements RecipientAddressInterface
{
    /**
     * @var DataTransformInterface $query
     */
    private $transform;
    /**
     * @var RecipientQuery $query
     */
    private $query;
    /**
     * @var ModelEventInterface $event
     */
    private $event;
    /**
     * @var int $pusat
     */
    private $pusat = 1;

    /**
     * @inheritdoc
     */
    public function __construct(
        DataTransformInterface $transform,
        RecipientQuery $query,
        ModelEventInterface $event
    ) {
        $this->transform = $transform;
        $this->query = $query;
        $this->event = $event;
    }

    /**
     * @inheritdoc
     */
    public function getAll()
    {
        $eventName = $this->event->name;
        $eventIsRamadhan = $this->event->getIsRamadhan();
        $emails = null;

        if ($eventName == Event::EVENT_CREATE) {
            $emails = array_merge(
                $this->query->getByRole(Role::QAQC), // QAQC
                $this->query->getByRole(Role::VER) // VER
            );
        } elseif ($eventName == Event::EVENT_VERIFY_QC) {
            // Approve
            $emails = $this->query->getByRole(Role::QAQC); // QAQC
        } elseif ($eventName == Event::EVENT_VERIFY_RMD) {
            // Approve
            $emails = $this->query->getByRole(Role::RMD); // RMD
            $emails[] = $this->transform->getCreatorEmail(); // CREA
            $emails[] = $this->transform->getPicEmail(); // PIC
        } elseif ($eventName == Event::EVENT_COMMENT) {
            /* TODO */
        } elseif ($eventName == Event::EVENT_RUNNING) {
            $emails = [$this->transform->getPicEmail()]; // PIC
        } elseif ($eventName == Event::EVENT_FINISHING) {
            // Finish
            $emails = [$this->transform->getPicEmail()]; // PIC
        } elseif ($eventName == Event::EVENT_VERIFYFINISH) {
            // Close
            $emails = [$this->transform->getPicEmail()]; // PIC
        } elseif ($eventName == Event::EVENT_ALERT_EXECDATE) {
            $emails = [$this->transform->getPicEmail()]; // PIC
        } elseif ($eventName == Event::EVENT_UPLOAD_REPORT) {
            $emails = $this->query->getByRole(Role::QAQC); // QAQC
        }

        return $emails;
    }
}
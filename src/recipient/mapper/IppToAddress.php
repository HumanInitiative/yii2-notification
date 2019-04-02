<?php

namespace pkpudev\notification\recipient\mapper;

use pkpudev\notification\event\IppActionEvent as Event;
use pkpudev\notification\event\ModelEventInterface;
use pkpudev\notification\recipient\RecipientQuery;
use pkpudev\notification\recipient\Role;
use pkpudev\notification\transform\DataTransformInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class IppToAddress implements RecipientAddressInterface
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
        $branchId = $this->query->branchId;
        $companyId = $this->query->companyId;
        $eventIsFromIzi = $this->event->isFromIzi;
        $eventName = $this->event->name;
        $modelName = $this->query->modelName;
        $emails = [];

        $fnGetAllFromBranch = function () use ($modelName, $companyId, $branchId) {
            $query = RecipientQuery::fromBranch($modelName, $companyId, $branchId);
            return $query->getAll();
        };

        if ($eventName == Event::EVENT_CREATE) {
            if ($branchId == $this->pusat) {
                $emails = $this->query->getByRole(Role::VERKEU); // VERKEU
                if ($eventIsFromIzi) {
                    $emails[] = $this->transform->getPicEmail(); // PIC
                    $emails[] = $this->transform->getCreatorEmail(); // CREA
                } else {
                    // $emails[] = $this->query->getByRole(Role::QAQC);
                    $emails = array_merge($emails, $this->query->getByRole(Role::QAQC)); // QAQC
                }
            } else {
                $emails = $fnGetAllFromBranch(); // Branch
                if ($companyId) {
                    $emails = array_merge($emails, $this->query->getByRole(Role::QAQC)); // QAQC
                }
            }
        } elseif ($eventName == Event::EVENT_APPROVE) {
            if ($branchId == $this->pusat) {
                // PIC
                $emails = [$this->transform->getPicEmail()]; // PIC
            } else {
                $emails = $fnGetAllFromBranch(); // Branch
            }
        } elseif ($eventName == Event::EVENT_COMMENT) {
            /* TODO */
        } elseif ($eventName == Event::EVENT_FEE_MANAGEMENT) {
            $emails = $this->query->getByRole(Role::QAQC); // QAQC
        } elseif ($eventName == Event::EVENT_REJECT) {
            if ($branchId == $this->pusat) {
                $emails = [
                    $this->transform->getCreatorEmail(), // CREA
                    $this->transform->getMarketerEmail(), // MRKT
                ];
            } else {
                $emails = $fnGetAllFromBranch(); // Branch
            }
        }

        return $emails;
    }
}
<?php

namespace pkpudev\notification\event;

use yii\base\ModelEvent;
use yii\db\ActiveRecordInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class IppEvent extends ModelEvent implements ModelEventInterface
{
    protected $id;
    protected $status_id;
    protected $company_id;
    protected $fund_driven_id;
    protected $from_izi;

    public function __construct(ActiveRecordInterface $model, $eventName)
    {
        $this->id = $model->id;
        $this->name = $eventName;
        $this->status_id = $model->status_id;
        $this->company_id = $model->company_id;
        $this->fund_driven_id = $model->fund_driven_id;
        $this->from_izi = $model->from_izi;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getStatusId()
    {
        return $this->status_id;
    }

    public function getIsFromIzi()
    {
        return (
            $this->from_izi == 1 || 
            (
                $this->company_id == 2 && /* IZI */
                $this->fund_driven_id == 2 /* RKAT */
            )
        );
    }

    public function getCompanyId()
    {
        return $this->company_id;
    }

    public function getEventDesc()
    {
        if ($this->name == IppActionEvent::EVENT_CREATE) {
            return "telah dibuat";
        } elseif ($this->name == IppActionEvent::EVENT_APPROVE) {
            return "di-APPROVE Keuangan";
        } elseif ($this->name == IppActionEvent::EVENT_FEE_MANAGEMENT) {
            return "Fee Management";
        } elseif ($this->name == IppActionEvent::EVENT_REJECT) {
            return "DITOLAK oleh Keuangan";
        } elseif ($this->name == IppActionEvent::EVENT_COMMENT) {
            return "Komentar terbaru";
        }
    }

    public function getEventFile()
    {
        if ($this->name == IppActionEvent::EVENT_CREATE) {
            return "ipp-create";
        } elseif ($this->name == IppActionEvent::EVENT_APPROVE) {
            return "ipp-approve";
        } elseif ($this->name == IppActionEvent::EVENT_FEE_MANAGEMENT) {
            return "ipp-feemgmt";
        } elseif ($this->name == IppActionEvent::EVENT_REJECT) {
            return "ipp-reject";
        } elseif ($this->name == IppActionEvent::EVENT_COMMENT) {
            return "ipp-comment";
        }
    }
}
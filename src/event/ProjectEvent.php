<?php

namespace pkpudev\notification\event;

use yii\base\ModelEvent;
use yii\db\ActiveRecordInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class ProjectEvent extends ModelEvent implements ModelEventInterface
{
    protected $id;
    protected $status_id;
    protected $execdate_start;
    protected $is_ramadhan;

    public function __construct(ActiveRecordInterface $model, $eventName)
    {
        $this->id = $model->id;
        $this->name = $eventName;
        $this->status_id = $model->status_id;
        $this->execdate_start = date("d-m-Y", strtotime($model->realize_date_start));
        $this->is_ramadhan = $model->getIsRamadhan();
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

    public function getIsRamadhan()
    {
        return $this->is_ramadhan;
    }

    public function getEventDesc()
    {
        if ($this->name == ProjectActionEvent::EVENT_CREATE) {
            return "telah dibuat";
        } elseif ($this->name == ProjectActionEvent::EVENT_VERIFY_QC) {
            return "telah diverifikasi";
        } elseif ($this->name == ProjectActionEvent::EVENT_VERIFY_RMD) {
            return "telah diverifikasi";
        } elseif ($this->name == ProjectActionEvent::EVENT_COMMENT) {
            return "Komentar terbaru";
        } elseif ($this->name == ProjectActionEvent::EVENT_RUNNING) {
            return "telah berjalan";
        } elseif ($this->name == ProjectActionEvent::EVENT_FINISHING) {
            return "telah selesai";
        } elseif ($this->name == ProjectActionEvent::EVENT_VERIFYFINISH) {
            return "telah diverifikasi dan dinyatakan Finish";
        } elseif ($this->name == ProjectActionEvent::EVENT_ALERT_EXECDATE) {
            return "akan dieksekusi tanggal {$this->execdate_start}";
        } elseif ($this->name == ProjectActionEvent::EVENT_UPLOAD_REPORT) {
            return " - Laporan telah diupload";
        }
    }

    public function getEventFile()
    {
        if ($this->name == ProjectActionEvent::EVENT_CREATE) {
            return "project-create";
        } elseif ($this->name == ProjectActionEvent::EVENT_VERIFY_QC) {
            return "project-verify-qaqc";
        } elseif ($this->name == ProjectActionEvent::EVENT_VERIFY_RMD) {
            return "project-verify-ramadhan";
        } elseif ($this->name == ProjectActionEvent::EVENT_COMMENT) {
            return "project-comment";
        } elseif ($this->name == ProjectActionEvent::EVENT_RUNNING) {
            return "project-running";
        } elseif ($this->name == ProjectActionEvent::EVENT_FINISHING) {
            return "project-finishing";
        } elseif ($this->name == ProjectActionEvent::EVENT_VERIFYFINISH) {
            return "project-verify-finish";
        } elseif ($this->name == ProjectActionEvent::EVENT_ALERT_EXECDATE) {
            return "project-alert-execdate";
        } elseif ($this->name == ProjectActionEvent::EVENT_UPLOAD_REPORT) {
            return "project-report-upload";
        }
    }
}
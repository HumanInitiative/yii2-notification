<?php

namespace pkpudev\notification\event;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
interface IppActionEvent extends ActionEvent
{
    // Ipp
    const EVENT_CREATE = 'create';
    const EVENT_UPDATE = 'update';
    const EVENT_SET_NEW = 'set_new';
    const EVENT_APPROVE = 'approve'; //keu
    const EVENT_APPROVE_RAMADHAN = 'approve_rmd'; //qc | pdg
    const EVENT_REJECT = 'reject'; //cancelled
    const EVENT_REVISI = 'revisi_keu';
    const EVENT_COMMENT = 'comment';
    const EVENT_FEE_MANAGEMENT = 'fee_mgmt';
    const EVENT_DOWNLOAD_DATA = 'download_data';
    // IppFile
    const EVENT_UPLOAD_FILE = 'upload_file';
    const EVENT_DELETE_FILE = 'delete_file';
}
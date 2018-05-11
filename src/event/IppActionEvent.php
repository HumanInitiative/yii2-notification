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
	const EVENT_APPROVE_KEU = 'approve_keu';
	const EVENT_APPROVE_QC = 'approve_qc';
	const EVENT_APPROVE_PDG = 'approve_pdg';
	const EVENT_REJECT = 'reject'; //cancelled
	const EVENT_COMMENT = 'comment';
	const EVENT_REVISI_KEU = 'revisi_keu';
	const EVENT_FEE_MANAGEMENT = 'fee_mgmt';
	const EVENT_DOWNLOAD_DATA = 'download_data';
	// IppFile
	const EVENT_UPLOAD_FILE = 'upload_file';
	const EVENT_DELETE_FILE = 'delete_file';
}
<?php

namespace pkpudev\notification\event;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
interface ProjectActionEvent extends ActionEvent
{
	// Project
	const EVENT_DRAFT = 'draft';
	const EVENT_CREATE = 'create';
	const EVENT_UPDATE = 'update';
	const EVENT_REVISION = 'revision';
	const EVENT_COMMENT = 'comment';
	const EVENT_VERIFY_QC = 'verify_qc';
	const EVENT_VERIFY_RMD = 'verify_rmd'; //Ramadhan
	const EVENT_VERIFY_BKS = 'verify_bks';
	const EVENT_RUNNING = 'running';
	const EVENT_EXECUTING = 'executing';
	const EVENT_FINISHING = 'finishing';
	const EVENT_VERIFYFINISH = 'verifyfinish';
	const EVENT_CLOSED = 'closed';
	const EVENT_REJECTED = 'rejected';
	// ProjectFile
	const EVENT_UPLOAD_FILE = 'upload_file';
	const EVENT_DELETE_FILE = 'delete_file';
	// ProjectReport
	const EVENT_UPLOAD_REPORT = 'upload_report';
	// Alert
	const EVENT_ALERT_EXECDATE = 'alert_execdate';
}
window.Alpine = require('alpinejs');
Alpine.default.start();

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
*/

try {
	require('bootstrap/dist/js/bootstrap.bundle');
	window.$ = window.jQuery = require('jquery/dist/jquery');
	require('@claviska/jquery-minicolors');
	require('@fortawesome/fontawesome-free');

	require('datatables.net');
	require('datatables.net-bs5');
	require('datatables.net-autofill-bs5');
	require('datatables.net-colreorder-bs5');
	require('datatables.net-fixedheader-bs5');
	require('datatables.net-responsive-bs5');
	require('datatables.net-buttons-bs5');
	require('datatables.net-buttons/js/buttons.html5');
	require('datatables.net-buttons/js/buttons.print');
	require('datatables.net-buttons/js/buttons.colVis');

	require('./dataTable-any-number');
	require('./datetime-moment');

	require('select2');
	// select2();

	require('pc-bootstrap4-datetimepicker');

	window.moment = require('moment');
	moment().format();

	window.swal = require ('sweetalert2');

	require('./bootstrapValidator4/js/bootstrapValidator');

	require('./jquery-ui-prefix');

	require('./bootstrap');

	require('./fullcalendar');

	require('./chart');

} catch (e) {}

require('./bootstrap');
require('datatables.net');
require('moment');
require('./datetimepicker');
require('select2');

import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

ClassicEditor
    .create(document.querySelector('#editor'))
    .then(editor => {
        window.editor = editor;
        editor.ui.view.editable.element.style.height = '200px';
    })
    .catch(error => {
        console.error('There was a problem initializing the editor.', error);
    });

import 'select2/dist/css/select2.css';
import {
    library,
    dom
} from '@fortawesome/fontawesome-svg-core';

import 'sweetalert';
import {
    faFacebook,
    faLinkedin,
    faTwitter,
    faYoutube
} from '@fortawesome/free-brands-svg-icons';
import {
    faBars,
    faSearch,
    faChevronLeft,
    faChevronRight,
    faCommentAlt,
    faEye,
    faArrowCircleRight,
    faBook,
    faBolt,
    faDownload,
    faChartPie,
    faMoneyBillWave,
    faShoppingCart,
    faHandHoldingUsd,
    faColumns,
    faGlobe,
    faCalculator,
    faClipboardList,
    faRocket,
    faMeteor,
    faList,
    faClock,
    faSignOutAlt,
    faCog,
    faCalendarDay,
    faCalendar,
    faUpload,
    faStickyNote,
    faCompass,
    faUsers,
    faEdit,
    faTrash,

} from '@fortawesome/free-solid-svg-icons';
// add the imported icons to the library
library.add(faBars, faSearch, faCommentAlt, faEye, faChevronLeft, faChevronRight, faFacebook, faTwitter, faLinkedin, faYoutube, faBolt, faDownload, faArrowCircleRight, faBook, faChartPie, faMoneyBillWave, faShoppingCart, faHandHoldingUsd, faColumns, faGlobe, faCalculator, faClipboardList, faRocket, faMeteor, faList, faClock, faSignOutAlt, faCog, faCalendarDay, faCalendar, faUpload, faStickyNote, faCompass, faUsers, faEdit, faTrash);

// tell FontAwesome to watch the DOM and add the SVGs when it detects icon markup
dom.watch();

$('#datetimepicker').datetimepicker({
    format: 'YYYY-MM-DD',
});


$('.dataTable').DataTable( {
    responsive: true
});

$(".js-example-basic-multiple").select2({
    multiple: true,
    tags: true,
});

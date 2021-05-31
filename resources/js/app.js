require('./bootstrap');
require('./datatable');
// require( 'datatables.net-bs' );
require('moment');
require('./datetimepicker');
require('select2');
require('./morris');
require('./ck-editor');

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
    faUser,
    faCreditCard,
    faPowerOff,
    faUniversity,
    faBan,faDollarSign,
    faPlug,

} from '@fortawesome/free-solid-svg-icons';
// add the imported icons to the library
library.add(faBars, faSearch, faCommentAlt, faEye, faChevronLeft, faChevronRight, faFacebook, faTwitter, faLinkedin, faYoutube, faBolt, faDownload, faArrowCircleRight, faBook, faChartPie, faMoneyBillWave, faShoppingCart, faHandHoldingUsd, faColumns, faGlobe, faCalculator, faClipboardList, faRocket, faMeteor, faList, faClock, faSignOutAlt, faCog, faCalendarDay, faCalendar, faUpload, faStickyNote, faCompass, faUsers, faEdit, faTrash,faUser,faCreditCard,faPowerOff,faUniversity,faBan,faDollarSign,faPlug);

// tell FontAwesome to watch the DOM and add the SVGs when it detects icon markup
dom.watch();


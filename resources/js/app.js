require('./bootstrap');
require('./datatable');
require('moment');
require('./datetimepicker');
require('select2');
require('./morris');
require('./custom');

import 'select2/dist/css/select2.css';
require('./quill.js');

window.Quill = require('Quill');
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
    faEdit,
    faTrash,
    faUserCircle,
    faCreditCard,
    faPowerOff,
    faUniversity,
    faBan,
    faDollarSign,
    faPlug,
    faTimes,
    faSignInAlt,
    faMinus,
    faUser,
    faUsers,
    faSort,
    faIndustry,
    faFile,
    faNewspaper,
    faFolder

} from '@fortawesome/free-solid-svg-icons';
// add the imported icons to the library
library.add(faFolder, faNewspaper, faFile, faBars, faSearch, faCommentAlt, faEye, faChevronLeft, faChevronRight, faFacebook, faTwitter, faLinkedin, faYoutube, faBolt, faDownload, faArrowCircleRight, faBook, faChartPie, faMoneyBillWave, faShoppingCart, faHandHoldingUsd, faColumns, faGlobe, faCalculator, faClipboardList, faRocket, faMeteor, faList, faClock, faSignOutAlt, faCog, faCalendarDay, faCalendar, faUpload, faStickyNote, faCompass, faEdit, faTrash, faUserCircle, faCreditCard, faPowerOff, faUniversity, faBan, faDollarSign, faPlug, faTimes, faSignInAlt, faMinus, faUser, faUsers, faSort, faIndustry);

// tell FontAwesome to watch the DOM and add the SVGs when it detects icon markup
dom.watch();


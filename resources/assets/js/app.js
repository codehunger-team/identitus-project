import 'jquery';
import swal from 'sweetalert';

import {library, dom} from '@fortawesome/fontawesome-svg-core';
import {faFacebook, faLinkedin, faTwitter, faYoutube, faDiscourse} from '@fortawesome/free-brands-svg-icons';
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
} from '@fortawesome/free-solid-svg-icons';
// add the imported icons to the library
library.add(faBars, faSearch, faCommentAlt, faEye, faChevronLeft, faChevronRight, faFacebook, faTwitter, faLinkedin, faYoutube, faDiscourse, faBolt, faDownload, faArrowCircleRight, faBook);

// tell FontAwesome to watch the DOM and add the SVGs when it detects icon markup
dom.watch();

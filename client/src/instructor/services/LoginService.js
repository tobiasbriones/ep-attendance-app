/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

import { getCookie, setCookie } from '../../tools/Cookies';

const INSTRUCTOR_JWT_CNAME = 'instructor-jwt';
const INSTRUCTOR_JWT_EXP_DAYS = 30;

export default {
  saveInstructorLogin(instructorJWT) {
    setCookie(INSTRUCTOR_JWT_CNAME, instructorJWT, INSTRUCTOR_JWT_EXP_DAYS);
  },
  loadInstructorJWT() {
    return getCookie(INSTRUCTOR_JWT_CNAME);
  }
};

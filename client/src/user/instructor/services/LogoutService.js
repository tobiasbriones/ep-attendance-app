/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

import { setCookie } from '../../../tools/Cookies';

const INSTRUCTOR_JWT_CNAME = 'instructor-jwt';

export default {
  logout() {
    setCookie(INSTRUCTOR_JWT_CNAME, '');
  }
};

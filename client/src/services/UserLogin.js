/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

import { getCookie, setCookie } from '../tools/Cookies';

const USER_TYPE_CNAME = 'user-type';

export default {
  USER_TYPE_CNAME,
  setUserType(userType, expDays) {
    setCookie(USER_TYPE_CNAME, userType, expDays);
  },
  getUserType() {
    return getCookie(USER_TYPE_CNAME);
  }
};

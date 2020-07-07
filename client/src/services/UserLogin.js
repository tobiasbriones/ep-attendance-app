/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

import { getCookie } from '../tools/Cookies';

const USER_TYPE_CNAME = 'user-type';

export default {
  getUserType() {
    return getCookie(USER_TYPE_CNAME);
  }
}

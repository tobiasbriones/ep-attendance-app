/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

import { setCookie } from '../tools/Cookies';
import UserLogin from './UserLogin';
import LogoutService from '../instructor/services/LogoutService';

export default {
  logout() {
    setCookie(UserLogin.USER_TYPE_CNAME, '');
    LogoutService.logout();
  }
};

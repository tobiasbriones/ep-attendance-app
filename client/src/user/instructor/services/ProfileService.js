/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

import Api from '../../../services/Api';

const profileEndPoint = 'instructors.php';

const getConfig = (jwt) => {
  return {
    headers: {
      'Authorization': `Bearer ${jwt}`
    }
  };
};

export default {
  retrieve(jwt) {
    return Api.get(profileEndPoint, getConfig(jwt));
  },
};

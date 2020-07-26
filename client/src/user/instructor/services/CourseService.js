/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

import Api from '../../../services/Api';

const courseEndPoint = 'instructors/courses.php';

const getConfig = (jwt) => {
  return {
    headers: {
      'Authorization': `Bearer ${ jwt }`
    }
  };
};

export default {
  async read() {
    return (await Api.get(courseEndPoint))['data']['data'];
  },
  update(jwt, data) {
    const config = getConfig(jwt);
    return Api.put(courseEndPoint, data, config);
  }
};

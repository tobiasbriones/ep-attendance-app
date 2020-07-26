/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

import Api from '../../../services/Api';

const courseSetupEndPoint = 'instructors/courses.php';

const getConfig = (jwt) => {
  return {
    headers: {
      'Authorization': `Bearer ${jwt}`
    }
  };
};

export default {
  update(jwt, data) {
    const config = getConfig(jwt);
    return Api.put(courseSetupEndPoint, data, config);
  }
};

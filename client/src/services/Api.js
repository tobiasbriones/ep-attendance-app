/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://localhost:8000/api/v1/'
});

export default instance;

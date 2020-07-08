/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

import Home from './components/Home';
import StudentSignIn from './components/StudentSignUp';
import VueRouter from 'vue-router';
import InstructorPanel from './components/InstructorPanel';

const routes = [
  {
    path: '/',
    component: Home
  },
  {
    path: '/student/register',
    component: StudentSignIn
  },
  {
    path: '/instructor/dashboard',
    component: InstructorPanel
  }
];

export default new VueRouter(
  {
    routes: routes,
    mode: 'history'
  }
);

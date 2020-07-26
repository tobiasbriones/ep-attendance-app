/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

import Vuex from 'vuex';
import Vue from 'vue';
import * as firebase from './firebase';
import router from './routes';
import CourseService from './user/instructor/services/CourseService';

Vue.use(Vuex);

export default new Vuex.Store(
  {
    state: {
      studentProfile: {},
      instructorData: {},
      course: {}
    },
    mutations: {
      setStudentProfile(state, profile) {
        state.studentProfile = profile;
      },
      setInstructorData(state, data) {
        state.instructorData = data;
      },
      setCourse(state, course) {
        state.course = course;
      }
    },
    getters: {
      studentProfile: state => {
        return state.studentProfile;
      },
      instructorData: state => {
        return state.instructorData;
      },
      course: state => {
        return state.course;
      }
    },
    actions: {
      async fetchStudentProfile({ commit }, user) {
        const userProfile = await firebase.usersCollection.doc(user.uid).get();
        
        commit('setStudentProfile', userProfile.data());
        await router.push('/');
      },
      async login({ dispatch }, form) {
        const { auth } = firebase;
        const { user } = await auth.signInWithEmailAndPassword(form.email, form.password);
        
        dispatch('fetchStudentProfile', user);
      },
      async signUp({ dispatch }, form) {
        const { auth } = firebase;
        const { user } = await auth.createUserWithEmailAndPassword(form.email, form.password);
        
        await firebase.usersCollection
                      .doc(user.uid)
                      .set(
                        {
                          name: form.name
                        }
                      );
        dispatch('fetchStudentProfile', user);
      },
      async loadCourse({ commit }) {
        const course = await CourseService.read();
        commit('setCourse', course);
      },
      setInstructorData({ commit }, data) {
        commit('setInstructorData', data);
      }
    }
  }
);

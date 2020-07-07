/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

import firebase from 'firebase/app';
import 'firebase/auth';
import 'firebase/firestore';

const firebaseConfig = {
  apiKey: 'AIzaSyA1u9vHAKj271d87gYpMTrw4n1D--gmGa4',
  authDomain: 'attendance-app-ep.firebaseapp.com',
  databaseURL: 'https://attendance-app-ep.firebaseio.com',
  projectId: 'attendance-app-ep',
  storageBucket: 'attendance-app-ep.appspot.com',
  messagingSenderId: '922567292990',
  appId: '1:922567292990:web:e7ee326adb0ddc2e18396f',
  measurementId: 'G-H8MJMQSZNG'
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

const db = firebase.firestore();
const auth = firebase.auth();
const usersCollection = db.collection('users')

export {
  db,
  auth,
  usersCollection
};

/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

const setCookie = (name, value, expDays) => {
  const date = new Date();
  const expires = 'expires=${date.toUTCString()}';
  
  date.setTime(date.getTime() + (expDays * 24 * 60 * 60 * 1000));
  document.cookie = `${ name }=${ value };${ expires };path=/`;
};

const getCookie = (cname) => {
  const name = `${ cname }=`;
  const decodedCookie = decodeURIComponent(document.cookie);
  const ca = decodedCookie.split(';');
  
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    
    while (c.charAt(0) === ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) === 0) {
      return c.substring(name.length, c.length);
    }
  }
  return '';
};

module.exports = {
  setCookie,
  getCookie
}

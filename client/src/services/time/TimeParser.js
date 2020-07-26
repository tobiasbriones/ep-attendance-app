/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

const createTime = (hours, minutes) => {
  const normalized = normalize(parseInt(hours), parseInt(minutes));
  
  return {
    hours: normalized.hours,
    minutes: normalized.minutes,
    toString: () => toString(hours, minutes)
  };
};

const fromString = (timeStr) => {
  if (timeStr.charAt(2) !== ':') throw `Invalid time string: ${ timeStr }`;
  const hours = timeStr.substring(0, 2);
  const minutes = timeStr.substring(3, 5);
  return createTime(hours, minutes);
};

const sum = (timeA, timeB) => {
  const hours = timeA.hours + timeB.hours;
  const minutes = timeA.minutes + timeB.minutes;
  return createTime(hours, minutes);
};

const toString = (hours, minutes) => {
  const fillLeft = value => `0${ value }`;
  const needsToFill = value => value.length === 1;
  let hoursStr = hours.toString();
  let minutesStr = minutes.toString();
  
  if (needsToFill(hoursStr)) {
    hoursStr = fillLeft(hoursStr);
  }
  if (needsToFill(minutesStr)) {
    minutesStr = fillLeft(minutesStr);
  }
  return `${ hoursStr }:${ minutesStr }:00`;
};

const getClockHours = (hours) => {
  return hours % 24;
};

const getClockMinutes = (minutes) => {
  return minutes % 60;
};

const getHoursFromMinutes = (minutes) => {
  const exceedingHours = Math.floor(minutes / 60);
  return getClockHours(exceedingHours);
};

const normalize = (hours, minutes) => {
  const normalized = {
    hours: hours,
    minutes: minutes
  };
  if (hours < 0 || minutes < 0) {
    normalized.hours = 0;
    normalized.minutes = 0;
    return normalized;
  }
  if (hours < 24 && minutes < 60) {
    return normalized;
  }
  if (minutes >= 60) {
    const clockMinutes = getClockMinutes(minutes);
    const exceedingHours = getHoursFromMinutes(minutes);
    
    normalized.hours = getClockHours(hours + exceedingHours);
    normalized.minutes = clockMinutes;
  }
  else {
    normalized.hours = getClockHours(hours);
    normalized.minutes = minutes;
  }
  return normalized;
};

export default {
  createTime,
  fromString,
  sum
};

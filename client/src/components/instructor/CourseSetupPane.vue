<!--
  -- Copyright (c) 2020 Tobias Briones.
  --
  -- This source code is licensed under the MIT license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<template>
  <b-form id="course-setup-form" @submit="onSubmit" @reset="onReset">
    <p>
      Setup your course
    </p>
    <b-form-group
      id="input-group-course-name"
      label="Course name:"
      label-for="input-course-name"
      description="Course name to create and allow students to participate">
      <b-form-input
        id="input-course-name"
        v-model="data.name"
        type="text"
        required
        placeholder="Enter the course name">
      </b-form-input>
    </b-form-group>
    
    <b-form-group id="input-group-start-time"
                  label="Start time:"
                  label-for="input-start-time"
                  description="Start time to allow students to go live">
      <b-form-timepicker id="input-start-time"
                         v-model="data.startTime"
                         locale="en">
      </b-form-timepicker>
    </b-form-group>
    
    <b-form-group id="input-group-duration"
                  label="Duration (min):"
                  label-for="input-duration"
                  description="Course duration in minutes to end the live session">
      <b-form-input
        id="input-duration"
        v-model="data.durationMin"
        type="number"
        required
        placeholder="Enter the course duration in minutes">
      </b-form-input>
    </b-form-group>
    
    <b-form-group id="input-group-link"
                  label="Meeting link (YouTube):"
                  label-for="input-duration"
                  description="Meeting link to allow connections at the specified time">
      <b-form-input
        id="input-link"
        v-model="data.link"
        type="text"
        required
        placeholder="Enter the YouTube live video link">
      </b-form-input>
    </b-form-group>
    
    <div>
      <b-form-checkbox
        id="checkbox-1"
        v-model="data.days.monday"
        name="checkbox-1"
        value="true"
        unchecked-value="false">
        Monday
      </b-form-checkbox>
      <b-form-checkbox
        id="checkbox-2"
        v-model="data.days.tuesday"
        name="checkbox-2"
        value="true"
        unchecked-value="false">
        Tuesday
      </b-form-checkbox>
      <b-form-checkbox
        id="checkbox-3"
        v-model="data.days.wednesday"
        name="checkbox-3"
        value="true"
        unchecked-value="false">
        Wednesday
      </b-form-checkbox>
      <b-form-checkbox
        id="checkbox-4"
        v-model="data.days.thursday"
        name="checkbox-4"
        value="true"
        unchecked-value="false">
        Thursday
      </b-form-checkbox>
      <b-form-checkbox
        id="checkbox-5"
        v-model="data.days.friday"
        name="checkbox-5"
        value="true"
        unchecked-value="false">
        Friday
      </b-form-checkbox>
      <b-form-checkbox
        id="checkbox-6"
        v-model="data.days.saturday"
        name="checkbox-6"
        value="true"
        unchecked-value="false">
        Saturday
      </b-form-checkbox>
      <b-form-checkbox
        id="checkbox-7"
        v-model="data.days.sunday"
        name="checkbox-7"
        value="true"
        unchecked-value="false">
        Sunday
      </b-form-checkbox>
    </div>
    
    <b-button type="submit" variant="primary">Submit</b-button>
    <b-button type="reset" variant="danger">Reset</b-button>
  </b-form>
</template>

<script>
  import TimeParser from '../../services/time/TimeParser';
  
  export default {
    name: 'CourseSetupPane',
    data() {
      return {
        data: {
          name: '',
          startTime: '07:00:00',
          durationMin: 60,
          link: '',
          days: {
            monday: 'true',
            tuesday: 'true',
            wednesday: 'true',
            thursday: 'true',
            friday: 'true',
            saturday: 'false',
            sunday: 'false'
          }
        }
      };
    },
    methods: {
      getDays() {
        const days = [];
        let i = 1;
        
        for (const [key] of Object.entries(this.data.days)) {
          if (this.data.days[key] === 'true') {
            days.push(i);
          }
          i++;
        }
        return days;
      },
      onSubmit(e) {
        e.preventDefault();
        const startTime = TimeParser.fromString(this.data.startTime);
        const durationTime = TimeParser.createTime(0, this.data.durationMin);
        const endTime = TimeParser.sum(startTime, durationTime).toString();
        const data = {
          name: this.data.name,
          startTime: this.data.startTime,
          endTime: endTime,
          link: this.data.link,
          days: this.getDays()
        };
        this.$emit('onUpdateCourse', data);
      },
      onReset() {
        this.data.name = '';
        this.data.startTime = '07:00:00';
        this.data.durationMin = 60;
        this.data.link = '';
      }
    }
  };
</script>

<style scoped>
  #course-setup-form {
    display: block;
    width: 100%;
    padding: 48px;
  }
  
  #course-setup-form > p {
    text-align: center;
    font-weight: bold;
  }
  
  #course-setup-form button[type=submit] {
    width: 50%;
  }
  
  #course-setup-form button[type=reset] {
    width: 40%;
    float: right;
  }
  
  @media (min-width: 600px) {
    #course-setup-form {
      width: 60%;
    }
  }
  
  @media (min-width: 1360px) {
    #course-setup-form {
      width: 40%;
      padding: 64px;
    }
  }
</style>

<!--
  -- Copyright (c) 2020 Tobias Briones.
  --
  -- This source code is licensed under the MIT license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<template>
  <b-form @submit="onSubmit" @reset="onReset">
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
        v-model="form.name"
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
                         v-model="form.startTime"
                         locale="en">
      </b-form-timepicker>
    </b-form-group>
    
    <b-form-group id="input-group-duration"
                  label="Duration (min):"
                  label-for="input-duration"
                  description="Course duration in minutes to end the live session">
      <b-form-input
        id="input-duration"
        v-model="form.durationMin"
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
        v-model="form.link"
        type="text"
        required
        placeholder="Enter the YouTube live video link">
      </b-form-input>
    </b-form-group>
    
    <div class="days">
      <b-form-checkbox
        id="checkbox-1"
        v-model="form.days.monday"
        name="checkbox-1"
        value="true"
        unchecked-value="false">
        Monday
      </b-form-checkbox>
      <b-form-checkbox
        id="checkbox-2"
        v-model="form.days.tuesday"
        name="checkbox-2"
        value="true"
        unchecked-value="false">
        Tuesday
      </b-form-checkbox>
      <b-form-checkbox
        id="checkbox-3"
        v-model="form.days.wednesday"
        name="checkbox-3"
        value="true"
        unchecked-value="false">
        Wednesday
      </b-form-checkbox>
      <b-form-checkbox
        id="checkbox-4"
        v-model="form.days.thursday"
        name="checkbox-4"
        value="true"
        unchecked-value="false">
        Thursday
      </b-form-checkbox>
      <b-form-checkbox
        id="checkbox-5"
        v-model="form.days.friday"
        name="checkbox-5"
        value="true"
        unchecked-value="false">
        Friday
      </b-form-checkbox>
      <b-form-checkbox
        id="checkbox-6"
        v-model="form.days.saturday"
        name="checkbox-6"
        value="true"
        unchecked-value="false">
        Saturday
      </b-form-checkbox>
      <b-form-checkbox
        id="checkbox-7"
        v-model="form.days.sunday"
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
        form: {
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
    created() {
      const getters = this.$store.getters;
      
      this.$store.watch(() => getters.course.course, async (newCourse) => {
        this.reset(newCourse);
      });
    },
    methods: {
      reset(course) {
        const hasDay = (days, day) => days.includes(day) ? 'true' : 'false';
        const days = course.days;
        
        this.form.name = course.name;
        this.form.startTime = course.startTime;
        this.form.durationMin = TimeParser.fromTimeStrToMinutes(course.startTime, course.endTime);
        this.form.link = course.link;
        this.form.days.monday = hasDay(days, 1);
        this.form.days.tuesday = hasDay(days, 2);
        this.form.days.wednesday = hasDay(days, 3);
        this.form.days.thursday = hasDay(days, 4);
        this.form.days.friday = hasDay(days, 5);
        this.form.days.saturday = hasDay(days, 6);
        this.form.days.sunday = hasDay(days, 7);
      },
      getDays() {
        const days = [];
        let i = 1;
        
        for (const [key] of Object.entries(this.form.days)) {
          if (this.form.days[key] === 'true') {
            days.push(i);
          }
          i++;
        }
        return days;
      },
      onSubmit(e) {
        e.preventDefault();
        const startTime = TimeParser.fromString(this.form.startTime);
        const durationTime = TimeParser.createTime(0, this.form.durationMin);
        const endTime = TimeParser.sum(startTime, durationTime).toString();
        const data = {
          name: this.form.name,
          startTime: this.form.startTime,
          endTime: endTime,
          link: this.form.link,
          days: this.getDays()
        };
        this.$emit('onUpdateCourse', data);
      },
      onReset(e) {
        e.preventDefault();
        const course = this.$store.getters.course.course;
        this.reset(course);
      }
    }
  };
</script>

<style scoped>
  form {
    padding: 48px;
  }
  
  form > p {
    text-align: center;
    font-weight: bold;
  }
  
  form button[type=submit] {
    width: 50%;
  }
  
  form button[type=reset] {
    width: 40%;
    float: right;
  }
  
  .days {
    margin-bottom: 16px;
  }
  
  .days > div {
    display: inline-block;
    width: 128px;
  }
  
  @media (min-width: 1360px) {
    form {
      padding: 64px;
    }
    
    .days {
      margin-bottom: 32px;
    }
  }
</style>

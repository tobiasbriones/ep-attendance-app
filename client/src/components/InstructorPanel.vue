<!--
  -- Copyright (c) 2020 Tobias Briones.
  --
  -- This source code is licensed under the MIT license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<template>
  <div class="component">
    <div class="settings">
      <app-profile-pane class="profile" @onUpdateProfile="onUpdateProfile">
      </app-profile-pane>
      <app-course-setup-pane class="course" @onUpdateCourse="onUpdateCourse">
      </app-course-setup-pane>
    </div>
  </div>
</template>

<script>
  import LoginService from '../user/instructor/services/LoginService';
  import ProfileService from '../user/instructor/services/ProfileService';
  import CourseSetupPane from './instructor/CourseSetupPane';
  import router from '../routes';
  import CourseSetupService from '../user/instructor/services/CourseService';
  import ProfilePane from './instructor/ProfilePane';
  
  export default {
    name: 'InstructorPanel',
    data() {
      return {};
    },
    async created() {
      await this.loadInstructor();
      await this.loadCourse();
    },
    methods: {
      async loadInstructor() {
        try {
          const jwt = await LoginService.loadInstructorJWT();
          const response = await ProfileService.retrieve(jwt);
          const instructorData = response.data['data'];
          
          await this.$store.dispatch('setInstructorData', instructorData);
        }
        catch (err) {
          await router.push('/');
          alert(err);
        }
      },
      async loadCourse() {
        try {
          await this.$store.dispatch('loadCourse');
        }
        catch (err) {
          alert(err);
        }
      },
      async onUpdateProfile(data) {
        try {
          const jwt = await LoginService.loadInstructorJWT();
          
          await ProfileService.update(jwt, data);
          await this.loadInstructor();
          alert('Profile updated successfully');
        }
        catch (err) {
          alert(err);
        }
      },
      async onUpdateCourse(data) {
        try {
          const jwt = await LoginService.loadInstructorJWT();
          
          await CourseSetupService.update(jwt, data);
          await this.loadCourse();
          alert('Course updated successfully');
        }
        catch (err) {
          alert(err);
        }
      }
    },
    components: {
      'app-profile-pane': ProfilePane,
      'app-course-setup-pane': CourseSetupPane
    }
  };
</script>

<style scoped>
  .settings {
    width: 100%;
  }
  
  .settings > form {
    display: block;
    width: 100%;
  }
  
  @media (min-width: 600px) {
    .settings {
      display: flex;
    }
    
    .settings > form {
      width: 60%;
      justify-self: center;
    }
  }
  
  @media (min-width: 960px) {
    .component {
      padding: 0 128px;
    }
  }
  
  @media (min-width: 1360px) {
    .component {
      padding: 0 20%;
    }
  }
  
  @media (min-width: 1920px) {
    .component {
      padding: 0 25%;
    }
  }
</style>

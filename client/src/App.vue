<!--
  -- Copyright (c) 2020 Tobias Briones.
  --
  -- This source code is licensed under the MIT license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<template>
  <div id="app">
    <app-toolbar v-bind:user-logged="userLogged"></app-toolbar>
    <div>
      {{ instructorEmail }}
    </div>
  </div>
</template>

<script>
  import Toolbar from './components/Toolbar';
  
  import AuthService from './instructor/services/AuthService';
  import UserLogin from './services/UserLogin';
  import LoginService from './instructor/services/LoginService';
  
  export default {
    name: 'App',
    data() {
      return {
        userLogged: false,
        instructorEmail: 'A'
      };
    },
    created() {
      this.checkUserLogin();
    },
    methods: {
      async authenticateInstructor(jwt) {
        try {
          const response = await AuthService.authenticate(jwt);
          const responseData = response.data;
          const instructor = responseData['instructor'];
          
          this.userLogged = true;
          this.instructorEmail = instructor['email'];
        }
        catch (err) {
          alert(err.response.data.message);
        }
      },
      
      checkUserLogin() {
        const userType = UserLogin.getUserType();
        const instructor = () => {
          const jwt = LoginService.loadInstructorJWT();
          this.authenticateInstructor(jwt);
        };
        const student = () => {
        
        };
        
        if (!userType) return;
        switch (userType) {
          case 'instructor':
            instructor();
            break;
          
          case 'student':
            student();
            break;
        }
      }
    },
    components: {
      'app-toolbar': Toolbar
    }
  };
</script>

<style>
  * {
    position: relative;
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Roboto', sans-serif;
    color: rgba(0, 0, 0, 0.89);
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }
  
  #app {
    min-width: 360px;
  }
</style>

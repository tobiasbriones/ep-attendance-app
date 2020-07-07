<!--
  -- Copyright (c) 2020 Tobias Briones.
  --
  -- This source code is licensed under the MIT license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<template>
  <div>
    <b-modal id="modal-login" title="Access to the app" hide-footer>
      <div id="loginOptionsPane">
        <button v-on:click="onInstructorLogin">
          INSTRUCTOR
        </button>
        <button v-on:click="onStudentLogin">
          STUDENT
        </button>
      </div>
      
      <b-form @submit="onSubmit" @reset="onReset" v-if="showInstructorForm">
        <p class="form-title">{{ instructorLoginTitle }}</p>
        <b-form-group id="input-group-1"
                      label="Email address:"
                      label-for="input-1">
          <b-form-input id="input-1"
                        v-model="form.email"
                        type="email"
                        required
                        placeholder="Enter email">
          </b-form-input>
        </b-form-group>
        
        <b-form-group id="input-group-2"
                      label="Password:"
                      label-for="input-2">
          <b-form-input id="input-2"
                        type="password"
                        v-model="form.password"
                        required
                        placeholder="Enter password">
          </b-form-input>
        </b-form-group>
        
        <b-button type="submit" variant="primary" class="loginBtn">Login</b-button>
        <b-button type="reset" variant="danger" class="resetBtn">Reset</b-button>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
  import AuthService from '../instructor/services/AuthService';
  import LoginService from '../instructor/services/LoginService';
  
  export default {
    data() {
      return {
        showInstructorForm: false,
        showStudentForm: false,
        instructorLoginTitle: 'Instructor login',
        form: {
          email: 'tobiasbriones.dev@gmail.com',
          password: 'password'
        }
      };
    },
    methods: {
      onInstructorLogin() {
        this.showInstructorForm = true;
        this.showStudentForm = false;
      },
      onStudentLogin() {
        this.showInstructorForm = false;
        this.showStudentForm = true;
      },
      async onSubmit(e) {
        e.preventDefault();
        const formData = new FormData();
        
        formData.set('email', this.form.email);
        formData.set('password', this.form.password);
        try {
          const response = await AuthService.login(formData);
          const responseData = response.data;
          const jwt = responseData['jwt'];
  
          LoginService.saveInstructorLogin(jwt);
          this.$root.$emit('bv::hide::modal', 'modal-login');
          this.$emit('onSuccessfullyLogged');
        }
        catch (err) {
          alert(err.response.data.message);
        }
      },
      onReset(e) {
        e.preventDefault();
        this.form.email = '';
        this.form.password = '';
      }
    }
  };
</script>

<style scoped>
  #loginOptionsPane {
    display: flex;
    width: 100%;
    height: 96px;
    margin: 0 0 32px 0;
    justify-content: space-between;
  }
  
  #loginOptionsPane > button {
    width: 48%;
    height: 100%;
    border: none;
  }
  
  .form-title {
    font-size: 18px;
    font-weight: bold;
  }
  
  .loginBtn {
    width: 60%;
  }
  
  .resetBtn {
    width: 30%;
    float: right;
  }
</style>

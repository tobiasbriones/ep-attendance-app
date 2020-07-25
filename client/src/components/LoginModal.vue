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
      
      <b-form @submit="onInstructorSubmit"
              @reset="onInstructorReset"
              v-if="showInstructorForm">
        <p class="form-title">{{ instructorLoginTitle }}</p>
        <b-form-group id="input-group-1"
                      label="Email address:"
                      label-for="input-1">
          <b-form-input id="input-1"
                        v-model="form.instructor.email"
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
                        v-model="form.instructor.password"
                        required
                        placeholder="Enter password">
          </b-form-input>
        </b-form-group>
        
        <b-button type="submit" variant="primary" class="loginBtn">Login</b-button>
        <b-button type="reset" variant="danger" class="resetBtn">Reset</b-button>
      </b-form>
      
      <b-form @submit="onStudentSubmit" @reset="onStudentReset" v-if="showStudentForm">
        <p class="form-title">{{ studentLoginTitle }}</p>
        <b-form-group id="input-group-3"
                      label="Email address:"
                      label-for="input-3">
          <b-form-input id="input-1"
                        v-model="form.student.email"
                        type="email"
                        required
                        placeholder="Enter email">
          </b-form-input>
        </b-form-group>
        
        <b-form-group id="input-group-4"
                      label="Password:"
                      label-for="input-4">
          <b-form-input id="input-2"
                        type="password"
                        v-model="form.student.password"
                        required
                        placeholder="Enter password">
          </b-form-input>
        </b-form-group>
        
        <div class="register">
          <router-link to="/student/register"
                       @click.native="onSignInClick">
            {{ registerMsg }}
          </router-link>
        </div>
        <b-button type="submit" variant="primary" class="loginBtn">Login</b-button>
        <b-button type="reset" variant="danger" class="resetBtn">Reset</b-button>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
  import AuthService from '../user/instructor/services/AuthService';
  import LoginService from '../user/instructor/services/LoginService';
  
  export default {
    data() {
      return {
        showInstructorForm: false,
        showStudentForm: false,
        instructorLoginTitle: 'Instructor login',
        studentLoginTitle: 'Student login',
        registerMsg: `Don't have an account? Sign In`,
        form: {
          instructor: {
            email: 'tobiasbriones.dev@gmail.com',
            password: 'password'
          },
          student: {
            email: 'tobiasbriones.dev@gmail.com',
            password: 'password'
          }
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
      async onInstructorSubmit(e) {
        e.preventDefault();
        const formData = new FormData();
        
        formData.set('email', this.form.instructor.email);
        formData.set('password', this.form.instructor.password);
        try {
          const response = await AuthService.login(formData);
          const responseData = response.data;
          const jwt = responseData['jwt'];
          
          LoginService.saveInstructorLogin(jwt);
          this.$root.$emit('bv::hide::modal', 'modal-login');
          this.$emit('onSuccessfullyLogged');
        }
        catch (err) {
          const msg = err.response ? err.response.data.message : err;
          
          alert(msg);
        }
      },
      onInstructorReset(e) {
        e.preventDefault();
        this.form.instructor.email = '';
        this.form.instructor.password = '';
      },
      async onStudentSubmit(e) {
        e.preventDefault();
        const formData = new FormData();
        
        formData.set('email', this.form.student.email);
        formData.set('password', this.form.student.password);
        try {
          await this.$store.dispatch('login', {
            email: this.form.student.email,
            password: this.form.student.password,
          });
          
          this.$emit('onSuccessfullyLogged');
        }
        catch (err) {
          alert(err);
        }
      },
      onStudentReset(e) {
        e.preventDefault();
        this.form.student.email = '';
        this.form.student.password = '';
      },
      onSignInClick() {
        this.$root.$emit('bv::hide::modal', 'modal-login');
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
  
  .register {
    margin-bottom: 16px;
  }
</style>

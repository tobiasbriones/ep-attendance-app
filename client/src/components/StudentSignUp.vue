<!--
  -- Copyright (c) 2020 Tobias Briones.
  --
  -- This source code is licensed under the MIT license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<template>
  <div>
    <div class="form-parent">
      <p class="title">
        {{ userRegisterTitle }}
      </p>
      <b-form @submit="onSubmit" @reset="onReset">
        <b-form-group id="input-group-name"
                      label="Name:"
                      label-for="input-name">
          <b-form-input id="input-1"
                        type="text"
                        v-model="name"
                        required
                        placeholder="Enter name">
          </b-form-input>
        </b-form-group>
        <b-form-group id="input-group-email"
                      label="Email:"
                      label-for="input-email">
          <b-form-input id="input-email"
                        type="email"
                        v-model="email"
                        required
                        placeholder="Enter email">
          </b-form-input>
        </b-form-group>
        <b-form-group id="input-group-pwd"
                      label="Password:"
                      label-for="input-pwd">
          <b-form-input id="input-pwd"
                        type="password"
                        v-model="password"
                        required
                        placeholder="Enter password">
          </b-form-input>
        </b-form-group>
        <b-form-group id="input-group-confirm-pwd"
                      label="Confirm Password:"
                      label-for="input-confirm-pwd">
          <b-form-input id="input-confirm-pwd"
                        type="password"
                        v-model="confirmPassword"
                        required
                        placeholder="Enter password">
          </b-form-input>
        </b-form-group>
        
        <b-button type="submit" variant="primary" class="loginBtn">Sign Up</b-button>
        <b-button type="reset" variant="danger" class="resetBtn">Reset</b-button>
      </b-form>
    </div>
  </div>
</template>

<script>
  
  export default {
    name: 'StudentSignUp',
    data() {
      return {
        name: 'a',
        email: 'a@gamicl.com',
        password: 'aaaaaa',
        confirmPassword: 'aaaaaa',
        userRegisterTitle: 'User registration'
      };
    },
    methods: {
      async onSubmit(e) {
        e.preventDefault();
        if (this.password !== this.confirmPassword) {
          alert(`Your passwords don't match`);
          return;
        }
        
        try {
          await this.$store.dispatch('signUp', {
            email: this.email,
            password: this.password,
            name: this.name
          });
          const msg = `
            Student registered successfully
          `;
          
          alert(msg);
        }
        catch (err) {
          alert(err);
        }
      },
      onReset(e) {
        e.preventDefault();
        this.name = '';
        this.email = '';
        this.password = '';
        this.confirmPassword = '';
      }
    }
  };
</script>

<style scoped>
  .form-parent {
    width: 90%;
    margin: 32px auto;
  }
  
  .form-parent > .title {
    font-size: 18px;
    font-weight: bold;
    text-align: center;
  }
  
  .loginBtn {
    width: 60%;
  }
  
  .resetBtn {
    width: 30%;
    float: right;
  }
  
  @media (min-width: 600px) {
    .form-parent {
      width: 60%;
      margin: 64px auto;
    }
  }
  
  @media (min-width: 1360px) {
    .form-parent {
      width: 15%;
    }
  }
</style>
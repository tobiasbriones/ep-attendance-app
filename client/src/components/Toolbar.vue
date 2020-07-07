<!--
  -- Copyright (c) 2020 Tobias Briones.
  --
  -- This source code is licensed under the MIT license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<template>
  <header>
    <nav>
      <div>
        <h1>Attendance App</h1>
        <div class="actions">
          <ul>
            <li v-on:click="onAccessActionClick" v-if="!userLogged">
              <span>
                {{ access }}
              </span>
            </li>
            <li v-on:click="onLogoutActionClick" v-if="userLogged">
              <span>
                {{ logout }}
              </span>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <app-login-modal></app-login-modal>
    <b-button ref="loginModalButton" class="gone" v-b-modal.modal-1></b-button>
  </header>
</template>

<script>
  
  import LoginModal from './LoginModal';
  
  export default {
    name: 'Toolbar',
    props: {
      userLogged: Boolean,
    },
    data: function() {
      return {
        access: 'Access',
        logout: 'Logout'
      };
    },
    methods: {
      onAccessActionClick: function() {
        this.$refs.loginModalButton.click();
      },
      onLogoutActionClick: function() {
        // TODO
      }
    },
    components: {
      'app-login-modal': LoginModal
    }
  };
</script>

<style scoped>
  ul {
    list-style: none;
  }
  
  nav {
    height: 96px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.2);
    background-color: #FBC02D;
  }
  
  nav > div {
    height: 100%;
    padding: 16px 32px;
  }
  
  nav > div > .actions {
    display: inline-block;
    height: 100%;
    float: right;
  }
  
  nav > div > .actions > ul,
  nav > div > .actions > ul > li {
    height: 100%;
  }
  
  nav > div > .actions > ul > li {
    display: flex;
    align-content: center;
    justify-content: center;
  }
  
  nav > div > .actions > ul > li > span {
    display: block;
    min-width: 76px;
    height: 80%;
    padding: 12px;
    align-self: center;
    text-align: center;
    font-size: 16px;
    border-radius: 32px;
    border: 1px solid #F57F17;
    background-color: #66BB6A;
    transition: background-color 200ms;
    cursor: pointer;
  }
  
  nav > div > .actions > ul > li > span:active {
    background-color: #4CAF50;
  }
  
  h1 {
    display: inline-block;
    font-size: 24px;
    font-weight: bold;
    top: 16px;
  }
  
  .gone {
    display: none !important;
  }
  
  @media (min-width: 960px) {
    h1 {
      display: inline-block;
      font-weight: bold;
      font-size: 32px;
    }
    
    nav > div > .actions > ul > li > span {
      min-width: 108px;
      font-size: 18px;
    }
  }
</style>

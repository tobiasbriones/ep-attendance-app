<!--
  -- Copyright (c) 2020 Tobias Briones.
  --
  -- This source code is licensed under the MIT license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<template>
  <div id="app">
    <app-toolbar></app-toolbar>
  </div>
</template>

<script>
  import Toolbar from './components/Toolbar';
  
  export default {
    name: 'App',
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

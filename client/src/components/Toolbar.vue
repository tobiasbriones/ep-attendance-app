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
      </div>
    </nav>
  </header>
</template>

<script>
  export default {
    name: 'Toolbar',
    props: {
      msg: String
    }
  };
</script>

<style scoped>
  nav {
    height: 128px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.2);
    background-color: #FBC02D;
  }
  
  nav > div {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  nav h1 {
    align-self: center;
  }
  
  h1 {
    top: 48px;
  }
</style>

<!--
  -- Copyright (c) 2020 Tobias Briones.
  --
  -- This source code is licensed under the MIT license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<template>
  <div>
    Home {{ user }}
  </div>
</template>

<script>
  export default {
    name: 'Home',
    data(){
      return {
        user: ''
      }
    },
    created() {
      if(this.$store.studentProfile) {
        this.user = this.$store.studentProfile.name;
      }
    }
  };
</script>

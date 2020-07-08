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
  import LoginService from '../user/instructor/services/LoginService';
  import ProfileService from '../user/instructor/services/ProfileService';
  import router from '../routes';
  
  export default {
    name: 'InstructorPanel',
    data() {
      return {
        user: ''
      };
    },
    async created() {
      try {
        const jwt = await LoginService.loadInstructorJWT();
        const response = await ProfileService.retrieve(jwt);
        const instructorData = response.data['data'];
        
        await this.$store.dispatch('setInstructorData', instructorData);
      }
      catch (err) {
        await router.push('/')
        alert(err);
      }
      
    }
    
  };
</script>

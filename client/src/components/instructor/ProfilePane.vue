<!--
  -- Copyright (c) 2020 Tobias Briones.
  --
  -- This source code is licensed under the MIT license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<template>
    <b-form @submit="onSubmit" @reset="onReset">
      <p>Instructor profile</p>
      <b-form-group
        id="input-group-name"
        label="Name:"
        label-for="input-name"
        description="Instructor name">
        <b-form-input
          id="input-name"
          v-model="form.name"
          type="text"
          required
          placeholder="Enter your name">
        </b-form-input>
      </b-form-group>
      
      <b-button type="submit" variant="primary">Submit</b-button>
      <b-button type="reset" variant="danger">Reset</b-button>
    </b-form>
</template>

<script>
  
  export default {
    name: 'CourseSetupPane',
    data: function() {
      return {
        name: '',
        form: {
          name: ''
        }
      };
    },
    created() {
      const getters = this.$store.getters;
      
      this.$store.watch(() => getters.instructorData.name, async (newName) => {
        this.form.name = newName;
      });
    },
    methods: {
      onSubmit(e) {
        e.preventDefault();
        this.$emit('onUpdateProfile', this.form);
      },
      onReset(e) {
        e.preventDefault();
        this.form.name = this.$store.getters.instructorData.name;
      }
    }
  };
</script>

<style scoped>
  form {
    padding: 48px;
  }

  form > p {
    text-align: center;
    font-weight: bold;
  }

  form button[type=submit] {
    width: 50%;
  }

  form button[type=reset] {
    width: 40%;
    float: right;
  }
</style>

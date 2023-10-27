<!-- assets/LoginForm.vue -->

<template>
  <div class="login-container">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <input v-model="username" type="text" placeholder="Username" required >
      <input v-model="password" type="password" placeholder="Password" required >
      <button type="submit">Login</button>
      <button type="button" @click="register">Registrarse</button>
    </form>
    <div v-if="feedback" class="feedback">{{ feedback }}</div>
    <div v-if="error" class="error">{{ error }}</div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      username: '',
      password: '',
      feedback: null,
      error: null
    }
  },
  methods: {
    login() {
      const formData = {
        username: this.username,
        password: this.password,
      };

      axios.post('/login', formData)
        .then(response => {
          console.log(response.data);
          window.location.href = response.data.redirect_url;
        })
        .catch(error => {
          this.error = error.response.data.error;
          this.feedback = null;
        });
    },

    register() {
      const formData = {
        username: this.username,
        password: this.password,
      };

      axios.post('/register', formData)
        .then(response => {
          this.feedback = response.data.message;
          this.error = null;
        })
        .catch(error => {
          console.log("fallo");
          this.error = error.response.data.message;
          this.feedback = null;
        });
    }
  }
}
</script>
<template>
  <b-container>
    <b-row>
      <b-col cols="1"></b-col>
      <b-col cols="10">
        <div class="card text-white mt-4" style="background:#cd181d;">
          <div class="card-header">Automaticket - Teste</div>
          <div class="card-body">
            <b-form @submit="onSubmit">
              <b-form-group>
                <b-form-input type="email" v-model="email" required placeholder="E-mail"></b-form-input>
              </b-form-group>
              <b-form-group>
                <b-form-input type="password" v-model="password" required placeholder="Senha"></b-form-input>
              </b-form-group>
              <b-button type="submit" style="background:#960004; border:none;">Entrar</b-button>
            </b-form>
          </div>
        </div>
      </b-col>
      <b-col cols="1"></b-col>
    </b-row>
  </b-container>
</template>

<script>

import { http } from '../services/config'

export default {
  data () {
    return { email: '', password: '' }
  },
  created: function() {
    // Verifica se existe o item token no localStorage.
    if (localStorage.getItem('token')) this.$router.push('users')
  },
  methods: {
    onSubmit (event) {
      // Não permite o envio do formulário.
      event.preventDefault();
      // Requisição ao webservice.
      http.post('/login', { email: this.email, password: this.password })
      .then(response => {
        var token = 'Bearer '+response.data.token
        localStorage.setItem('token', token)
        // Definindo o token no headers do axios.
        http.defaults.headers.common['Authorization'] = token
        // Redirecionado para a home.
        this.$router.push('users')
      })
      .catch(error => {
        console.log('erro:' . response.data.mensagem)
      })
    }
  }
}

</script>

<style scoped>
  input, button { font-family:'Roboto', sans-serif; }
</style>

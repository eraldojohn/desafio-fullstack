<template>
  <div class="container-fluid bg-light">
    <div class="row title-card">
      <div class="col-10 text-left text-dark"><h4>Cadastro de Usuários</h4></div>
    </div>
    <div class="row">
      <div class="col-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3 offset-xl-3 text-right">
        <b-btn v-b-modal.newUser variant="success">Novo Usuário</b-btn>
      </div>
    </div>
    <div class="row pt-2">
      <div class="col-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3 offset-xl-3 text-left">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col" colspan="2">Nome</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user of users" :key="user.id">
              <td class="align-middle">{{ user.name }}</td>
              <td class="text-right">
                <div class="btn-toolbar float-right" role="toolbar">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary" @click="setUser(user)" v-b-modal.newUser>
                        Editar
                    </button>
                    <button type="button" class="btn btn-danger" @click="deleteUser(user)">
                        Apagar
                    </button>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3 offset-xl-3 text-right">
        <div class="btn-group" role="group">
          <button type="button" class="btn btn-outline-secondary" @click="previousPage()">
              <<
          </button>
          <button type="button" class="btn btn-outline-secondary" @click="nextPage()">
              >>
          </button>
        </div>
      </div>
    </div>

    <b-modal id="newUser" ref="modalNew" title="Novo Usuário" @ok="saveUser" @hidden="clearData">
      <form>
        <div class="form-group">
          <label for="nameUser">Nome</label>
          <input type="text" class="form-control" id="nameUser" v-model="novoUsuario.name" required>
        </div>
        <div class="form-row">
          <div class="form-group col-10">
            <label for="addresslUser">Endereço</label>
            <input type="text" class="form-control" id="addressUser" v-model="novoUsuario.address" required>
          </div>
          <div class="form-group col-2">
            <label for="numberUser">Numero</label>
            <input type="number" class="form-control" id="numberUser" v-model="novoUsuario.number" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-8">
            <label for="citylUser">Cidade</label>
            <input type="text" class="form-control" id="cityUser" v-model="novoUsuario.city" required>
          </div>
          <div class="form-group col-4">
            <label for="zipCodeUser">CEP</label>
            <input type="number" class="form-control" id="zipCodeUser" v-model="novoUsuario.zipCode" v-on:keyup="getCep" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-6">
            <label for="emailUser">E-mail</label>
            <input type="email" class="form-control" id="emailUser" v-model="novoUsuario.email" required>
          </div>
          <div class="form-group col-6">
            <label for="passUser">Senha</label>
            <input type="password" class="form-control" id="passUser" v-model="novoUsuario.pass" required>
          </div>
        </div>
      </form>
    </b-modal>

  </div>
</template>

<script>

import { http } from '../services/config'

export default {
  data () {
    return {
      next_page: 2,
      prev_page: 1,
      last_page: null,
      novoUsuario: {id: null, name: null, address: null, number: null, city: null, zipCode: null, email: null, pass: null },
      users: [],
    }
  },
  mounted () {
    http.get('/users').then(response => { this.users = response.data.data })
  },
  methods: {
    saveUser (evt) {
      var id = this.novoUsuario.id;
      var jSON = {
          name: this.novoUsuario.name,
          email: this.novoUsuario.email,
          password: this.novoUsuario.pass,
          address: this.novoUsuario.address,
          number: this.novoUsuario.number,
          city: this.novoUsuario.city,
          zip_code: this.novoUsuario.zipCode
        }

        if(id){
          http.put('/users/update/' + id, jSON).then(response => {
            this.reload(this.current_page)
            this.notification(response.data.mensagem)
          })
          .catch((error) => { console.log(error.data.mensagem) })
        } else{
          http.post('/users/save', jSON).then(response => {
            this.reload(this.current_page)
            this.notification(response.data.mensagem)
          })
          .catch((error) => { console.log(error.data.mensagem) })
        }
    },
    deleteUser (evt) {
        this.$swal({
          title: 'Apagar Registro?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'SIM',
          cancelButtonText: 'NÃO',
          showCloseButton: true,
          showLoaderOnConfirm: true
        }).then((result) => {
          if(result.value) {
            var id = evt.id;
            http.delete('/users/delete/' + id).then(response => { this.reload(response) })
            .catch((error) => { console.log(error) })
          }
        })
    },
    setUser (user) {
      this.novoUsuario.id     = user.id
      this.novoUsuario.name   = user.name
      this.novoUsuario.email  = user.email
      this.novoUsuario.address= user.address
      this.novoUsuario.number = user.number
      this.novoUsuario.city   = user.city
      this.novoUsuario.zipCode= user.zip_code
    },
    clearData (evt) {
      this.novoUsuario.id     = null
      this.novoUsuario.name   = null
      this.novoUsuario.email  = null
      this.novoUsuario.pass   = null
      this.novoUsuario.address= null
      this.novoUsuario.number = null
      this.novoUsuario.city   = null
      this.novoUsuario.zipCode= null
    },
    reload (p) {
      var option = "?page="+p

      http.get('/users' + option).then(response => {
        this.users = response.data.data,
        this.current_page = response.data.current_page,
        this.next_page = response.data.current_page+1,
        this.prev_page = response.data.current_page-1,
        this.last_page = response.data.last_page
      })
    },
    previousPage () {
      if(this.prev_page != 0)
        this.reload(this.prev_page)
    },
    nextPage () {
      if(this.last_page+1 != this.next_page)
        this.reload(this.next_page)
    },
    notification (msg) {
      this.$swal(msg, '', 'OK');
    },
    getCep () {
      if(this.novoUsuario.zipCode != null){
        if(this.novoUsuario.zipCode.length == 8){
          var cep = this.novoUsuario.zipCode
          this.$viaCep.buscarCep(cep).then((obj) => {
            this.novoUsuario.address= obj.logradouro
            this.novoUsuario.city   = obj.localidade
          })
        }
      }
    }

  }

}
</script>

<style scoped>
.container-fluid { min-height:100vh; }
.container-fluid .title-card { padding:20px 0; }
.container-fluid .title-card h4 { font-size:1.5em; line-height:40px; }
</style>

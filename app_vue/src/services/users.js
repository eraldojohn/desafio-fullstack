import { http } from './config'

export default {

  login:() => {
    http.post('/login', { email: this.email, password: this.password })
     .then(response => {
       // Armazenando o token no localStorage.
       localStorage.setItem('token', response.data.token)
       // Definindo o token no headers do axios.
       http.defaults.headers.common['Authorization'] = response.data.token
       // Redirecionado para a home.
       this.$router.push('users')
     })
     .catch(error => {
       console.log("erro")
     })
  }


}

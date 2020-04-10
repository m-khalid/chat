<template>
    <div class="container d-flex justify-content-center ">
      <div class="row h-100">
      <div class="col  align-self-center">
        <div class="row justify-content-center"><h1>login</h1></div>
        <div class="row justify-content-center" id="form-contatiner">
            <form  v-on:submit.prevent="login()">
              <div class="row">
                <input type="text" class="inputfield"  id="userNameInput" placeholder="E-mail or User name" v-model="username" value="">
              </div>
              <div class="row">
                <input type="password" class="inputfield"  id="passwordInput" placeholder="Password" v-model="password" value="">
              </div>
              <div class="row justify-content-center">
                <input id="submitbtn" type="submit"  value="Enter">
              </div>
            </form>
          </div>
          <div class="row justify-content-center"> <router-link to='/register'>don't have an account?</router-link> </div>
        </div>
      </div>
  </div>
</template>

<script>
export default{
    data: ()=>({
      username: '',
      password: ''
    }),
    methods: {
        login() {
            console.log('i have been clicked');
            this.$store.dispatch('login', {
                useraccount: this.username,
                password: this.password
            }).then(()=>{
              this.$router.replace('/');
            }).catch(()=>{
               alert('wrong username or password');
            })
        }
    }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
#form-contatiner{
border: solid 2px;
border-radius: 7px;
width: 520px;
}
.inputfield{
  padding: 10px;
  border-radius: 7px;
  margin: 10px;
}

#submitbtn{
  background-color: #4160F5;
  padding: 5px;
  border-radius: 7px;
  width: 100px;
  margin-top: 30px;
  margin-bottom: 50px;
}

.contaitner{
  margin-top: auto;
  margin-bottom: auto;
}
</style>

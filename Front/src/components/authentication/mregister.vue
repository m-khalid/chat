<template>
    <div class="container d-flex justify-content-center ">
      <div class="row h-100">
      <div class="col  align-self-center">
        <div class="row justify-content-center"><h1>Register</h1></div>
        <div class="row justify-content-center" id="form-contatiner">
            <form  v-on:submit.prevent="Register()">
              <div class="row">
                <input type="text" class="inputfield"  id="userNameInput" placeholder="User name" v-model="username" value="">
              </div>
              <div class="row">
                <input type="text" class="inputfield"  id="emailInput" placeholder="E-mail" v-model="Email" value="">
              </div>
              <div class="row">
                <input type="password" class="inputfield"  id="passwordInput" placeholder="Password" v-model="password" value="">
              </div>
              <div class="row">
                <input type="password" class="inputfield"  id="userNameInput" placeholder="Password Confirmation" v-model="password_confirmation" value="">
              </div>
              <div class="row">
                <input type="text" class="inputfield"  id="userNameInput" placeholder="Age" v-model="age" value="">
              </div>
               <div class="row">
                <input type="text" class="inputfield"  id="userNameInput" placeholder="Bio" v-model="bio" value="">
              </div>             
              <div class="row justify-content-center">
                <input id="submitbtn" type="submit"  value="Enter">
              </div>
            </form>
          </div>
          <div class="row justify-content-center"> <router-link to='/login'>already have an account?</router-link> </div>
        </div>
      </div>
  </div>
</template>

<script>
export default{
    data: ()=>({
      username: '',
      Email: '',
      password: '',
      password_confirmation: '',
      age: '',
      bio: ''
    }),
    methods: {
      
      VconfirmPassword: function(){ // validate tha password === confirm passorwd
              if(this.password === this.password_confirmation){
                return true;
              }else{
                throw 'confirm password must match password';
              }
        },
        validateAll: function() { //validate all fields
            //return new Promise.resolve(VconfirmPassword()).catch((error)=>{
             // alert(error);
           // })
        },

        Register: function() {
            console.log('i have been clicked');
            //new Promise.resolve(validateAll())
             this.$store.dispatch('register', {
                 username: this.username,
                 email: this.Email,
                 password: this.password,
                 password_confirmation: this.password_confirmation,
                 age: this.age,
                 bio: this.bio 
             }).then(()=>{
               console.log('he5aaaaaaaa 43al');
             }).catch((error)=>{
               console.log('la2 yabaaa: '+error);
           })
        },
        Vpassword: function(){
          if(this.$validator.isByteLength(this.password , 8,999)){
            return true
          }
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

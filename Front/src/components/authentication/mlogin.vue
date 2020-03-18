<template>
    <div class="container d-flex justify-content-center ">
      <div class="row h-100">
      <div class="col  align-self-center">
        <div class="row justify-content-center"><h1>login</h1></div>
        <div class="row justify-content-center" id="form-contatiner">
            <form class="" action="index.html" method="post">
              <div class="row">
                <input type="text" class="inputfield"  id="userNameInput" placeholder="E-mail or User name" value="">
              </div>
              <div class="row">
                <input type="password" class="inputfield"  id="passwordInput" placeholder="Password" name="" value="">
              </div>
              <div class="row justify-content-center">
                <input id="submitbtn" type="submit" name="" value="Enter">
              </div>
            </form>
          </div>
          <div class="row justify-content-center"> <a href="#">don't have an account?</a> </div>
        </div>
      </div>
  </div>
</template>

<script>

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

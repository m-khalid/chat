<template>
    <div class="container d-flex justify-content-center">
      <div class="col align-self-center">
        <!-- image goes here-->
        <div class="card" style="width: 18rem;">
          <img src="" class="card-img-top" alt="profile image">
          <div class="card-body">
            <h5 class="card-title">profile image</h5>
            <button class="btn btn-primary">change imgage</button>
          </div>
        </div>
      </div>
      <div class="col-9">
          <form class="form_container ">
            <div class="row justify-content-center">
                <h1>Setting</h1>
            </div>
            <div class="row justify-content-center">
                <input type="text" placeholder="User Name" value="">
            </div>
            <div class="row justify-content-center">
              <input type="text" placeholder="E-mail" value="">
            </div>
            <div class="row justify-content-center">
              <input type="text" placeholder="age" value="">
            </div>
            <div class="row justify-content-center">
              <textarea placeholder="Bio" id='bio_input' rows="6" cols="30"></textarea>
            </div>
            <div class="row justify-content-center">
              <button class="btn btn-primary" >change password</button>
            </div>
            <div class="row">
              <div class="col">
                <button class="btn btn-danger" >cancel</button>
              </div>
              <div class="col-5">
                <button class="btn btn-primary" >confirm changes</button>
              </div>
            </div>
          </form>
      </div>
    </div>
    </template>

<script></script>

<style scoped>
  .btn{
  margin: 10px;
}

input{
  padding: 10px;
  margin: 10px;
  border-radius: 7px;
}

.form_container{
  border:solid 3px;
  border-radius: 5px;
  padding: 10px;
  width: 500px;
}

#bio_input{
  padding: 10px;
  margin: 10px;
  overflow: auto;
  border-radius: 7px;
}

</style>

<template>
    <div class="container d-flex justify-content-center">
      <div class="col align-self-center">
        <!-- image goes here-->
        <div class="card" style="width: 18rem;">
          <img v-bind{{selectedProfileImage}} class="card-img-top" alt="profile image">
          <div class="card-body">
            <h5 class="card-title">change profile image</h5>
            <input type="file" @change="onImageSelected">
            <button class="btn btn-primary" @click="onImgUploadClick">Upload</button>
          </div>
        </div>
      </div>
      <div class="col-9">
          <form class="form_container " v-on:submit.prevent="confirmChanges()">
            <div class="row justify-content-center">
                <h1>Setting</h1>
            </div>
            <div class="row justify-content-center">
                <input type="text" placeholder="User Name" v-model="user_name"  value="">
            </div>
            <div class="row justify-content-center">
              <input type="text" placeholder="E-mail" v-model="Email" value="">
            </div>
            <div class="row justify-content-center">
              <input type="text" placeholder="age" v-model="age" value="">
            </div>
            <div class="row justify-content-center">
              <textarea placeholder="Bio" id='bio_input' v-model="bio" rows="6" cols="30"></textarea>
            </div>
            <div class="row justify-content-center">
              <button class="btn btn-primary" >change password</button>
            </div>
            <div class="row">
              <div class="col">
                <button class="btn btn-danger" >cancel</button>
              </div>
              <div class="col-5">
                <input class="btn btn-primary" type="submit" value="confirm changes">
              </div>
            </div>
          </form>
      </div>
    </div>
    </template>

<script>
  export default{
    data: ()=>({
      selectedProfileImage: null,
      user_name: '',   
      Email: '',
      age: null,
      bio: ''
    }),
    methods: {
        onImageSelected(event){
          this.selectedProfileImage = event.target.files[0];
        },
        onImgUploadClick(){
          this.$store.dispatch('setImage', {
            img: this.selectedProfileImage
          }).then(()=>{
            console.log("new Image selected");
            
          }).catch(er=>{
            console.log(er)
          })
        },
        confirmChanges(){  
          console.log('confirm changes clicked');
          this.$store.dispatch('editProfile',{
            username: this.user_name,
            email: this.Email,
            age: this.age,
            bio: this.bio
          })

        }

    }
}
</script>
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

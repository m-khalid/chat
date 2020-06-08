<template>
    <div class="container d-flex justify-content-center">
      <div class="col align-self-center">
        <!-- image goes here-->
        <form enctype="multipart/form-data" class="card" style="width: 18rem;">
         <!-- <img v-bind{{selectedProfileImage}} class="card-img-top" alt="profile image">
         -->
          <div class="card-body">
            <h5 class="card-title">change profile image</h5>
            <input type="file" id="selectedProfileImage" v-on:change="onImageSelected" >
            <button class="btn btn-primary" @click="onImgUploadClick">Upload</button>

          </div>
        </form>
      </div>
      <div class="col-9">
          <form class="form_container " v-on:submit.prevent="confirmChanges()">
            <div class="row justify-content-center">
                <h1>Setting</h1>
            </div>
            <div class="row justify-content-center">
                <input type="text" placeholder="User Name" v-model="username" >
            </div>
            <div class="row justify-content-center">
              <input type="text" placeholder="E-mail" v-model="email">
            </div>
            <div class="row justify-content-center">
              <input type="text" placeholder="age" v-model="age" >
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
      username: '',   
      email: '',
      age: null,
      bio: ''
    }),
    methods: {
        onImageSelected(event){
          this.selectedProfileImage = event.target.files[0];
        },
        onImgUploadClick(){
          let formData = new FormData();
          formData.append( 'img',this.selectedProfileImage);

          this.$store.dispatch('setImage', {
           //img: this.selectedProfileImage
            FormData: formData
          
          }).then(()=>{
            console.log("new Image selected");
          }).catch(er=>{
            console.log(er)
          })
        },
        confirmChanges(){  
          console.log('confirm changes clicked');
          console.log(this.username);
          console.log(this.email);
          this.$store.dispatch('editProfile',{
            username: this.username,
            email: this.email,
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

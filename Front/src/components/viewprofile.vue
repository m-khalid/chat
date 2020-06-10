<template>
  <div class="container">
    <input class="btn btn-primary" type="submit" value="view" v-on:click="viewprofile()" >
   <div class="row justify-content-left">
    <ul>
              <li>
               Name: {{responsedata.username}}
                <br>
                Bio: {{responsedata.bio}}
                <br>
                Email: {{responsedata.email}} 
                <br>
                Age: {{responsedata.age}}
                <br><br>
              </li>
            </ul>
   </div>
</div>

</template>

<script>
export default
{
    data: ()=>(
      {
      responsedata: [],
      }),
    methods: {
         async viewprofile(){  
          this.responsedata = await this.$store.dispatch('viewprofile',{
          });
          console.log(this.responsedata);
          },
       
    }
}
</script>

<style></style>

<template>
<div class="container">
    <input class="btn btn-primary" type="submit" value="view" v-on:click="viewfriends()" >
   <div class="row justify-content-left">
    <ul>
              <li v-for="responsedata of responsedata" :key="responsedata.id">
                {{responsedata.username}}
                <br>
                 {{responsedata.bio}}
                <br>
              
  <a href="#" class="btn btn-primary">message</a>
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
         async viewfriends(){  
          this.responsedata = await this.$store.dispatch('viewfriends',{
          });
          console.log(this.responsedata);
          },
       
    }
}
</script>

<style></style>

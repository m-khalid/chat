<template>
 <div class="container">
               <div><input type="text" placeholder="search" v-model="username" >
               <input class="btn btn-primary" type="submit" value="search" v-on:click="search()" >
                </div> 
                <br>
              <div class="row justify-content-left">
                 <ul>
              <li v-for="responsedata of responsedata" :key="responsedata.id">
                {{responsedata.username}}
                <br>
                {{responsedata.bio}}
                <br>
              
                
                <a href="#" class="btn btn-primary">Add friend</a>
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
      username: '',
      responsedata: [],
      
      }),
    methods: {
         async search(){  
          console.log('search clicked');
          console.log(this.username);
          this.responsedata = await this.$store.dispatch('viewresults',{
            username: this.username,
          });
          console.log(this.responsedata);
          },
       
    }
}
</script>

<style >

</style>

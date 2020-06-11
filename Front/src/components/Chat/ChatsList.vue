<template>
    <div id="container" class="container fill justify-content-center">
        <div class="row-12 ">
        <ul class=" col">
            <li class="chatItem col-12" v-for="contact in contacts" :key="contact.id" @click="selectContact(index,contact)" >
                <ChatItem :contact="contact"  />
            </li>
        </ul>
        </div>
    </div>
</template>
<script>
export default {
    data: ()=>({
      selectedContact: null,
      contacts: ["start"]
    }),
    mounted(){
        this.ListChats();
    },
    probs: {
       contacts:{
           type:Array
       }
    },
    methods: {
        selectContact(index,contact){
        console.log("select contact function clicked")
        this.selectedContact = index;
        this.$emit('selected', contact);

        },
        async ListChats(){  
          this.contacts = await this.$store.dispatch('viewfriends',{
          });
          },
    },components: {
        'ChatItem' : require('./ChatItem.vue').default
    }
   
}
</script>
<style scoped>
#container{
    border:solid 3px black;
    margin: 5px;
    border-radius:7px;
    min-height: 650px;
    height: 100%;
    
}

.chatItem{
    list-style: none;
    padding: 10px;
    margin-top: 10px;
}

</style>
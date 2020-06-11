<template>
  
  <div class="container d-flex ">
    <!--   <Conversation :contact="selectedContact" :messages="messages/> -->
    
    <Conversation class="col-9" :contact="contact" :messages="messages"/>
    <ChatsList class="col-3" :contacts="contacts" @selected="startConversation"/>
    
  </div>
</template>
<script>

export default {
    data: ()=>({
        curUser: null,
        contacts: ['start'],
        messages: ['start'],
        selectedContact: null
    }),
    created (){
       this.ListChats();
       this.getCurUser();

        },
      components: {
    'Conversation': require('./Chat/Conversation.vue').default, 
    'ChatsList': require('./Chat/ChatsList.vue').default
  },
   
  methods: {
            async ListChats(){  
        console.log("iam in listchat()");
          this.contacts = await this.$store.dispatch('viewfriends',{
          });
          console.log(this.contacts);
          },
          async startConversation(contact){
            console.log("Iam in start conversation ")
            console.log(contact);
            let to_id =contact.id;
            console.log(to_id);
            this.messages = await this.$store.dispatch('messages',{'to_id':to_id });
            this.messages=this.messages.data.data;
            console.log(this.messages);
          },
          async getCurUser(){
            this.curUser = await this.$store.getters.getUser();
            console.log("the current user is"+this.curUser);
          }

  }

    
}
</script>

<style scoped>
.row{
      min-height: 100%;
    height: 100%;
    width: 100%;
    min-width: 100%;
}
.container{
    min-height:  650px;
}
</style>

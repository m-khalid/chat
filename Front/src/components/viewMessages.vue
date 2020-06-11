<template>
  
  <div class="container d-flex justify-content-center">
      
    <!--   <Conversation :contact="selectedContact" :messages="messages/> -->
    <Conversation class="col-9"/>
    <ChatsList :contacts="contacts" @selected="startConversation"/>
  </div>
</template>
<script>

export default {
    data: ()=>({
        contacts: ['start'],
        messages: ['start'],
        selectedContact: null
    }),
    created (){
       this.ListChats();
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
          async startConversation(){
            this.messages = await this.$store.dispatch()
          }
  }

    
}
</script>

<style></style>

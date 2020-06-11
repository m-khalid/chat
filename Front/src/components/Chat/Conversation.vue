<template>
    <div class="container d-flex justify-content-center" id="container" >
        <div class="col">
        <div class='row-11' id="messagesFeed" >
            <ul>
                <li v-for="message in Umessages" :key="message" >
                    
                   <p>message: {{message.friend}} {{message.me}}</p>
                   <p>time: {{message.time}}</p>
                </li>
            </ul>
        </div>
        <div class="row-1" id="messageInputDiv">
            <input v-on:keyup.enter="sendMessage" id="messageInput" v-bind="textToSend" type="text" placeholder="Enter your message">
            <button @click="refreshfeed"> refresh </button>
        </div>
        </div>
    </div>
</template>
<script>
export default {
        data: ()=>({
        Umessages:this.messages,
        contact:this.contact,
        textToSend:''
    }),
    probs:['messages', 'contact'],
    methods: {
        refreshfeed(){
            this.Umessages = this.messages;
        }, 
        sendMessage(){
            let toSend = this.textToSend;
            let to_id = this.contact.id;
            this.$store.dispatch('sendmsg',{'to_id':to_id, 'toSend':toSend}).catch(er=>{
                console.log(er);
            })
        }
    }
}
</script>
<style scoped>
#container{
    border: solid black 3px;
    color:black;
}
#messagesFeed{
    border: black 1px solid;
    margin-top:5px;
    min-height: 550px;
}
#messageInputDiv{
    border-radius: 7px;
    position: absolute;
     bottom: 2px;
     width: 100%;
     padding: 15px;
}
#messageInput{
     width: 100%;
     padding: 15px;
}
ul{
    list-style: none;
}
</style>
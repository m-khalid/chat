<template>
    <div class="contatiner">
        <h3>{{this.contact.username}}</h3>
        <h3>{{this.contact.bio}}</h3>
    </div>  
</template>
<script>
export default {
    data: ()=>({
        contact:this.contact
    }),
    props: {
        contact:{
            type:Object
        }
    },
    mounted(){
        console.log(this.username);
    }

}
</script>
<style>
.contatiner{
    border:solid 3px black;
    margin: 5px;
    border-radius:7px;
}

</style>
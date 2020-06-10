import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import cUser from './modules/User';
import UI from './modules/UI';

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        token: localStorage.getItem('token')||null

    },
    mutations: {},
    getters: {
        loggedIn(state){
            return state.token != null;
        },
        getToken(state){
            return state.token;
        }
    },
    actions: {
        login: (context, payload) => {

                axios.post('login', payload)
                .then(response=>{
                  if(response.status==200){
                    const token =response.data.data.token;
                      localStorage.setItem('token', token);
                  }
                }).catch( er=>{
                    alert('wrong username or password' + er);
                })
            
        },
        register: (commit , payload)=>{
            return new Promise((resolve, reject)=> {
                axios.post('register', payload)
                .then(response=>{
                    console.log(response);
                    console.log('break!');
                    console.log(response.data.msg);
                  
                     if(response.data.status==200){
                        alert('success!');
                        const token =response.data.data.token;
                        localStorage.setItem('token', token);
                        resolve(response);
                    }else{
                        throw new Error(response.data.msg);
                    }
                }).catch( error=>{
                    alert(error);
                    reject(error);
                })
            })
        },
        logout: () =>{
            localStorage.clear();
        }, 
        setImage: (commit, payload)=>{
            let token =localStorage.getItem('token');
            let formData =payload.formData;
            formData.append('token', token);
            console.log(formData.token);
            console.log(FormData.img);
            axios.post('img',formData, {headers: { 'Content-Type': 'multipart/form-data'
            }} ).then(response =>{
                    console.log('request sent')
                    if(response.status==200){
                        console.log(' img sucess');
                    }else if(response.status==404){
                        console.log(response.msg);
                    }
                    else{
                        console.log("img error");
                    }
                }).catch(er=>{
                    
                    console.log('this not what i need'+er);
                })
        },
        editProfile: (commit, payload)=>{
            let token =localStorage.getItem('token');
        
           let username= payload.username;
           let email= payload.email;
           let age= payload.age;
           let bio= payload.bio;

            axios.post('editprofile', {token, username, email, age, bio} )
            .then(response=>{
                console.log('request sent')
                if(response.status==200){
                    console.log('editprofile sucess');
                }else{
                    console.log(" editprofile error");
                }
            }).catch(er=>{
                console.log(er);
                console.log("error editing the profil")
            })
        },
        viewresults: async (commit, payload)=>{
            let token =localStorage.getItem('token');

            
            let username= payload.username;
           return await axios.post('search',{token, username}).then(response => {
              return response.data.data;
               
               
            }).catch(er=>{
                    console.log(er);
                });
                
            
                   
            },
            viewfriends: async() =>{
                let token =localStorage.getItem('token');
                return await axios.post('listfriends',{token}).then(response =>
                    {
                        return response.data.data;
                      
                    }).catch(er=>{
                        console.log(er);
                    });
            },
            viewprofile: async() =>{
                let token =localStorage.getItem('token');
                return await axios.post('viewprofile',{token}).then(response =>
                    {
                        return response.data.data;
                      
                    }).catch(er=>{
                        console.log(er);
                    });
            },
        },
    modules: {
        cUser: cUser,
        UI: UI
    }
})

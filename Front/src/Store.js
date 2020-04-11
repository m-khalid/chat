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
          /*  axios.post('img', payload , {headers: {'token': localStorage.getItem('token')}})
            .then(response=>{
                console.log('request sent')
                if(response.status==200){
                    console.log(' img sucess');
                }else{
                    console.log("img error");
                }
            }).catch(er=>{
                console.log(er);
            })
            */

            axios({
                method: "POST", 
                data: payload,
                headers: {authorization: localStorage.getItem('token')}
            }).then(response=>{
                console.log('request sent')
                if(response.status==200){
                    console.log(' img sucess');
                }else{
                    console.log("img error");
                }
            }).catch(er=>{
                console.log(er);
            })
        },
        editProfile: (commit, payload)=>{
            axios.post('editprofile', payload , {headers: {'token': localStorage.getItem('token')}})
            .then(response=>{
                console.log('request sent')
                if(response.status==200){
                    console.log('editprofile sucess');
                }else{
                    console.log(" editprofile error");
                }
            }).catch(er=>{
                console.log(er);
            })
        },
    },
    modules: {
        cUser: cUser,
        UI: UI
    }
})

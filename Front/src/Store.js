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
        }
    },
    actions: {
        login: (context, payload) => {
            console.log('iam in action login');
            
                axios.post('login', payload)
                .then(response=>{
                  if(response.status==200){
                    const token =response.data.data.token;
                      localStorage.setItem('token', token);
                  }
                }).catch( ()=>{
                    alert('wrong username or password');
                });
            
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
        }
    },
    modules: {
        cUser: cUser,
        UI: UI
    }
})

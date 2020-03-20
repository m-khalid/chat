import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import cUser from './modules/User';

Vue.use(Vuex)

export default new Vuex.Store({
    state: {},
    mutations: {},
    actions: {
        login: (commit, payload) => {
            console.log('iam in action login');
            return new Promise((resolve, reject)=>{
                axios.post('login', payload)
                .then((data, status) =>{
                  if(status===200){
                      resolve(true);
                  }
                }).catch(error =>{
                    reject(error);
                })
            });
        },
        register: (commit , payload)=>{
            console.log("i'm in register hoooooo");
            return new Promise((resolve, reject)=>{
                axios.post('register', payload)
                .then((data, status)=>{
                    if(status===200){
                        resolve(true);
                    }
                }).catch(error =>{
                    reject(error);
                })
            });
        }
    },
    modules: {
        cUser: cUser
    }
})

import { defineStore } from 'pinia'
import { postLogin } from '@/utilities/api/user'

export const useUserStore = defineStore('user', {
    state: () => ({
        loggedIn: false,
        credentials: {
            userName: null,
            password: null,
        },
        errorMessage: null
    }),
    getters: {
        isLoggedIn: state => {
            let loggedIn = window.localStorage.getItem('loggedIn')
            return loggedIn || state.loggedIn
        }
    },
    actions: {
        login(credentials, callback) {
            postLogin({
                email: credentials.userName,
                password: credentials.password
            }).then(response => {
                if (!response.errors && response.access_token) {
                    this.loggedIn = true
                    window.localStorage.setItem('loggedIn', 'true')
                    window.localStorage.setItem('access_token', response.access_token)
                }
                
                // ACTIVATE CALLBACK WITH THE LOGIN STATUS
                callback(response.errors ? false : true)
            }).catch(error => {
                this.errorMessage = error.message
                this.loggedIn = false
                window.localStorage.removeItem('loggedIn')
                window.localStorage.removeItem('access_token')
                callback(false)
            });
        },
        logout() {
            this.loggedIn = false
            window.localStorage.removeItem('loggedIn')
            window.localStorage.removeItem('access_token')
        }
    }
})

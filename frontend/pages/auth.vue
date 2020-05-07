<template>
    <v-app id="inspire">
        <Navigation :list="navigation">Authorization</Navigation>

        <v-content>
            <v-container class="text-left">
                <h1>Авторизация</h1>
                <v-divider class="mt-5"></v-divider>

                <v-list class="mx-0 mt-5">
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title>Почта</v-list-item-title>
                            <v-list-item-subtitle>admin@test.com - admin</v-list-item-subtitle>
                            <v-list-item-subtitle>user@test.com - user</v-list-item-subtitle>
                            <v-text-field v-model="email" outlined></v-text-field>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title>Пароль</v-list-item-title>
                            <v-list-item-subtitle>admin - admin</v-list-item-subtitle>
                            <v-list-item-subtitle>user - user</v-list-item-subtitle>
                            <v-text-field v-model="password" outlined v-on:keyup.enter="auth"></v-text-field>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-subtitle>
                                <v-btn outlined @click="auth" color="success">Войти</v-btn>
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

            </v-container>
        </v-content>



        <v-footer color="indigo" app >
            <span class="white--text">&copy; 2020</span>
        </v-footer>
    </v-app>
</template>

<script>
import Navigation from '~/components/Navigation.vue'

export default {
    components: {
        Navigation,
    },
    data(){
        return {
            email: '',
            password: '',
            device_name: '',
            drawer: false,
            navigation: [
                {
                    icon: 'mdi-home',
                    path: '/',
                    title: 'Главная',
                },
                {
                    icon: 'mdi-book',
                    path: '/books/all',
                    title: 'Книги',
                }
            ]
        }
    },
    methods:{
        auth() {
            this.$axios.post('/api/get_token', {
                email: this.email,
                password: this.password,
                device_name: this.device_name,
            }).then(response => {
                //this.$store.getters.getToken
                console.log("response", response);
                this.$store.dispatch('setToken', response.data);
                if (this.$store.getters.getRole == "admin")
                    this.$router.push('/books/admin');
                else
                    this.$router.push('/books/all');
                
            }).catch(function (error) {
                console.log(error);
                alert(error)
            })
        }
    },
    mounted() {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            this.device_name = 'mobile';
        } else {
            this.device_name = 'web';
        }
    }
}
</script>

<style>
.link {
    text-decoration: none;
    color: white;
}
</style>
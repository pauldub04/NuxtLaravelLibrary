<template>
    <v-app id="inspire">
        <Navigation :list="navigation">Main page</Navigation>

        <v-content>
            <v-container>
                <h1>Добро пожаловать в онлайн библиотеку!</h1>
                <v-divider class="mt-5"></v-divider>
                <v-row justify="letf" class="my-2 text-left" v-if="!$store.getters.getIsAuth">
                    <v-col cols='5'>Вам необходимо войти, чтобы просмотреть список книг</v-col>
                    <v-col cols='1'>
                        <v-btn outlined color="primary" to="/auth">Войти</v-btn>
                    </v-col>
                </v-row>
                <v-row justify="letf" class="my-2 text-left" v-else>
                    <v-col cols='1'>
                        <v-btn outlined color="primary" to="/books/all" >Просмотреть список книг</v-btn>
                    </v-col>
                </v-row>

            </v-container>
        </v-content>

    </v-app>
</template>

<script>
import Navigation from '~/components/Navigation.vue'

export default {
    components: {
        Navigation,
    },
    data() {
        return {
            navigation: [
                {
                    icon: 'mdi-login',
                    path: '/auth',
                    title: 'Войти',
                },
                {
                    icon: 'mdi-book',
                    path: '/books/all',
                    title: 'Книги',
                }
            ]
        }
    },
    methods: {
    },
    
}
</script>

<template>
<v-app id="inspire">
    <Navigation :list="navigation">Books</Navigation>

    <v-content>
        <v-container>
            <h1>Список книг нашей библиотеки</h1>

            <v-divider class="mt-5"></v-divider>
            <v-row justify="center" class="my-2 font-weight-bold text-left">
                <v-col cols="1">#</v-col>
                <v-col cols="4" class="text-center">Название</v-col>
                <v-col cols="4" class="text-center">Автор</v-col>
                <v-col cols="3" class="text-center">Наличие</v-col>
            </v-row>
            <v-divider class="mb-7"></v-divider>

            <v-row justify="center"
                    v-for="(book, ind) in books" 
                    v-bind:key="ind"
                    class="text-left" 
                    v-bind:class="{notAvailable: !book.availability}">

                <v-col cols="1" class="font-weight-bold">
                        {{ind + 1}}
                </v-col>
                <v-col cols="4" class="text-center">{{book.title}}</v-col>
                <v-col cols="4" class="text-center">{{book.author}}</v-col>
                <v-col cols="3" color="primary" outlined class="text-center">
                    {{isAvailable(book)}}
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
    data(){
        return {
            books:[],
            drawer: false,
            navigation: [
                {
                    icon: 'mdi-home',
                    path: '/',
                    title: 'Главная',
                },
            ]
        }
    },
    methods: {
        loadBooks(){
            this.$axios.get('/api/book/all', {
                headers: {
                    "Authorization": 'Bearer ' + this.$store.getters.getToken
                }
            })
            .then(response=>{
                console.log('books = ', response.data);
                this.books = response.data;
            })
            .catch(error=>{
                console.log(error);
                alert("Вы должны авторизироваться, прежде чем увидите список книг");
                this.$router.push('/auth');
            })
        },
        isAvailable(obj) {
            if (obj.availability)
                return "Доступна";
            else
                return "Нет в наличии";
        },
        logOut() {
            this.$store.dispatch('logOut');
            this.$router.push('/auth')
        },
    },
    mounted(){
        if (this.$store.getters.getRole == "admin") {
            alert("Вы будете перенаправлены на страницу администратора");
            this.$router.push('/books/admin');
        }
        this.loadBooks();
    },
}
</script>

<style>
.notAvailable{
    color: grey;
    text-decoration: line-through;
}
</style>
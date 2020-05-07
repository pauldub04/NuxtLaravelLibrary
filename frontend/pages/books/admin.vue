<template>
<v-app id="inspire">
    <Navigation :list="navigation">Books</Navigation>

    <v-content>
        <v-container>
            <v-row>
                <h1>Список книг библиотеки</h1>
                <v-btn @click="loadBooks()" text small class="mt-3 ml-5">
                    <v-icon>mdi-refresh</v-icon>
                </v-btn>
            </v-row>

            <v-divider class="mt-5"></v-divider>
            <v-row justify="center" class="my-2 font-weight-bold text-left">
                <v-col cols="1">#</v-col>
                <v-col cols="4">Название</v-col>
                <v-col cols="3">Автор</v-col>
                <v-col cols="2">Наличие</v-col>
                <v-col cols="2">Действия</v-col>
            </v-row>
            <v-divider class="mb-7"></v-divider>

            <v-row justify="center"
                    v-for="(book, ind) in books" 
                    v-bind:key="ind"
                    class="text-left" 
                    v-bind:class="{notAvailable: !book.availability}">

                <v-col cols="1"
                        class="font-weight-bold">
                        {{ind + 1}}
                </v-col>
                <v-col cols="4">{{book.title}}</v-col>
                <v-col cols="3">{{book.author}}</v-col>
                <v-col cols="2">
                    <v-btn @click="changeBookAvailability(book.id)"
                            color="primary" outlined>
                        {{isAvailable(book)}}
                    </v-btn>
                </v-col>
                <v-col cols="2">
                    <v-btn @click="deleteBook(book.id)"
                            color="error" outlined>
                        Удалить
                    </v-btn>
                </v-col>
            </v-row>

            <v-divider class="mt-7"></v-divider>
            <v-row>
                <v-col cols="1" class="pt-7 font-weight-bold">
                    Добавить
                </v-col>  
                <v-col cols="4">
                    <v-text-field
                        placeholder="Название"
                        outlined
                        v-model="addingTitle"
                    ></v-text-field>
                </v-col>
                <v-col cols="3">
                    <v-text-field
                        placeholder="Автор"
                        outlined
                        v-on:keyup.enter="addBook()"
                        v-model="addingAuthor"
                    ></v-text-field>
                </v-col>
                <v-spacer/>
                <v-col cols="2" class="mt-3">
                    <v-btn @click="addBook()" color="success" outlined>
                        Добавить
                    </v-btn>
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
            addingTitle: '',
            addingAuthor: '',
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
    methods:{
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
        addBook(){
            this.$axios.post('/api/book/add', {
                    title: this.addingTitle,
                    author: this.addingAuthor,
                }, {
                headers: {
                    "Authorization": 'Bearer ' + this.$store.getters.getToken,
                }
            })
            this.loadBooks();
            this.addingTitle = '';   
            this.addingAuthor = '';   
        },
        deleteBook(id){
            this.$axios.get(`api/book/delete/${id}`, {
                headers: {
                    "Authorization": 'Bearer ' + this.$store.getters.getToken
                }
            })
            this.loadBooks();
        },
        changeBookAvailability(id){
            this.$axios.get(`api/book/change_availability/${id}`, {
                headers: {
                    "Authorization": 'Bearer ' + this.$store.getters.getToken
                }
            })
            this.loadBooks();
        },
        isAvailable(obj) {
            if (obj.availability == 1)
                return "Доступна";
            else
                return "Нет в наличии";
        },
        logOut() {
            this.$store.dispatch('logOut');
            this.$router.push('/');
        },
    },
    mounted(){
        if (this.$store.getters.getRole != "admin") {
            alert('Вы должны быть администратором, чтобы просматривать эту страницу');
            this.$router.push('/books/all');
        }
        this.loadBooks(); 
    }
}
</script>

<style>
.notAvailable{
    color: grey;
    text-decoration: line-through;
}
</style>
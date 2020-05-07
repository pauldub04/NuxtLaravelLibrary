<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Books</title>
    <!-- Подключаем Bootstrap, чтобы не работать над дизайном проекта -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .notAvailable{
            color: grey;
            text-decoration: line-through;
        }
    </style>
</head>
<body>
    @verbatim
    <div id="app">
        <div class="container mt-5">
            <h1>Список книг нашей библиотеки</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Автор</th>
                        <th scope="col">Наличие</th>
                        <th scope="col">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <div v-if="!books.length" style="font-size: 25px; color: grey; margin-top: 15px; margin-bottom: 15px">Книг пока нет</div>
                    <tr v-for="(book, ind) in books" v-bind:class="{notAvailable: !book.availability}">
                        <th scope="row">{{ind + 1}}</th>
                        <td>{{book.title}}</td>
                        <td>{{book.author}}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary" @click="changeBookAvailability(book.id)">
                                {{isAvailable(book)}}
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-danger" @click="deleteBook(book.id)">
                                Удалить
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Строка с полями для добавления новой книги -->
                    <tr>
                        <th scope="row">Добавить</th>
                        <td><input v-model="addingTitle" type="text" class="form-control"></td>
                        <td><input v-model="addingAuthor" type="text" class="form-control" v-on:keyup.enter="addBook()"></td>
                        <td></td>
                        <td>
                            <button type="button" class="btn btn-outline-success"
                                    @click="addBook()" v-on:keyup.enter="addBook()">
                                Добавить
                            </button>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
    @endverbatim

    <!--Подключаем axios для выполнения запросов к api -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>

    <!--Подключаем Vue.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>

    <script>
        let vm = new Vue({
            el: '#app',
            data: {
                addingTitle: '',
                addingAuthor: '',
                books: [],
            },
            methods: {
                loadBookList(){
                    axios.get('/book/all').then(response=>{
                        this.books = response.data;
                        console.log(response);
                    })
                },
                addBook(){
                    axios.post('/book/add', {
                        title: this.addingTitle,
                        author: this.addingAuthor
                    })
                    this.loadBookList();    
                    this.addingTitle = '';
                    this.addingAuthor = '';
                },
                deleteBook(id){
                    axios.get(`/book/delete/${id}`)
                    this.loadBookList();
                },
                changeBookAvailability(id){
                    axios.get(`/book/change_availability/${id}`)
                    this.loadBookList();
                },
                isAvailable(obj) {
                    if (obj.availability)
                        return "Доступна";
                    else
                        return "Нет в наличии";
                }
            },
            mounted(){
                // Сразу после загрузки страницы подгружаем список книг и отображаем его
                this.loadBookList();
            }
        });

    </script>
</body>
</html>
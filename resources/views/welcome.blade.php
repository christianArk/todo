<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" id="csrftoken" content="{{ csrf_token() }}">

        <title>MyTodo</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/vue-resource.js') }}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height" id="app">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="" style="width: 600px;">
                <div class="title text-center">
                    MyTodo
                </div>

                <div class="">
                    <div v-if="items.length > 0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width:90%">Tasks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in items">
                                <td>@{{ item.title }}</td>
                                <td>
                                    <div class="pull-right btn-group">
                                        <button class="btn btn-default" @click="editTask(item.id)"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-info" @click="viewTask(item.id)"><i class="fa fa-eye"></i></button>
                                        <button class="btn btn-danger" @click="deleteTask(item.id)"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <div v-else>
                        <div class="alert alert-info">You have not added any task!</div>
                    </div>

                    <div class="input-group mb-3" style="margin-top: 20px;">
                        <input type="text" v-model="newitem" class="form-control" placeholder="Add a new task">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="button" @click="addNewItem">Add</button>
                        </div>
                      </div>
                </div>
            </div>

            <div class="modal fade" id="viewtask" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">View Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>@{{ item.title }}</p>
                    </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edittask" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" v-model="item.title" />
                        </div>
                        <button class="btn btn-primary" @click="updateTask">Update</button>
                    </div>
                    </div>
                </div>
            </div>

        </div>
    </body>
    <script>
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("#csrftoken").getAttribute('content');
        const app = new Vue({
            el: '#app',

            data: {
                items: [],
                newitem: '',
                item: {}
            },

            mounted: function() {
                this.getTasks();
            },

            methods: {
                getTasks: function() {
                    this.$http.get('/gettasks').then(res => {
                        this.items = res.data
                    });
                },
                viewTask: function(taskid) {
                    this.$http.get('/gettask/' + taskid).then(res => {
                        $('#viewtask').modal('show');
                        this.item = res.data;
                    });
                },
                editTask: function(taskid) {
                    this.$http.get('/gettask/' + taskid).then(res => {
                        $('#edittask').modal('show');
                        this.item = res.data;
                    });
                },
                updateTask: function() {
                    this.$http.post('/updatetask', {id: this.item.id, title: this.item.title}).then(res => {
                        this.getTasks();
                        $('#edittask').modal('hide');
                        swal({
                            title: "Task Updated!",
                            text: "You have successfully updated a task!",
                            icon: "success",
                        });
                    });
                },
                deleteTask: function(taskid) {
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this task!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        this.$http.post('/deletetask', {id: taskid}).then(res => {
                            this.getTasks();
                        });
                        swal("Poof! Your task has been deleted!", {
                        icon: "success",
                        });
                    } else {
                        // swal("Your imaginary file is safe!");
                    }
                    });
                },
                addNewItem: function() {
                    this.$http.post('/createtask', {title: this.newitem}).then(res => {
                        this.getTasks();
                    });
                    this.newitem = '';
                }
            }

        });
    </script>
</html>


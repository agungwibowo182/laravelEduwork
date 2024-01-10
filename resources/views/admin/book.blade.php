@extends('layouts.admin')
@section('header', 'Book')

@section('css')
{{-- datatables --}}
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">


@endsection

@section('content')

<div id="controller">
    <div class="row">
        <div class="col-md-5 offset-md-3">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control" autocomplete="off" placeholder="Search from title" v-model="search">
            </div>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" @click="addData()">Create New Book</button>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12" v-for="book in filteredList">
            <div class="info-box" v-on:click="editData(book)">
                <div class="info-box-content">
                    <span class="info-box-text h3">@{{ book.title }} (@{{ book.qty }})</span>
                    <span class="info-box-number">Rp.@{{ numberWithSpaces(book.price) }},-<small></small></span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" :action="actionUrl" autocomplete="off" @submit.prevent="submitForm">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Book</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf

                        <input type="hidden" name="_method" value="PUT" v-if="editStatus">

                        <div class="form-group">
                            <label>ISBN</label>
                            <input type="number" class="form-control" name="isbn" required="" :value="book.isbn">
                            @error('isbn')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title"  required="" :value="book.title">
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Year</label>
                            <input type="number" class="form-control" name="year" required="" :value="book.year">
                            @error('year')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Publisher</label>
                            <select name="publisher_id" class="form-control">
                                @foreach ($publishers as $publisher )
                                <option :selected="book.publisher_id == {{ $publisher -> id }}" value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                                @endforeach
                            </select>
                            @error('publisher_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Author</label>
                            <select name="author_id" class="form-control">
                                @foreach ($authors as $author )
                                <option :selected="book.author_id == {{ $author -> id }}" value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach
                            </select>
                            @error('author_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Catalog</label>
                            <select name="catalog_id" class="form-control">
                                @foreach ($catalogs as $catalog )
                                <option :selected="book.catalog_id == {{ $catalog -> id }}"  value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                                @endforeach
                            </select>
                            @error('catalog_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Qty Stock</label>
                            <input type="number" class="form-control" name="qty" required="" :value="book.qty">
                            @error('qty')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Harga Pinjam</label>
                            <input type="number" class="form-control" name="price" required="" :value="book.price">
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default bg-danger" data-dismiss="modal" v-if="editStatus"  v-on:click="deleteData(book.id)">Delete</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>
@endsection

@section('js')
<script type="text/javascript">
    var actionUrl = '{{ url('books') }}';
    var apiUrl = '{{ url('api/books') }}';

    var app = new Vue ({
        el:'#controller',
        data: {
            books : [],
            search:'',
            book:{},
            actionUrl : '{{ url ('books') }}',
            editStatus: false
        },
        mounted: function() {
            this.get_books();
        },
        methods: {
            get_books() {
                const _this = this;
                $.ajax({
                    url: apiUrl,
                    method: 'GET',
                    success: function (data) {
                        _this.books = JSON.parse(data);
                    },
                    error: function (error) {
                        console.log(error)
                    }
                });
            },
            addData() {
                // console.log('addData method called');
                this.book = {};
                this.actionUrl = '{{ url ('books') }}',
                this.editStatus = false;
                $('#modal-default').modal();
            },
            editData(book) {
                
                this.book = { ...book }; // Make a copy to avoid modifying the original book data
                this.actionUrl = '{{ url('books') }}'; // Ensure the URL is constructed correctly
                this.editStatus = true;
                $('#modal-default').modal();
                // console.log('{{ url('books') }}' + '/' + book.id);
            },
            deleteData(id) {
                this.actionUrl = '{{ url('books') }}'+'/'+id;
                if(confirm("Are you sure ?")) {
                    axios.post(this.actionUrl, {_method: 'DELETE'}).then(response=> {
                        location.reload();
                    });
                }
            },
            submitForm() {
                event.preventDefault();
                const _this = this;

                const actionUrl = !this.editStatus ? this.actionUrl : (this.book.id ? this.actionUrl + '/' + this.book.id : this.actionUrl);

                const formData = new FormData($(event.target)[0]);
                if (this.editStatus) {
                    formData.append('_method', 'PUT');
                }
                
                // console.log(actionUrl);
                axios.post(actionUrl, formData)
                    .then(response => {
                        $('#modal-default').modal('hide');
                        _this.get_books(); // Reload the data
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            
            // function format number
            numberWithSpaces(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
            // function format number
        },
        computed: {
            filteredList() {
                return this.books.filter(book =>{
                    return book.title.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        }
    });
</script>
@endsection
@extends('layouts.admin')
@section('header','Author')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection 
    
@section('content')
<div id="controller">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="#" @click="addData()" class="btn btn-sm btn-primary pull-right">Create New Author</a>
                </div>
                <div class="card-body">
                @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <table id="datatable" class="table table-striped table-borderless">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 10px">No</th>
                                <th class="text-left">Name</th>
                                <th class="text-left">Email</th>
                                <th class="text-left">Phone_Number</th>
                                <th class="text-left">Address</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" :action="actionUrl" autocomplete="off">
                    <div class="modal-header">

                        <h4 class="modal-title">Author</h4>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf

                        <input type="hidden" name="_method" value="PUT" v-if="editStatus">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" :value="data.name" required="">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" :value="data.email" required="">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" :value="data.phone_number" required="">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address" :value="data.address" required="">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<div>
@endsection

@section('js')
<!-- DataTables & Plugin -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script type="text/javascript">
    var actionUrl = '{{ url('authors') }}';
    var apiUrl = '{{ url('api/authors') }}';

    var columns = [
        {data: 'DT_RowIndex', class: 'text-center', orderable:true},
        {data: 'name', class: 'text-center', orderable:true},
        {data: 'email', class: 'text-center', orderable:true},
        {data: 'phone_number', class: 'text-center', orderable:true},
        {data: 'address', class: 'text-center', orderable:true},
        {render: function (index, row, data, meta) {
            return `
            <a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">
            Edit
            </a>
            <a class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">
            Delete
            </a> `;
        }, orderable: false, width: '200px', class: 'text-center' },
    ];

    var controller = new Vue({
        el: '#controller',
        data: {
            datas : [],
            data : {},
            actionUrl,
            apiUrl,
            editStatus : false,
        }, 
        mounted: function () {
            this.datatable();
        },
        methods: {
            datatable () {
                const _this = this;
                _this.table = $('#datatable').DataTable({
                    ajax : {
                        url: _this.apiUrl,
                        type: 'GET',
                    },
                    columns: columns
                }).on('xhr', function () {
                    _this.datas = _this.table.ajax.json().data;                
                });
            },
            addData () {
                this.data = {};
                this.actionUrl = '{{ url('authors') }}';
                this.editStatus = false;
                $('#modal-default').modal();   
            },
            editData (event, row) {
                this.data = this.datas[row];
                this.actionUrl = '{{ url('authors') }}'+'/'+this.data.id;
                this.editStatus = true;
                $('#modal-default').modal();
            },
            deleteData (event, id) {
                this.actionUrl = '{{ url('authors') }}'+'/'+id;
                if (confirm("Are you sure?")) {
                    axios.post(this.actionUrl, {_method: 'DELETE'}).then(response => {
                        location.reload();
                    });
                }
            }
        }  
    });
</script>



<!-- <script type="text/javascript">
     $(function () {
        $("#example1").DataTable({
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
 CRUD VUE JS 
<script type="text/javascript">
    var controller = new Vue({
        el: '#controller',
        data: {
            data : {},
            editStatus : false
        }, 
        mounted: function (){

        },
        methods: {
            addData () {
                this.data={};
                this.actionUrl = '{{ url('authors') }}';
                this.editStatus = false;
                $('#modal-default').modal();  
            },
            editData (data) {
                this.data=data;
                this.actionUrl = '{{ url('authors') }}'+'/'+data.id;
                this.editStatus = true;
                $('#modal-default').modal();
            },
            deleteData (id) {
                this.actionUrl = '{{ url('authors') }}'+'/'+id;
                if (confirm("Are you sure?")) {
                    axios.post(this.actionUrl, {_method: 'DELETE'}).then(response => {
                        location.reload();
                    });
                }
            }
        }  
    });
</script>

@endsection -->




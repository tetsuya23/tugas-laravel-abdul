@extends('layouts.admin')
@section('header','Member')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
    
@section('content')
<div id="controller">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <a href="#" @click="addData()" class="btn btn-sm btn-primary pull-right">Create New Member</a>
                </div>
                <div class="col-md-2">
                    <select class="form-control" name="sex">
                        <option value="0">Semua Jenis Kelamin</option>
                        <option value="P">Perempuan</option>
                        <option value="L">Laki-laki</option>
                    </select>
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
                                <th class="text-center">Name</th>
                                <th class="text-center">Gender</th>
                                <th class="text-center">Phone_Number</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Action</th>
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
                <form method="post" :action="actionUrl" autocomplete="off" @submit="submitForm($event, data.id)">
                    <div class="modal-header">

                        <h4 class="modal-title">Member</h4>

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
                            <label>Gender</label>
                            <input type="text" class="form-control" name="gender" :value="data.gender" required="">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" :value="data.phone_number" required="">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address" :value="data.address" required="">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" :value="data.email" required="">
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
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script type="text/javascript">
    var actionUrl = '{{ url('members') }}';
    var actionApi = '{{ url('api/members') }}';
    var columns = [
        {data: 'name', class: 'text-center', orderable: true},
        {data: 'gender', class: 'text-center', orderable: true}, 
        {data: 'phone_number', 'text-center', orderable: true},
        {data: 'address', class: 'text-center', orderable: true},
        {data: 'email', class: 'text-center', oderable: true},
        {render: function (index, row, data, meta) {
            return `
                <a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">
                    Edit
                </a>
                <a class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">
                    Delete
                </a>`>;
        }, orderable: false, width: '100 px', class: 'text-center'},
    ];
    var controller = new Vue({
        el: '#controller',
        data: {
            datas : [],
            data : {},
            actionUrl:actionUrl,
            apiUrl:actionApi,
            editStatus : false,
        }, 
        mounted: function () {
            this.datatable();
        },
        methods: {
            datatable: function () {
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
                this.editStatus = false;
                $('#modal-default').modal();   
            },
            editData (event, row) {
                this.data = this.datas[row];
                this.editStatus = true;
                $('#modal-default').modal();
            },
            deleteData (event, id) {
                if (confirm("Are you sure?")) {
                    $(event.target).parents('tr').remove();
                    axios.post(this.actionUrl+'/'+id, {_method: 'DELETE'}).then(response => {
                        alert('Data has been removed');
                    });
                }
            },
            submitForm(event, id) {
                event.preventDefault();
                const _this = this;
                var actionUrl = !this.editStatus ? this.actionUrl : this.actionUrl + '/' + id;
                axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
                  $('#modal-default').modal('hide');
                  _this.table.ajax.reload();
                });
            },
        }  
    });

</script>
<!-- <script src="{{ asset('js/data.js') }}"></script> -->
<script type="text/javascript">
    $('select[name/gender]').on('change', function() {
        gender = $('select[name=gender]').val();

        if (gender == 0) {
            controller.table.ajax.url(actionUrl).load();
        } else {
            controller.table.ajax.url(actionUrl+'?gender='+gender).load(;
        }
    });
</script>
@endsection
 
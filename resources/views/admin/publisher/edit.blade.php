@extends('layouts.admin')
@section('header','Publisher')
    
@section('content')
<div class="row">
          <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Publisher</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('publishers/'.$publisher->id) }}" method="post">
                @csrf
                {{ method_field('PUT') }}
                
                <div class="card-body">
                    <label for="form-group"><label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Name" required="" value="{{ $publisher->name }}">
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select class="form-control" id="randomElement" name="gender">
                            <option value="">-- Pilih Gender --</option>
                            <option value="L">L</option>
                            <option value="P">P</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone number:</label>
                        <input type="tel" class="form-control" id="phone" name="phone_number" placeholder="Enter phone number" pattern="[0-9]{10,12}" required="" value="{{ $publisher->phone_number }}">
                    </div>
                    <div class="form-group">
                        <label for="form-group"><label>Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Enter Address" required="" value="{{ $publisher->address }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" required="" value="{{ $publisher->email }}">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layout')


@section('css')
@endsection

@section('content')
<div class='row'>
        <div class='col-md-12'>
            <div class='card reload-content'>
                <div class="card">
                    <div class="card-header inline">
                        <h5 >Total User&nbsp;<span class="text-white bg-success badge">{{ $_user->total() }}</span></h5>
                        
                        <button class="btn btn-danger f-right btn-padding btn-modal" data-id="0" data-toggle="modal" data-url="{{route('user_new')}}" data-target="#modal-user" data-container=".custom-modal"><i class="ti-plus"></i> New</button>
                    </div>
                    <div class='card-block camera_div_body table-responsive'>
                        
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>User Level</th>
                                        <th>Date Created</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($_user as $user)
                                    <tr class="btn-modal" data-url="{{route('user_view')}}" data-id="{{$user->id}}" data-target="#modal-user" data-toggle="modal" data-container=".custom-modal">
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->permission_name}}</td>

                                     
                                        <td>{{$user->created_at}}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger"><i class="ti-pencil"></i></button>
                                            <button class="btn btn-danger btn-archived" data-url="{{route('user_inactive')}}" data-id="{{$user->id}}" data-name="{{$user->name}}"><i class="ti-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!!$_user->appends(request()->query())->links()!!}
                            <br>Records Found : {{ $_user->total() }}. Showing {{ $_user->firstItem() }} to {{ $_user->lastItem() }} of total {{$_user->total()}} entries
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <div id="modal-user" class="modal fade" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content custom-modal class-modal-body">
          
        </div>
    
      </div>
    </div>
    <div class="user-password-container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">

                <form class="form-password" action="{{route('user_password_authenticate')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="col-md-12 text-center header-password">
                            <h3>Authentication</h3>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Please enter you password here</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 text-center auth-status">
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-danger btn-auth-pass" type="submit">Authenticate</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript" src="/js/user.js?{{time()}}"></script>
@endsection
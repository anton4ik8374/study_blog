@extends('admin.layout')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Добавить пользователя
                <small>приятные слова..</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
        {{Form::open([
            'route'	=>	['users.update', $user->id],
            'method'	=>	'put',
            'files'	=>	true
        ])}}
        <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Добавляем пользователя</h3>
                    @include('admin.errors')
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Имя</label>
                            <input type="text" class="form-control" name="name" placeholder="" value="{{$user->name}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">E-mail</label>
                            <input type="text" class="form-control" name="email" placeholder=""
                                   value="{{$user->email}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Пароль</label>
                            <input type="password" class="form-control" name="password" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Повторите Пароль</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <img src="{{$user->getImagesMini()}}" alt="" width="100" class="img-responsive">
                            <label for="exampleInputFile">Аватар</label>
                            <input type="file" name="avatar">

                            <p class="help-block">The file under validation must be an image (jpeg, png, bmp, gif, svg,
                                or webp)</p>
                        </div>
                        <div class="form-group">
                            <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                                <input type="checkbox" name="is_admin" value="{{$user->is_admin}}" {{$user->is_admin ? 'checked':''}} class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Администратор</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                                <input type="checkbox" name="status" value="{{$user->status}}" {{$user->status ? 'checked':''}} class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Активный</span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-warning pull-right">Изменить</button>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
            {{Form::close()}}
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
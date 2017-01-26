@extends(\Request::ajax() ? 'backend::layouts.empty' : 'backend::layouts.master')
@section('content')
    <div class="portlet box blue-hoki ajax-portlet" data-require="rabbitcms.galleries:update">
        <div class="portlet-title">
            <div class="caption">Редагування галереї</div>
            <div class="actions">
                <a class="btn btn-default btn-sm" rel="back" href="{{relative_route('backend.galleries.galleries.index')}}">
                    <i class="fa fa-arrow-left"></i> Назад</a>
            </div>
        </div>

        <div class="portlet-body form">
            <form method="post" action="{{relative_route('backend.galleries.galleries.update', ['id' => $model->id])}}">
                {{csrf_field()}}

                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Заголовок</label>
                                <input type="text" class="form-control" name="caption" value="{{$model->caption}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">URL</label>
                                <input type="text" class="form-control" name="slug" value="{{$model->slug}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Статус</label>
                                <select class="form-control" name="active">
                                    <option @if($model->active === true) selected @endif value="1">Опубліковано</option>
                                    <option @if($model->active === false) selected @endif value="0">Приховано</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <h3 class="form-section">Файли</h3>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span class="btn btn-success fileinput-button">
                                    <i class="fa fa-plus"></i>
                                    <span> Завантажити файли</span>
                                    <input id="fileupload-input" type="file" name="files[]" multiple="" data-url="{{route('backend.galleries.galleries.file.upload', ['id' => $model->id])}}">
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row fileupload-progress hidden">
                        <div class="col-md-12">
                            <div id="fileupload-progress-bar" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-success" style="width:0;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="error-container"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr role="row" class="heading">
                                    <th>Файл</th>
                                    <th style="width: 50px;">Дії</th>
                                </tr>
                                </thead>
                                <tbody class="files" id="uploaded-files-container">
                                @foreach($files as $file)
                                    @include('galleries::backend.galleries.uploaded-files-container-row', ['file' => $file])
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <template id="uploaded-files-container-row">
                    @include('galleries::backend.galleries.uploaded-files-container-row', ['file' => null])
                </template>

                <div class="form-actions">
                    <div class="pull-right">
                        <a class="btn red" rel="back" href="{{relative_route('backend.seminars.addresses.index')}}">
                            <i class="fa fa-close"></i> Скасувати</a>
                        <button type="submit" class="btn green"><i class="fa fa-check"></i> Зберегти</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

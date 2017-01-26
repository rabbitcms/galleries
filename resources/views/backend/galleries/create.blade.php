@extends(\Request::ajax() ? 'backend::layouts.modal' : 'backend::layouts.master')
@section('modal')
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Додавання галереї</h4>
    </div>
    <form method="post" class="form-horizontal" action="{{relative_route('backend.galleries.galleries.store')}}">
        <div class="modal-body form">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Заголовок</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="caption">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">URL</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="slug">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Статус</label>
                    <div class="col-md-8">
                        <select class="form-control" name="active">
                            <option value="1">Опубліковано</option>
                            <option value="0">Приховано</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn red" data-dismiss="modal">
                <i class="fa fa-times"></i> Скасувати</button>
            <button type="submit" class="btn green">
                <i class="fa fa-check"></i> Зберегти</button>
        </div>
    </form>
@stop

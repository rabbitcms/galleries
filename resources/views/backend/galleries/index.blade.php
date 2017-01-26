@extends(\Request::ajax() ? 'backend::layouts.empty' : 'backend::layouts.master')
@section('content')
    <div class="portlet box blue-hoki ajax-portlet" data-require="rabbitcms.galleries:table" data-permanent="permanent">
        <div class="portlet-title">
            <div class="caption">Галерея</div>
            <div class="actions">
                <a class="btn btn-default btn-sm" rel="create" href="{{relative_route('backend.galleries.galleries.create')}}">
                    <i class="fa fa-plus"></i> Створити</a>
            </div>
        </div>

        <div class="portlet-body">
            <div class="table-container">
                <table class="table table-striped table-bordered table-hover" data-link="{{relative_route('backend.galleries.galleries.list')}}" id="galleries_table">
                    <thead>
                    <tr role="row" class="heading">
                        <th data-name="id" data-data="id" style="width: 50px;">ID</th>
                        <th data-data="caption" class="fixed">Заголовок</th>
                        <th data-data="status" class="fixed">Статус</th>
                        <th data-data="actions" class="actions fixed" style="width: 95px;">Дії</th>
                    </tr>
                    <tr role="row" class="filter">
                        <td>
                            <input type="text" class="form-control form-filter input-sm" name="filters[id]">
                        </td>
                        <td>
                            <input type="text" class="form-control form-filter input-sm" name="filters[caption]">
                        </td>
                        <td>
                            <select name="filters[active]" class="form-control form-filter input-sm">
                                <option value="">Не вибрано</option>
                                <option value="1">Опубліковано</option>
                                <option value="0">Приховано</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-sm yellow filter-submit margin-bottom" title="Шукати">
                                <i class="fa fa-search"></i></button>
                            <button class="btn btn-sm red filter-cancel" title="Скинути">
                                <i class="fa fa-times"></i></button>
                        </td>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@stop
<tr>
    <td>
        <a class="gallery-item" href="{{$file !== null ? $file->path : '__PATH__'}}" target="_blank" title="{{$file !== null ? basename($file->path) : '__TITLE__'}}">
            {{$file !== null ? basename($file->path) : '__CAPTION__'}}</a>
        <input type="hidden" name="weight[]" value="{{$file !== null ? $file->id : '__ID__'}}">
    </td>
    <td>
        <a class="btn btn-sm red" rel="delete-file" href="{{$file !== null ? relative_route('backend.galleries.galleries.file.delete', ['id' => $file->id]) : '__DELETE__'}}">
            <i class="fa fa-trash-o"></i></a>
    </td>
</tr>
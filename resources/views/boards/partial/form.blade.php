@section('style')
    <link href="{{ asset('css/dropzone/dropzone.css') }}" rel="stylesheet">
@endsection

<div class="form-group">
    <label for="subject">
        제목
    </label>
    <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject', $board->subject) }}" placeholder="제목을 입력하세요" required>

    @error('subject')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

</div>

<div class="form-group">
    <label for="content">
        내용
    </label>
    <textarea name="content" id="content" rows="10" class="form-control @error('content') is-invalid @enderror" placeholder="내용을 입력하세요" required>{{ old('content', $board->content) }}</textarea>

    @error('content')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <div id="my-dropzone" class="dropzone rounded"></div>
</div>

@section('script')
<script src="{{ asset('js/dropzone/dropzone.js') }}"></script>
<script>
    var boardFiles = JSON.parse('{!! isset($boardFiles) ? json_encode($boardFiles) : '{}'!!}');

    var form = $('form.form_board').first();

    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone('#my-dropzone', {
        maxFilesize: 5, //MB
        acceptedFiles: 'image/jpg,image/jpeg,image/png,image/gif',
        uploadMultiple: false,
        parallelUploads: 1,
        addRemoveLinks: true,
        url: '{{ url('/boards/upload') }}',
        params: {
            _token: '{{ csrf_token() }}',
            boardId: '{{ $board->id }}',
        },
        dictDefaultMessage: '여기를 클릭하거나 또는 파일을 드래그앤드랍하여 업로드하세요.<br/> 이미지 파일만 업로드 가능[ jpg, png, gif ]',
        init: function () {
            thisDropzone = this;
            $.each(boardFiles, function(key, file) {
                var mockFile = file;

                mockFile.dataURL = "{{ url('/storage/board') }}/" + mockFile.save_name;
                mockFile.name    = mockFile.real_name;

                thisDropzone.emit('addedfile', mockFile);
                thisDropzone.createThumbnailFromUrl(
                    mockFile,
                    thisDropzone.options.thumbnailWidth,
                    thisDropzone.options.thumbnailHeight,
                    thisDropzone.options.thumbnailMethod,
                    true,
                    function (thumbnail) {
                        thisDropzone.emit('thumbnail', mockFile, thumbnail);
                    }
                );

                thisDropzone.emit('processing', mockFile);
                thisDropzone.emit('success', mockFile);
                thisDropzone.emit('complete', mockFile);

                thisDropzone.files.push(mockFile);

                $("<input>", { type: "hidden", name: "files[]", class: "files", value: mockFile.id }).appendTo(form);
            });
        }
    });

    myDropzone.on('success', function (file, data) {
        myDropzone.files.push(data);
        file.id = data.id;
        $("<input>", { type: "hidden", name: "files[]", class: "files", value: data.id }).appendTo(form);
    });

    myDropzone.on('removedfile', function (file) {
        $.ajax({
            type: 'POST',
            url: '{{ url('/boards/upload') }}' + '/' + file.id,
            data: {
                _method: 'DELETE',
                _token: '{{ csrf_token() }}',
            }
        })
    });

    myDropzone.on('error', function (file, errormessage, xhr){
        alert('업로드에 실패하였습니다.');
        /*if(xhr) {
            var response = JSON.parse(xhr.responseText);
            alert(response.message);
        }

        console.log(file);
        console.log(errormessage);*/
    });
</script>
@endsection

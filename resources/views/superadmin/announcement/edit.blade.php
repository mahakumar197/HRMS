@extends('layouts.app')
@section('page_title')
<title>Edit Announcement</title>
@endsection
@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>
            Edit Announcement</h3>
        </div>
        <div class="col-12 col-sm-6">

        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">


    <div class="row">
      <div class="col-sm-8">
        <div class="card">
          <div class="card-body">


            @if(Session::has('message'))
            <div class="alert alert alert-success" role="alert">
              {{session::get('message')}}
            </div>
            @endif

            <div class="form theme-form projectcreate">
              <div class="row">
                <form action="{{url ('announcement/'.$announcement->id) }}" method="post" autocomplete="off">
                  @csrf
                  @method('PUT')

                  <div class="col-sm-12">
                    <div class="mb-3">
                      <label>Title*</label>
                      <input class="form-control {{ $errors->has('title') ? ' has-error' : ''}}" type="text" placeholder="title" name="title" value="{{$announcement->title }}">
                      @if ($errors->has('title'))
                      <div class="text-danger">{{ $errors->first('title') }}</div>
                      @endif
                    </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="mb-3">
                    <label>Description*</label>
                    <textarea id="editor" class="{{ $errors->has('description') ? ' has-error' : ''}}" type="text" name="description" value="{{$announcement->description}}">{{html_entity_decode ($announcement->description)}}</textarea>
                    @if ($errors->has('description'))
                    <div class="text-danger">{{ $errors->first('description') }}</div>
                    @endif
                  </div>
                </div>
              </div>


              <div class="mb-3">
                <label>Status*</label>
                <select class="form-select {{ $errors->has('status') ? ' has-error' : ''}}" name="status">
                  <option value="">Select</option>
                  <option value="1" {{$announcement->status == '1' ?'selected':''}}>Active</option>
                  <option value="0" {{$announcement->status == '0' ?'selected':''}}>InActive</option>

                </select>
                @if ($errors->has('status'))
                <div class="text-danger">{{ $errors->first('status') }}</div>
                @endif
              </div>
              <div class="row">
                <div class="col">
                  <div class="text-left">
                    <input type="submit" class="btn btn-primary me-3" value="Update"><a href="{{route('announcement.index')}}" class="btn btn-secondary me-3">Cancel</a>
                  </div>
                </div>


                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


<script>
  function example_image_upload_handler(blobInfo, success, failure, progress) {
    var xhr, formData;

    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', '{{ route ("uploadimg") }}');
    var token = '{{ csrf_token() }}';

    xhr.setRequestHeader("X-CSRF-Token", token);



    xhr.onload = function() {
      var json;

      if (xhr.status === 403) {
        failure('HTTP Error: ' + xhr.status, {
          remove: true
        });
        return;
      }

      if (xhr.status < 200 || xhr.status >= 300) {
        failure('HTTP Error: ' + xhr.status);
        return;
      }

      json = JSON.parse(xhr.responseText);

      if (!json || typeof json.location != 'string') {
        failure('Invalid JSON: ' + xhr.responseText);
        return;
      }

      success(json.location);
      console.log(json.location);
    };

    xhr.onerror = function() {
      failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
    };

    formData = new FormData();
    formData.append('file', blobInfo.blob(), blobInfo.filename());

    xhr.send(formData);
  };



  tinymce.init({
    selector: 'textarea#editor',
    relative_urls: false,
    inline: false,
    content_css: false,
    convert_urls: false,
    plugins: 'image code',

    toolbar: 'undo redo | link image | code',
    /* enable title field in the Image dialog*/
    image_title: true,
    /* enable automatic uploads of images represented by blob or data URIs*/
    automatic_uploads: true,
    /*
      URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
      images_upload_url: 'postAcceptor.php',
      here we add custom filepicker only to Image dialog
    */
    file_picker_types: 'image',
    /* and here's our custom image picker*/
    file_picker_callback: function(cb, value, meta) {
      var input = document.createElement('input');
      input.setAttribute('type', 'file');
      input.setAttribute('accept', 'image/*');

      /*
        Note: In modern browsers input[type="file"] is functional without
        even adding it to the DOM, but that might not be the case in some older
        or quirky browsers like IE, so you might want to add it to the DOM
        just in case, and visually hide it. And do not forget do remove it
        once you do not need it anymore.
      */

      input.onchange = function() {
        var file = this.files[0];

        var reader = new FileReader();
        reader.onload = function() {
          /*
            Note: Now we need to register the blob in TinyMCEs image blob
            registry. In the next release this part hopefully won't be
            necessary, as we are looking to handle it internally.
          */
          var id = 'blobid' + (new Date()).getTime();
          var blobCache = tinymce.activeEditor.editorUpload.blobCache;
          var base64 = reader.result.split(',')[1];
          var blobInfo = blobCache.create(id, file, base64);
          blobCache.add(blobInfo);

          /* call the callback and populate the Title field with the file name */
          cb(blobInfo.blobUri(), {
            title: file.name
          });
        };
        reader.readAsDataURL(file);
      };

      input.click();
    },
    images_upload_handler: example_image_upload_handler,
  });
</script>
<!--<script>
  tinymce.init({
    selector: 'textarea#editor',
    menubar: false
  });
</script>-->

@endsection
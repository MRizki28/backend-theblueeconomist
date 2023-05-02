@extends('Layouts.Base')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form id="formTambah" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="uuid">
                            <div class="form-group">
                                <label for="Date">Date</label>
                                <input type="date" class="form-control" name="date" id="date"
                                    placeholder="Input Here.." >
                            </div>
                            
                            <div class="form-group">
                                <label for="image_article">Image</label>
                                <input type="file" class="form-control" name="image_article" id="image_article" >
                            </div>
                            <div class="form-group">
                                <label for="doc_image">Image source</label>
                                <input type="text" class="form-control" name="doc_image" id="doc_image"
                                    placeholder="Input Here" >
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title"
                                    placeholder="Input Here" >
                            </div>
                            <div class="form-group">
                                <label for="author">Author</label>
                                <input type="text" class="form-control" name="author" id="author"
                                    placeholder="Input Here" >
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <input type="hidden" name="description" id="description" >
                                <div id="summernote" ></div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Hello stand alone ui',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //tambah data
        $(document).ready(function() {
            // Mengambil form tambah data
            var formTambah = $('#formTambah');

            formTambah.on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var fileInput = $('#image_article')[0];
                if (fileInput) {
                    var fileSize = fileInput.files[0].size / 1024 / 1024; //ukuran dalam megabyte
                    if (fileSize > 2) {
                        Swal.fire({
                            title: "Error",
                            text: "Ukuran file gambar maksimal 2 MB",
                            icon: "error",
                            timer: 5000,
                            showConfirmButton: true
                        });
                        return false;
                    }
                }
                var description = $('#summernote').summernote('code');
                formData.append('description', description);

                $.ajax({
                    type: "POST",
                    url: "{{ route('tambahData.artikel') }}",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        Swal.fire({
                            title: "Success",
                            text: "Data berhasil ditambahkan",
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonText: "OK"
                        }).then(function() {
                            window.location.href = "/dashboard";
                        });
                    },
                    error: function(data) {
                        console.log(data);
                        var errors = data.responseJSON.errors;
                        var errorMessage = "";

                        $.each(errors, function(key, value) {
                            errorMessage += value + "<br>";
                        });

                        Swal.fire({
                            title: "Error",
                            html: errorMessage,
                            icon: "error",
                            timer: 5000,
                            showConfirmButton: true
                        });
                    }
                });
            });
        });
    </script>
@endsection

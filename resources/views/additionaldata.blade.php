<!DOCTYPE>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
    </head>
    <body>
        <form action="{{ url('/api/editinformation') }}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="col-md-12">
                <div class="row">
                    <input type="hidden" value="{{$data}}" name="id"/>

                    <div class="col-md-4">
                        <label for="firstname">Firstname</label>
                        <input type="text" class="form-control" id="firstname" name="firstname"/>
                    </div>

                    <div class="col-md-4">
                        <label for="lastname">Lastname</label>
                        <input type="text" class="form-control" id="lastname" name="lastname"/>
                    </div>

                    <div class="col-md-4">
                        <label for="imageupload">Profile Picture Upload</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image"/>
                    </div>

                    <div class="float-right">
                        <button class="btn btn-primary" id="save">Edit</button>
                    </div>
                </div>
            </div>
        </form>
    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // var id = {{ $data }}
        // $(document).ready(function(){
        //     $(document).on('click', '#save', function(){
        //         var firstname = $('#firstname').val();
        //         var lastname = $('#lastname').val();
        //         var profile_image = document.getElementById("profile_image").files[0].name;
        //         $.ajax({
        //             method: "POST",
        //             url: "{{ url('/api/editinformation') }}",
        //             data: {
        //                 "_token": "{{ csrf_token() }}",
        //                 firstname: firstname,
        //                 lastname: lastname,
        //                 profile_image: profile_image,
        //                 id: id
        //             }
        //         }).done(function(response){
        //             console.log(response);
        //         });
        //     })
        // });
    </script>
    </body>
</html>
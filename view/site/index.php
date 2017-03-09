<form id="uploadForm" method="post" enctype="multipart/form-data" action="/site/upload">
    <input type="file" name="file" id="file"><br>
    <p id="message"></p>
    <button type="submit" id="submitButton">Upload</button>
</form>

<script type="text/javascript">
    $(document).ready(function(){
        $('#uploadForm').submit(function(e){
            var file_data = $('#file').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);
            $.ajax({
                url: '/site/upload',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(response){
                    if(response.success){
                        $('#message').css({color:'green'});
                    }else{
                        $('#message').css({color:'red'});
                    }
                    $('#message').html(response.message);
                }
            });
            e.preventDefault();
        });
    })
</script>
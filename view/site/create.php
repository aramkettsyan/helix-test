<div class="createUser">
    <form action="/site/create" method="post" id="createForm">
        <div style="float: left;display: inline-block; margin-right:20px; ">
            <input type="hidden" name="id" value="">
            <label for="firstname">First Name</label><br>
            <input type="text" name="firstname" value=""><br><br>
            <label for="lastname">Last Name</label><br>
            <input type="text" name="lastname" value=""><br><br>
            <label for="age">Age</label><br>
            <input type="number" name="age" value=""><br><br>
            <label for="city">City</label><br>
            <input type="text" name="city" value=""><br><br>
            <label for="email">Email</label><br>
            <input type="email" name="email" value=""><br><br>
            <label for="country">Country</label><br>
            <input type="text" name="country" value=""><br><br>
        </div>
        <div style="float: left;display: inline-block">
            <label for="bankAccountNumber">Bank Account Number</label><br>
            <input type="number" name="bankAccountNumber" value=""><br><br>
            <label for="creditCardNumber">Credit Card Number</label><br>
            <input type="number" name="creditCardNumber" value=""><br><br>
            <div id="phones">
                <label>Phone Numbers</label><br>
                <input value="" name="phones[]"><br><br>
            </div>
            <button id="addPhone">Add phone number</button>
            <br><br>
            <div id="addresses">
                <label>Addresses</label><br>
                <input value="" name="addresses[]"><br><br>
            </div>
            <button id="addAddress">Add address</button>
            <br>
            <p id="message"></p>
        </div>
        <div style="clear: both">
            <p id="message"></p>
            <input style="clear: both" type="submit" id="formSubmit">
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $("#createForm").submit(function (e) {
            $('#message').html('');
            $.ajax({
                type: "POST",
                url: '/site/create',
                dataType: 'json',
                data: $("#createForm").serialize(),
                success: function (response) {
                    if (response.success) {
                        $("#createForm input").val('');
                        $('.addedAddress').remove();
                        $('.addedPhone').remove();
                        $('#message').css({color: 'green'});
                    } else {
                        $('#message').css({color: 'red'});
                    }
                    $('#message').html(response.message);
                }
            });

            e.preventDefault();
        });

        $('#addAddress').on('click', function (e) {
            $('#addresses').append('<div class="addedAddress"><input value="" name="addresses[]"> <span class="removeAddresses">remove</span><br><br></div>');
            $('.removeAddresses').on('click', function () {
                $(this).parent().remove();
            })
            e.preventDefault();
        });

        $('#addPhone').on('click', function (e) {
            $('#phones').append('<div class="addedPhone"><input value="" name="phones[]"> <span class="removePhones">remove</span><br><br></div>');
            $('.removePhones').on('click', function () {
                $(this).parent().remove();
            })
            e.preventDefault();
        });
    });

</script>
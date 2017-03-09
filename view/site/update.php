<div class="updateUser">
    <form action="/site/update" method="post" id="updateForm">
        <div style="float: left;display: inline-block; margin-right:20px; ">
            <input type="hidden" name="id" value="<?= $user['id']; ?>">
            <label for="firstname">First Name</label><br>
            <input type="text" name="firstname" value="<?= $user['firstname']; ?>"><br><br>
            <label for="lastname">Last Name</label><br>
            <input type="text" name="lastname" value="<?= $user['lastname']; ?>"><br><br>
            <label for="age">Age</label><br>
            <input type="number" name="age" value="<?= $user['age']; ?>"><br><br>
            <label for="city">City</label><br>
            <input type="text" name="city" value="<?= $user['city']; ?>"><br><br>
            <label for="email">Email</label><br>
            <input type="email" name="email" value="<?= $user['email']; ?>"><br><br>
            <label for="country">Country</label><br>
            <input type="text" name="country" value="<?= $user['country']; ?>"><br><br>
        </div>
        <div style="float: left;display: inline-block">
            <label for="bankAccountNumber">Bank Account Number</label><br>
            <input type="number" name="bankAccountNumber" value="<?= $user['bankAccountNumber']; ?>"><br><br>
            <label for="creditCardNumber">Credit Card Number</label><br>
            <input type="number" name="creditCardNumber" value="<?= $user['creditCardNumber']; ?>"><br><br>
            <div id="phones">
                <label>Phone Numbers</label><br>
                <?php foreach (unserialize($user['phones']) as $phone): ?>
                    <div>
                        <input value="<?= $phone ?>" name="phone[]"><span class="removePhones">remove</span><br><br>
                    </div>
                <?php endforeach; ?>
            </div>
            <button id="addPhone">Add phone number</button><br><br>
            <br>
            <div id="addresses">
                <label>Addresses</label><br>
                <?php foreach (unserialize($user['addresses']) as $address): ?>
                    <div>
                        <input value="<?= $address ?>" name="addresses[]"><span class="removeAddresses">remove</span><br><br>
                    </div>
                <?php endforeach; ?>
            </div>
            <button id="addAddress">Add address</button><br><br><br>
            <p id="message"></p>
            <input style="clear: both" type="submit" id="formSubmit">
        </div>
    </form>
</div>
<script type="text/javascript">
    $("#updateForm").submit(function (e) {
        $('#message').html('');
        $.ajax({
            type: "POST",
            url: '',
            dataType: 'json',
            data: $("#updateForm").serialize(),
            success: function (response) {
                if (response.success) {
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
    $('.removeAddresses').on('click', function () {
        $(this).parent().remove();
    })

    $('#addPhone').on('click', function (e) {
        $('#phones').append('<div class="addedPhone"><input value="" name="phone[]"> <span class="removePhones">remove</span><br><br></div>');
        $('.removePhones').on('click', function () {
            $(this).parent().remove();
        })
        e.preventDefault();
    });
    $('.removePhones').on('click', function () {
        $(this).parent().remove();
    })
</script>
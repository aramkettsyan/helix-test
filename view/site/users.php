<div class="usersContent">
    <a href="/site/create">Create New User</a><br>
    <a href="#" class="deleteUsers">Delete Selected Users</a>

    <p id="message"></p>

    <table border="1" class="usersList">
        <tr>
            <th><input type="checkbox" id="selectAll"></th>
            <th>First name</th>
            <th>Last name</th>
            <th>Age</th>
            <th>City</th>
            <th>Email</th>
            <th>Country</th>
            <th>Bank Account Number</th>
            <th>Credit Card Number</th>
            <th>Phones</th>
            <th>Addresses</th>
            <th>Actions</th>
        </tr>
        <tr class="search">
            <td></td>
            <td><input type="text" class="firstname" placeholder="First Name"></td>
            <td><input type="text" class="lastname" placeholder="Last Name"></td>
            <td><input type="text" class="age" placeholder="Age"></td>
            <td><input type="text" class="city" placeholder="City"></td>
            <td><input type="text" class="email" placeholder="Email"></td>
            <td><input type="text" class="country" placeholder="Country"></td>
            <td><input type="text" class="bankAccountNumber" placeholder="Bank Account Number"></td>
            <td><input type="text" class="creditCardNumber" placeholder="Credit Card Number"></td>
            <td><input type="text" class="phones" placeholder="Phones"></td>
            <td><input type="text" class="addresses" placeholder="Addresses"></td>
            <td></td>
        </tr>
        <?php if ($users): ?>
            <?php foreach ($users as $u): ?>
                <tr id="<?= $u['id'] ?>" class="user">
                    <td><input type="checkbox" class="checkbox" data-id="<?= $u['id'] ?>"></td>
                    <td class="firstname"><?= $u['firstname'] ?></td>
                    <td class="lastname"><?= $u['lastname'] ?></td>
                    <td class="age"><?= $u['age'] ?></td>
                    <td class="city"><?= $u['city'] ?></td>
                    <td class="email"><?= $u['email'] ?></td>
                    <td class="country"><?= $u['country'] ?></td>
                    <td class="bankAccountNumber"><?= $u['bankAccountNumber'] ?></td>
                    <td class="creditCardNumber"><?= $u['creditCardNumber'] ?></td>
                    <td class="phones">
                        <?php foreach (unserialize($u['phones']) as $phone): ?>
                            <p><?= $phone ?></p>
                        <?php endforeach; ?>
                    </td>
                    <td class="addresses">
                        <?php foreach (unserialize($u['addresses']) as $address): ?>
                            <p><?= $address ?></p>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <a href="/site/update?id=<?= $u['id'] ?>">Update</a>
                        <a href="#" class='deleteUser' data-id="<?= $u['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td>There are no users.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<script type="text/javascript">
    var ids = [];
    var allSelected = false;

    $('.deleteUsers').on('click', function (e) {
        if (confirm('Are you sure?')) {

            $('.user').each(function () {
                console.log($(this).find('.checkbox').is(':checked'));
                if ($(this).find('.checkbox').is(':checked')) {
                    ids.push($(this).prop('id'));
                }
            });
            console.log(ids);

            $.ajax({
                type: "POST",
                url: '/site/delete',
                dataType: 'json',
                data: {ids: ids},
                success: function (response) {
                    if (response.success) {
                        $('#message').css({color: 'green'});
                        $('.user').each(function () {
                            if ($(this).find('.checkbox').is(':checked')) {
                                $(this).remove();
                            }
                        });
                    } else {
                        $('#message').css({color: 'red'});
                    }
                    $('#message').html(response.message);
                }
            });
        }
        e.preventDefault();

    });


    $('.deleteUser').on('click', function (e) {
        if (confirm('Are you sure?')) {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: '/site/delete',
                dataType: 'json',
                data: {ids: [id]},
                success: function (response) {
                    if (response.success) {
                        $('#' + id).remove();
                        $('#message').css({color: 'green'});
                    } else {
                        $('#message').css({color: 'red'});
                    }
                    $('#message').html(response.message);
                }
            });
        }
        e.preventDefault();

    });

    $('#selectAll').on('click', function () {
        if (!allSelected) {
            $('input[type="checkbox"]').prop({checked: 'checked'});
            allSelected = true;
        } else {
            $('input[type="checkbox"]').prop("checked", false);
            allSelected = false;
        }
    })


    $('.search input').on('keyup', function (e) {
        if (e.keyCode == 8) {
            $('.user .' + $(this).prop('class')).parent().css('display', 'table-row');
            $('.search input').each(function () {
                $('.user .' + $(this).prop('class') + ':not(:contains("' + $(this).val() + '"))').parent().css('display', 'none');
            });
        } else {
            $('.search input').each(function () {
                $('.user .' + $(this).prop('class') + ':not(:contains("' + $(this).val() + '"))').parent().css('display', 'none');
            });
        }
    })
</script>